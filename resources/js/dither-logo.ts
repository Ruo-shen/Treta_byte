// Dithered logo: turns the brand mark into a field of tiny dots, with cursor push and click ripples.
// How it works: draw the mark into a small grid as a lit "luma" field, run Floyd-Steinberg error diffusion on it so
// brightness becomes dot density, then draw one dot per surviving cell on a canvas. Decorative only: without JS (or with
// reduced motion for the interaction) the plain <img> or the static dots remain.
type Dot = { x: number; y: number }

const PUSH_RADIUS = 90
const PUSH_FORCE = 26
const RIPPLE_SPEED = 260
const RIPPLE_WIDTH = 40
const RIPPLE_FORCE = 18
const RIPPLE_MS = 700
const EASE = 0.12

const reduced = matchMedia("(prefers-reduced-motion: reduce)")

function lumaField(img: HTMLImageElement, grid: number): { luma: Float32Array; inside: Uint8Array } {
  const c = document.createElement("canvas")
  c.width = grid
  c.height = grid
  const g = c.getContext("2d", { willReadFrequently: true })!

  // Mark silhouette (alpha) at ~58% of the tile, softly blurred so its edge dithers instead of aliasing.
  const size = grid * 0.58
  const off = (grid - size) / 2
  g.filter = `blur(${grid * 0.006}px)`
  g.drawImage(img, off, off, size, size)
  g.filter = "none"
  const mark = g.getImageData(0, 0, grid, grid).data

  const luma = new Float32Array(grid * grid)
  const inside = new Uint8Array(grid * grid)
  const radius = grid * 0.24

  for (let y = 0; y < grid; y++) {
    for (let x = 0; x < grid; x++) {
      const i = y * grid + x
      // Rounded-square tile mask.
      const dx = Math.max(radius - x, 0, x - (grid - 1 - radius))
      const dy = Math.max(radius - y, 0, y - (grid - 1 - radius))
      if (dx * dx + dy * dy > radius * radius) continue
      inside[i] = 1

      // Light falls from the top-left: bright (few dots) there, dark (many dots) toward the bottom-right.
      const light = Math.min(1, 1.12 - 0.5 * ((x + y) / (2 * grid)))
      const a = mark[i * 4 + 3] / 255
      const cx = x / grid - 0.5
      const cy = y / grid - 0.5
      const ambient = 20 * Math.exp(-(cx * cx + cy * cy) / 0.08)
      luma[i] = Math.min(255, ambient + 255 * light * a)
    }
  }
  return { luma, inside }
}

// Floyd-Steinberg, serpentine. Returns a 1 for every cell that stays bright.
function dither(luma: Float32Array, inside: Uint8Array, grid: number, threshold: number): Uint8Array {
  const v = Float32Array.from(luma)
  const on = new Uint8Array(grid * grid)
  const spread = (x: number, y: number, e: number) => {
    if (x < 0 || x >= grid || y >= grid) return
    const i = y * grid + x
    if (inside[i]) v[i] += e
  }
  for (let y = 0; y < grid; y++) {
    const ltr = y % 2 === 0
    const step = ltr ? 1 : -1
    for (let x = ltr ? 0 : grid - 1; x >= 0 && x < grid; x += step) {
      const i = y * grid + x
      if (!inside[i]) continue
      const bright = v[i] > threshold
      on[i] = bright ? 1 : 0
      const err = v[i] - (bright ? 255 : 0)
      spread(x + step, y, (err * 7) / 16)
      spread(x - step, y + 1, (err * 3) / 16)
      spread(x, y + 1, (err * 5) / 16)
      spread(x + step, y + 1, err / 16)
    }
  }
  return on
}

