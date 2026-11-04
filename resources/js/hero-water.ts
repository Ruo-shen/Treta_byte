// Hero water: draws the rising photo stream and the liquid sky in WebGL so the pointer can ripple the whole scene.
// The DOM tiles stay as the fallback (no WebGL, reduced motion, context loss). Frames run only while the hero is visible.
const stage = document.querySelector<HTMLElement>("[data-hero-field]")

const canvas = stage?.querySelector<HTMLCanvasElement>("[data-hero-water]")

type Tile = {
  x: number
  w: number
  a: number
  r: number
  d: number
  ph: number
  layer: number
  src: string
  cell: number
}

const MAX = 24

const CELL = 256

const GRID_W = 112

const AMP = 0.6

const VERT = `attribute vec2 a; void main(){ gl_Position = vec4(a, 0., 1.); }`

const FRAG = `
#ifdef GL_FRAGMENT_PRECISION_HIGH
precision highp float;
#else
precision mediump float;
#endif
uniform vec2 uSize;
uniform float uScale;
uniform sampler2D uAtlas;
uniform sampler2D uWave;
uniform vec2 uGrid;
uniform float uStrength;
uniform int uCount;
uniform vec4 uA[${MAX}];
uniform vec4 uB[${MAX}];
uniform vec4 uBlob[4];
uniform vec2 uMask;

float box(vec2 q, vec2 hs, float r) {
  vec2 d = abs(q) - hs + r;
  return length(max(d, 0.)) + min(max(d.x, d.y), 0.) - r;
}
float hgt(vec2 uv) { return (texture2D(uWave, uv).r - .5) * 2.; }

void main() {
  vec2 p = vec2(gl_FragCoord.x, uSize.y * uScale - gl_FragCoord.y) / uScale;
  vec2 uv = p / uSize;
  vec2 e = 1. / uGrid;
  vec2 g = vec2(
    hgt(uv + vec2(e.x, 0.)) - hgt(uv - vec2(e.x, 0.)),
    hgt(uv + vec2(0., e.y)) - hgt(uv - vec2(0., e.y))
  );
  vec2 disp = g * uStrength;
  disp *= min(1., 20. / max(length(disp), .0001));
  p += disp;
  vec2 uv2 = p / uSize;

  vec3 col = vec3(.788, .894, .969);
  vec3 bc0 = vec3(.043, .471, .722);
  vec3 bc1 = vec3(1.);
  vec3 bc2 = vec3(.561, .804, .961);
  vec3 bc3 = vec3(.804, .290, .259);
  float t0 = clamp(1. - distance(p, uBlob[0].xy) / uBlob[0].z, 0., 1.) * uBlob[0].w;
  col = mix(col, bc0, t0);
  float t1 = clamp(1. - distance(p, uBlob[1].xy) / uBlob[1].z, 0., 1.) * uBlob[1].w;
  col = mix(col, bc1, t1);
  float t2 = clamp(1. - distance(p, uBlob[2].xy) / uBlob[2].z, 0., 1.) * uBlob[2].w;
  col = mix(col, bc2, t2);
  float t3 = clamp(1. - distance(p, uBlob[3].xy) / uBlob[3].z, 0., 1.) * uBlob[3].w;
  col = mix(col, bc3, t3);

  float rad = clamp((length((uv2 - .5) / uMask) - .55) / .45, 0., 1.);
  float vert = clamp(uv2.y / .14, 0., 1.) * (1. - clamp((uv2.y - .78) / .22, 0., 1.));
  float mk = rad * vert;

  for (int i = 0; i < ${MAX}; i++) {
    if (i >= uCount) break;
    vec4 A = uA[i];
    vec4 B = uB[i];
    vec2 d = p - A.xy;
    if (dot(d, d) > A.z * A.z + A.w * A.w + 2400.) continue;
    float c = cos(B.x);
    float s = sin(B.x);
    vec2 q = vec2(c * d.x + s * d.y, -s * d.x + c * d.y);
    if (B.z < .5) {
      float ds = box(q - vec2(0., 14.), A.zw, 14.);
      col = mix(col, vec3(.035, .396, .612), (1. - smoothstep(-8., 26., ds)) * .2 * B.w * mk);
    }
    float soft = .7 + B.z * 3.;
    float aOut = 1. - smoothstep(-soft, soft, box(q, A.zw, 14.));
    vec3 tc;
    if (B.y < 0.) {
      tc = vec3(.804, .290, .259);
    } else {
      vec2 hs = A.zw - 3.;
      float aIn = 1. - smoothstep(-soft, soft, box(q, hs, 11.));
      float asp = hs.x / hs.y;
      vec2 sc = asp >= 1. ? vec2(1., 1. / asp) : vec2(asp, 1.);
      vec2 cu = .5 + .5 * (q / hs) * sc * .97;
      vec2 org = vec2(mod(B.y, 4.), floor(B.y / 4.));
      vec3 ph = texture2D(uAtlas, (org + clamp(cu, .01, .99)) / 4., B.z).rgb;
      tc = mix(vec3(1.), ph, aIn);
    }
    col = mix(col, tc, aOut * B.w * mk);
  }

  col += vec3(clamp((g.x + g.y) * .3, -.07, .07));
  gl_FragColor = vec4(col, 1.);
}
`

