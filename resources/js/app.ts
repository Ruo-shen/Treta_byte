const header = document.querySelector("header")
const toggle = document.querySelector<HTMLButtonElement>("[data-menu-toggle]")
const menu = document.querySelector<HTMLElement>("#mobile-navigation")
let scrolled = false
const syncHeader = () =>
  header?.toggleAttribute("data-compact", scrolled && !!menu?.hidden)

function closeMenu(restoreFocus = false) {
  if (!toggle || !menu) return
  menu.hidden = true
  toggle.setAttribute("aria-expanded", "false")
  toggle.setAttribute("aria-label", "Open menu")
  header?.removeAttribute("data-open")
  syncHeader()
  if (restoreFocus) toggle.focus()
}

toggle?.addEventListener("click", () => {
  if (!menu) return
  const open = menu.hidden
  menu.hidden = !open
  toggle.setAttribute("aria-expanded", String(open))
  toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu")
  header?.toggleAttribute("data-open", open)
  syncHeader()
})
menu?.addEventListener("click", (event) => {
  if ((event.target as Element).closest("a")) closeMenu()
})
document.addEventListener("keydown", (event) => {
  if (event.key === "Escape" && menu && !menu.hidden) closeMenu(true)
})
const desktop = matchMedia("(min-width: 768px)")
desktop.addEventListener("change", () => {
  if (desktop.matches) closeMenu()
})
let headerFrame = 0
const updateHeader = () => {
  scrolled = scrollY > (scrolled ? 8 : 48)
  syncHeader()
}
addEventListener(
  "scroll",
  () => {
    cancelAnimationFrame(headerFrame)
    headerFrame = requestAnimationFrame(updateHeader)
  },
  { passive: true },
)
updateHeader()

document
  .querySelectorAll<HTMLElement>("[data-fit-diagram]")
  .forEach((diagram) => {
    const fit = () =>
      diagram.style.setProperty(
        "--diagram-scale",
        String(Math.min(1, diagram.clientWidth / 1000)),
      )
    new ResizeObserver(fit).observe(diagram)
    fit()
  })

if (!matchMedia("(prefers-reduced-motion: reduce)").matches) {
  const observer = new IntersectionObserver(
    (entries) => {
      for (const entry of entries) {
        if (!entry.isIntersecting) continue
        const element = entry.target as HTMLElement
        element.animate(
          [
            { opacity: 0, transform: "translateY(18px)" },
            { opacity: 1, transform: "none" },
          ],
          {
            duration: 800,
            delay: parseFloat(element.style.transitionDelay) || 0,
            easing: "cubic-bezier(0.2, 0.7, 0.2, 1)",
          },
        )
        observer.unobserve(element)
      }
    },
    { threshold: 0.15 },
  )
  document
    .querySelectorAll(".reveal")
    .forEach((element) => observer.observe(element))
}

document
  .querySelectorAll<HTMLFormElement>("[data-inquiry-form]")
  .forEach((form) => {
    form.addEventListener("submit", () => {
      const submit = form.querySelector<HTMLButtonElement>("[type=submit]")
      if (submit) {
        submit.disabled = true
        submit.textContent = "Sending…"
      }
    })
  })
