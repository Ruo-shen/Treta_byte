// Footer wordmark drawn as a dot-matrix: the word is rasterised off-screen, sampled on a grid and drawn as dots.
// Decorative only; without JS the plain text stays visible (see footer.blade.php).
const root = document.querySelector<HTMLElement>("[data-dot-word]")

if (root) {
  const word = root.dataset.dotWord ?? ""
  const canvas = root.querySelector<HTMLCanvasElement>("canvas")
  const ctx = canvas?.getContext("2d")
  const reduced = matchMedia("(prefers-reduced-motion: reduce)")
  const family = getComputedStyle(document.body).fontFamily
  const ink = "19 26 33"

  type Dot = { x: number; y: number; r: number }
  let dots: Dot[] = []
  let width = 0
  let height = 0
  let dpr = 1
  let reveal = 1
  let frame = 0

  const build = () => {
    if (!canvas || !ctx) return
    width = Math.round(root.clientWidth)
    if (!width) return
    dpr = Math.min(window.devicePixelRatio || 1, 2)

    // Fit the word to the container width, capped so the footer does not grow too tall.
    const probe = document.createElement("canvas").getContext("2d")!
    probe.font = `700 100px ${family}`
    probe.letterSpacing = "12px"
    const wordWidth = probe.measureText(word).width
    const size = Math.min((width / wordWidth) * 100, 300)
    height = Math.ceil(size * 0.78)

    const off = document.createElement("canvas")
    off.width = width
    off.height = height
    const o = off.getContext("2d", { willReadFrequently: true })!
    o.font = `700 ${size}px ${family}`
    o.letterSpacing = `${size * 0.12}px`
    o.textBaseline = "alphabetic"
    const textWidth = o.measureText(word).width
    o.fillText(word, (width - textWidth) / 2, size * 0.74)
    const data = o.getImageData(0, 0, width, height).data

    const pitch = Math.max(4, Math.min(7, width / 200))
    dots = []
    for (let y = pitch / 2; y < height; y += pitch) {
      for (let x = pitch / 2; x < width; x += pitch) {
        const a = data[(Math.floor(y) * width + Math.floor(x)) * 4 + 3]
        if (a > 40) dots.push({ x, y, r: pitch * 0.36 * (0.55 + (0.45 * a) / 255) })
      }
    }

    canvas.width = Math.round(width * dpr)
    canvas.height = Math.round(height * dpr)
    canvas.style.width = `${width}px`
    canvas.style.height = `${height}px`
    root.classList.add("is-ready")
    draw()
  }

  const draw = () => {
    if (!canvas || !ctx) return
    ctx.setTransform(dpr, 0, 0, dpr, 0, 0)
    ctx.clearRect(0, 0, width, height)
    for (const d of dots) {
      // Left-to-right reveal: each dot scales in once the sweep passes it.
      const grow = Math.max(0, Math.min(1, (reveal * 1.4 - d.x / width) * 5))
      if (!grow) continue
      ctx.fillStyle = `rgb(${ink})`
      ctx.beginPath()
      ctx.arc(d.x, d.y, d.r * grow, 0, Math.PI * 2)
      ctx.fill()
    }
  }

  const play = () => {
    if (reduced.matches) {
      reveal = 1
      draw()
      return
    }
    reveal = 0
    const start = performance.now()
    const step = (now: number) => {
      reveal = Math.min(1, (now - start) / 1400)
      draw()
      if (reveal < 1) frame = requestAnimationFrame(step)
    }
    frame = requestAnimationFrame(step)
  }

  const init = async () => {
    try {
      await document.fonts.load(`700 100px ${family}`)
    } catch {
      // Fall back to whatever font is available.
    }
    build()
    if (!dots.length) return
    reveal = reduced.matches ? 1 : 0
    draw()

    new IntersectionObserver((entries, observer) => {
      if (entries.some((e) => e.isIntersecting)) {
        observer.disconnect()
        play()
      }
    }, { threshold: 0.25 }).observe(root)

    new ResizeObserver(() => {
      if (Math.round(root.clientWidth) === width) return
      const keep = reveal
      build()
      reveal = keep
      draw()
    }).observe(root)
  }

  void init()
}

export {}