function setup(root: HTMLElement) {
  const canvas = root.querySelector<HTMLCanvasElement>("canvas")
  const ctx = canvas?.getContext("2d")
  const src = root.dataset.ditherSrc
  if (!canvas || !ctx || !src) return

  const grid = Number(root.dataset.ditherGrid ?? 170)
  const color = root.dataset.ditherColor ?? "#0a6fb0"
  const img = new Image()
  img.decoding = "async"

  let dots: Dot[] = []
  let offX = new Float32Array(0)
  let offY = new Float32Array(0)
  let side = 0
  let dpr = 1
  let size = 1
  const cursor = { x: 0, y: 0, active: false }
  const ripples: { x: number; y: number; t: number }[] = []
  let running = false
  let settle = EASE

  const build = () => {
    side = Math.round(root.clientWidth)
    if (!side) return
    dpr = Math.min(devicePixelRatio || 1, 2)
    canvas.width = Math.round(side * dpr)
    canvas.height = Math.round(side * dpr)
    canvas.style.width = `${side}px`
    canvas.style.height = `${side}px`

    const { luma, inside } = lumaField(img, grid)
    const on = dither(luma, inside, grid, 128)
    const cell = side / grid
    size = Math.max(0.6, cell * 0.4)
    dots = []
    for (let y = 0; y < grid; y++) {
      for (let x = 0; x < grid; x++) {
        const i = y * grid + x
        // The mark is the lit area; dots fill the dark tile around and inside it.
        if (inside[i] && !on[i]) dots.push({ x: (x + 0.5) * cell, y: (y + 0.5) * cell })
      }
    }
    offX = new Float32Array(dots.length)
    offY = new Float32Array(dots.length)
    root.classList.add("is-ready")
    draw()
  }

  const draw = () => {
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0)
    ctx.clearRect(0, 0, side, side)
    ctx.fillStyle = color
    ctx.beginPath()
    for (let i = 0; i < dots.length; i++) {
      const px = dots[i].x + offX[i]
      const py = dots[i].y + offY[i]
      ctx.moveTo(px + size, py)
      ctx.arc(px, py, size, 0, Math.PI * 2)
    }
    ctx.fill()
  }

  const step = (now: number): boolean => {
    for (let k = ripples.length - 1; k >= 0; k--) if (now - ripples[k].t > RIPPLE_MS) ripples.splice(k, 1)
    let moving = ripples.length > 0 || cursor.active
    for (let i = 0; i < dots.length; i++) {
      let fx = 0
      let fy = 0
      const px = dots[i].x + offX[i]
      const py = dots[i].y + offY[i]
      if (cursor.active) {
        const vx = px - cursor.x
        const vy = py - cursor.y
        const d2 = vx * vx + vy * vy
        if (d2 > 0.1 && d2 < PUSH_RADIUS * PUSH_RADIUS) {
          const d = Math.sqrt(d2)
          const f = (1 - d / PUSH_RADIUS) ** 3 * PUSH_FORCE
          fx += (vx / d) * f
          fy += (vy / d) * f
        }
      }
      for (const r of ripples) {
        const age = now - r.t
        const rx = dots[i].x - r.x
        const ry = dots[i].y - r.y
        const d = Math.hypot(rx, ry)
        if (d < 0.1) continue
        const band = Math.abs(d - (age / 1000) * RIPPLE_SPEED)
        if (band < RIPPLE_WIDTH) {
          const w = (1 - band / RIPPLE_WIDTH) * (1 - age / RIPPLE_MS) * RIPPLE_FORCE
          fx += (rx / d) * w
          fy += (ry / d) * w
        }
      }
      offX[i] += (fx - offX[i]) * settle
      offY[i] += (fy - offY[i]) * settle
      if (Math.abs(offX[i]) < 0.01) offX[i] = 0
      if (Math.abs(offY[i]) < 0.01) offY[i] = 0
      if (offX[i] !== 0 || offY[i] !== 0) moving = true
    }
    return moving
  }

  const run = () => {
    if (running || reduced.matches) return
    running = true
    const tick = (now: number) => {
      const more = step(now)
      draw()
      if (more) requestAnimationFrame(tick)
      else {
        running = false
        settle = EASE
      }
    }
    requestAnimationFrame(tick)
  }

  // Entrance: dots start scattered and drift home once the tile scrolls into view.
  const scatter = () => {
    if (reduced.matches) return
    for (let i = 0; i < dots.length; i++) {
      const a = Math.random() * Math.PI * 2
      const d = 30 + Math.random() * 90
      offX[i] = Math.cos(a) * d
      offY[i] = Math.sin(a) * d
    }
    settle = 0.045
    run()
  }

  const local = (e: PointerEvent) => {
    const r = canvas.getBoundingClientRect()
    cursor.x = e.clientX - r.left
    cursor.y = e.clientY - r.top
  }
  canvas.addEventListener("pointermove", (e) => {
    local(e)
    cursor.active = true
    run()
  })
  canvas.addEventListener("pointerleave", () => {
    cursor.active = false
    run()
  })
  canvas.addEventListener("pointerup", (e) => {
    local(e)
    ripples.push({ x: cursor.x, y: cursor.y, t: performance.now() })
    if (e.pointerType !== "mouse") cursor.active = false
    run()
  })

  img.onload = () => {
    build()
    if (!dots.length) return
    new IntersectionObserver((entries, io) => {
      if (entries.some((e) => e.isIntersecting)) {
        io.disconnect()
        scatter()
      }
    }, { threshold: 0.3 }).observe(root)
    let last = side
    new ResizeObserver(() => {
      if (Math.round(root.clientWidth) === last) return
      last = Math.round(root.clientWidth)
      build()
    }).observe(root)
  }
  img.src = src
}

document.querySelectorAll<HTMLElement>("[data-dither-src]").forEach(setup)

export {}
