// Work list hover preview: a cover image follows the cursor (eased) and swaps per row; keyboard focus shows it beside the row.
const list = document.querySelector<HTMLElement>("[data-work-list]")
const preview = document.querySelector<HTMLElement>("[data-work-preview]")

if (list && preview && matchMedia("(hover: hover) and (pointer: fine)").matches) {
  const reduced = matchMedia("(prefers-reduced-motion: reduce)")
  const images = [...preview.querySelectorAll<HTMLImageElement>("img")]
  const rows = [...list.querySelectorAll<HTMLElement>("[data-work-row]")]
  const slugOf = (row: HTMLElement) =>
    row.querySelector<HTMLAnchorElement>("a")?.getAttribute("href")?.split("/").pop() ?? ""

  let x = 0
  let y = 0
  let tx = 0
  let ty = 0
  let frame = 0

  const render = () => {
    const w = preview.offsetWidth
    const h = preview.offsetHeight
    // Sit to the right of the cursor, kept inside the viewport.
    const px = Math.min(Math.max(x + 28, 8), innerWidth - w - 8)
    const py = Math.min(Math.max(y - h / 2, 8), innerHeight - h - 8)
    const tilt = Math.max(-6, Math.min(6, (tx - x) * 0.06))
    preview.style.transform = `translate3d(${px}px, ${py}px, 0) rotate(${tilt}deg)`
  }

  const loop = () => {
    x += (tx - x) * 0.16
    y += (ty - y) * 0.16
    render()
    frame = Math.abs(tx - x) + Math.abs(ty - y) > 0.3 ? requestAnimationFrame(loop) : 0
  }

  const move = (nx: number, ny: number, snap = false) => {
    tx = nx
    ty = ny
    if (snap || reduced.matches) {
      x = nx
      y = ny
      render()
    } else if (!frame) {
      frame = requestAnimationFrame(loop)
    }
  }

  const show = (row: HTMLElement) => {
    const slug = slugOf(row)
    let any = false
    for (const img of images) {
      const on = img.dataset.slug === slug
      img.classList.toggle("is-active", on)
      any ||= on
    }
    preview.classList.toggle("is-on", any)
  }
  const hide = () => preview.classList.remove("is-on")

  for (const row of rows) {
    row.addEventListener("pointerenter", (e) => {
      if (!preview.classList.contains("is-on")) move(e.clientX, e.clientY, true)
      show(row)
    })
    row.addEventListener("pointermove", (e) => move(e.clientX, e.clientY))
    row.addEventListener("focusin", () => {
      const r = row.getBoundingClientRect()
      move(r.right - 380, r.top + r.height / 2, true)
      show(row)
    })
  }
  list.addEventListener("pointerleave", hide)
  list.addEventListener("focusout", (e) => {
    if (!list.contains(e.relatedTarget as Node | null)) hide()
  })
}

export {}