const reduced = matchMedia("(prefers-reduced-motion: reduce)").matches

const loadImage = (src: string) =>
  new Promise<HTMLImageElement>((resolve) => {
    const img = new Image()

    img.onload = () => resolve(img)

    img.onerror = () => resolve(img)

    img.src = src
  })

const start = async (stageEl: HTMLElement, canvasEl: HTMLCanvasElement) => {
  const gl = canvasEl.getContext("webgl", { antialias: false, alpha: false })

  if (!gl) return

  const read = (el: HTMLElement, name: string) =>
    el.style.getPropertyValue(name)

  const tiles: Tile[] = [...stageEl.querySelectorAll<HTMLElement>(".sf-tile")]
    .slice(0, MAX)
    .map((el) => {
      const [an, ad] = read(el, "--a").split("/").map(parseFloat)

      return {
        x: parseFloat(read(el, "--x")),
        w: parseFloat(read(el, "--w")),
        a: an / (ad || 1),
        r: parseFloat(read(el, "--r")),
        d: parseFloat(read(el, "--d")),
        ph: parseFloat(read(el, "--ph")),
        layer: el.classList.contains("sf-far")
          ? 0
          : el.classList.contains("sf-mid")
            ? 1
            : 2,
        src: el.querySelector("img")?.getAttribute("src") ?? "",
        cell: -1,
      }
    })
    .sort((p, q) => p.layer - q.layer)

  const srcs = [...new Set(tiles.map((t) => t.src).filter(Boolean))].slice(
    0,
    16,
  )

  const images = await Promise.all(srcs.map(loadImage))

  const atlas = document.createElement("canvas")

  atlas.width = atlas.height = CELL * 4

  const actx = atlas.getContext("2d")

  if (!actx) return

  images.forEach((img, i) => {
    if (!img.naturalWidth) return

    const s = Math.max(CELL / img.naturalWidth, CELL / img.naturalHeight)

    const dw = img.naturalWidth * s

    const dh = img.naturalHeight * s

    actx.drawImage(
      img,
      (i % 4) * CELL + (CELL - dw) / 2,
      Math.floor(i / 4) * CELL + (CELL - dh) / 2,
      dw,
      dh,
    )
  })

  tiles.forEach((t) => (t.cell = t.src ? srcs.indexOf(t.src) : -1))

  const compile = (type: number, source: string) => {
    const sh = gl.createShader(type)

    if (!sh) throw new Error("shader")

    gl.shaderSource(sh, source)

    gl.compileShader(sh)

    if (!gl.getShaderParameter(sh, gl.COMPILE_STATUS))
      throw new Error(gl.getShaderInfoLog(sh) ?? "compile")

    return sh
  }

  const program = gl.createProgram()

  gl.attachShader(program, compile(gl.VERTEX_SHADER, VERT))

  gl.attachShader(program, compile(gl.FRAGMENT_SHADER, FRAG))

  gl.linkProgram(program)

  if (!gl.getProgramParameter(program, gl.LINK_STATUS)) throw new Error("link")

  gl.useProgram(program)

  const buffer = gl.createBuffer()

  gl.bindBuffer(gl.ARRAY_BUFFER, buffer)

  gl.bufferData(
    gl.ARRAY_BUFFER,
    new Float32Array([-1, -1, 3, -1, -1, 3]),
    gl.STATIC_DRAW,
  )

  const attr = gl.getAttribLocation(program, "a")

  gl.enableVertexAttribArray(attr)

  gl.vertexAttribPointer(attr, 2, gl.FLOAT, false, 0, 0)

  const U = (name: string) => gl.getUniformLocation(program, name)

  const uSize = U("uSize")

  const uScale = U("uScale")

  const uGrid = U("uGrid")

  const uStrength = U("uStrength")

  const uCount = U("uCount")

  const uA = U("uA[0]")

  const uB = U("uB[0]")

  const uBlob = U("uBlob[0]")

  const uMask = U("uMask")

  gl.activeTexture(gl.TEXTURE0)

  const atlasTex = gl.createTexture()

  gl.bindTexture(gl.TEXTURE_2D, atlasTex)

  gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, atlas)

  gl.generateMipmap(gl.TEXTURE_2D)

  gl.texParameteri(
    gl.TEXTURE_2D,
    gl.TEXTURE_MIN_FILTER,
    gl.LINEAR_MIPMAP_LINEAR,
  )

  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR)

  gl.uniform1i(U("uAtlas"), 0)

  gl.activeTexture(gl.TEXTURE1)

  const waveTex = gl.createTexture()

  gl.bindTexture(gl.TEXTURE_2D, waveTex)

  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR)

  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR)

  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_S, gl.CLAMP_TO_EDGE)

  gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_WRAP_T, gl.CLAMP_TO_EDGE)

  gl.uniform1i(U("uWave"), 1)

  gl.pixelStorei(gl.UNPACK_ALIGNMENT, 1)

  let W = 0

  let H = 0

  let scale = 1

  let gw = GRID_W

  let gh = 2

  let cur = new Float32Array(0)

  let prev = new Float32Array(0)

  let bytes = new Uint8Array(0)

  let sponge = new Float32Array(0)

  let tick = 0

  let active = false

  let dirty = true

  const A = new Float32Array(MAX * 4)

  const B = new Float32Array(MAX * 4)

  const blobs = new Float32Array(16)

  const resize = () => {
    const box = stageEl.getBoundingClientRect()

    W = box.width

    H = box.height

    scale = Math.min(devicePixelRatio || 1, 1)

    canvasEl.width = Math.round(W * scale)

    canvasEl.height = Math.round(H * scale)

    gl.viewport(0, 0, canvasEl.width, canvasEl.height)

    gh = Math.max(2, Math.round((GRID_W * H) / W))

    cur = new Float32Array(gw * gh)

    prev = new Float32Array(gw * gh)

    bytes = new Uint8Array(gw * gh).fill(128)

    // Absorbing rim: waves fade out before the edge, so nothing bounces back.
    sponge = new Float32Array(gw * gh)

    for (let y = 0; y < gh; y++)
      for (let x = 0; x < gw; x++) {
        const f = Math.min(1, Math.min(x, y, gw - 1 - x, gh - 1 - y) / 12)

        sponge[y * gw + x] = f * f * (3 - 2 * f)
      }

    gl.activeTexture(gl.TEXTURE1)

    gl.texImage2D(
      gl.TEXTURE_2D,
      0,
      gl.LUMINANCE,
      gw,
      gh,
      0,
      gl.LUMINANCE,
      gl.UNSIGNED_BYTE,
      bytes,
    )

    active = false

    dirty = true
  }

  const splat = (x: number, y: number, amp: number) => {
    const cx = (x / W) * gw

    const cy = (y / H) * gh

    for (let j = -2; j <= 2; j++)
      for (let i = -2; i <= 2; i++) {
        const gx = Math.round(cx) + i

        const gy = Math.round(cy) + j

        if (gx < 1 || gy < 1 || gx >= gw - 1 || gy >= gh - 1) continue

        cur[gy * gw + gx] = Math.max(
          -AMP,
          cur[gy * gw + gx] -
            amp * Math.exp(-((gx - cx) ** 2 + (gy - cy) ** 2) / 1.7),
        )
      }

    active = true
  }

  let lastX = -1

  let lastY = -1

  stageEl.addEventListener("pointermove", (event) => {
    const box = stageEl.getBoundingClientRect()

    const x = event.clientX - box.left

    const y = event.clientY - box.top

    if (lastX >= 0) {
      const dist = Math.hypot(x - lastX, y - lastY)

      const steps = Math.max(1, Math.ceil(dist / 14))

      const amp = Math.min(0.12 + dist * 0.008, 0.4)

      for (let s = 1; s <= steps; s++)
        splat(
          lastX + ((x - lastX) * s) / steps,
          lastY + ((y - lastY) * s) / steps,
          amp,
        )
    }

    lastX = x

    lastY = y
  })

  stageEl.addEventListener("pointerleave", () => {
    lastX = -1
  })

  stageEl.addEventListener("pointerdown", (event) => {
    const box = stageEl.getBoundingClientRect()

    splat(event.clientX - box.left, event.clientY - box.top, 0.2)
  })

  const step = () => {
    let peak = 0

    for (let y = 1; y < gh - 1; y++)
      for (let x = 1; x < gw - 1; x++) {
        const i = y * gw + x

        const n =
          (cur[i - 1] + cur[i + 1] + cur[i - gw] + cur[i + gw]) * 0.5 - prev[i]

        const v = Math.max(-AMP, Math.min(AMP, n * 0.94 * sponge[i]))

        prev[i] = v

        const m = Math.abs(v)

        if (m > peak) peak = m
      }

    const tmp = cur

    cur = prev

    prev = tmp

    if (peak < 0.0008) {
      cur.fill(0)

      prev.fill(0)

      active = false
    }
  }

  const t0 = performance.now()

  let frameId = 0

  let visible = true

  const frame = (now: number) => {
    frameId = 0

    // Idle (no ripple): the stream drifts slowly, so 30fps is plenty.

    if (!active && !dirty && tick++ % 2) {
      wake()

      return
    }

    const t = (now - t0) / 1000

    const vh = innerHeight

    const cq = W / 100

    if (active || dirty) {
      if (active) step()

      for (let i = 0; i < cur.length; i++)
        bytes[i] = Math.max(0, Math.min(255, 128 + cur[i] * 127))

      gl.activeTexture(gl.TEXTURE1)

      gl.texSubImage2D(
        gl.TEXTURE_2D,
        0,
        0,
        0,
        gw,
        gh,
        gl.LUMINANCE,
        gl.UNSIGNED_BYTE,
        bytes,
      )

      dirty = active
    }

    tiles.forEach((tile, i) => {
      const p = (t / tile.d + tile.ph) % 1

      const w = Math.max((W * tile.w) / 1440, tile.w * 0.6)

      const h = w / tile.a

      const top = ((108 - p * 130) / 100) * vh

      A.set([(tile.x / 100) * W + w / 2, top + h / 2, w / 2, h / 2], i * 4)

      B.set(
        [
          (tile.r * Math.PI) / 180,
          tile.cell,
          tile.layer === 0 ? 2 : 0,
          tile.layer === 0 ? 0.7 : 1,
        ],
        i * 4,
      )
    })

    const bl = (
      i: number,
      bx: number,
      by: number,
      r: number,
      alpha: number,
      amp: number,
      period: number,
      delay: number,
    ) => {
      const k = ((t + delay) / period) * Math.PI * 2

      blobs.set(
        [bx + amp * Math.sin(k), by + amp * 0.7 * Math.cos(k), r, alpha],
        i * 4,
      )
    }

    bl(0, 17 * cq, 9 * cq, 31 * cq, 0.5, 9 * cq, 28, 0)

    bl(1, 89 * cq, 35 * cq, 29 * cq, 0.85, 9 * cq, 34, -9)

    bl(2, 51 * cq, H - 7 * cq, 33 * cq, 0.9, 9 * cq, 31, -15)

    bl(3, 79 * cq, H - 3 * cq, 17 * cq, 0.22, 7 * cq, 38, -21)

    gl.uniform2f(uSize, W, H)

    gl.uniform1f(uScale, scale)

    gl.uniform2f(uGrid, gw, gh)

    gl.uniform1f(uStrength, 64)

    gl.uniform1i(uCount, tiles.length)

    gl.uniform4fv(uA, A)

    gl.uniform4fv(uB, B)

    gl.uniform4fv(uBlob, blobs)

    gl.uniform2f(uMask, W < 768 ? 0.78 : 0.46, W < 768 ? 0.46 : 0.38)

    gl.drawArrays(gl.TRIANGLES, 0, 3)

    if (visible && !document.hidden) frameId = requestAnimationFrame(frame)
  }

  const wake = () => {
    if (!frameId && visible && !document.hidden)
      frameId = requestAnimationFrame(frame)
  }

  new ResizeObserver(() => {
    resize()

    wake()
  }).observe(stageEl)

  new IntersectionObserver(([entry]) => {
    visible = entry.isIntersecting

    wake()
  }).observe(stageEl)

  document.addEventListener("visibilitychange", wake)

  canvasEl.addEventListener("webglcontextlost", (event) => {
    event.preventDefault()

    stageEl.classList.remove("sf-gl")

    cancelAnimationFrame(frameId)

    visible = false
  })

  resize()

  frame(performance.now())

  stageEl.classList.add("sf-gl")
}

if (stage && canvas && !reduced)
  start(stage, canvas).catch(() => stage.classList.remove("sf-gl"))
