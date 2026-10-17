const header = document.querySelector("header")
const toggle = document.querySelector<HTMLButtonElement>("[data-menu-toggle]")
const menu = document.querySelector<HTMLElement>("#mobile-navigation")

function closeMenu(restoreFocus = false) {
  if (!toggle || !menu) return
  menu.hidden = true
  toggle.setAttribute("aria-expanded", "false")
  toggle.setAttribute("aria-label", "Open menu")
  header?.removeAttribute("data-open")
  if (restoreFocus) toggle.focus()
}

toggle?.addEventListener("click", () => {
  if (!menu) return
  const open = menu.hidden
  menu.hidden = !open
  toggle.setAttribute("aria-expanded", String(open))
  toggle.setAttribute("aria-label", open ? "Close menu" : "Open menu")
  header?.toggleAttribute("data-open", open)
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
const updateHeader = () =>
  header?.toggleAttribute("data-scrolled", scrollY > 12)
addEventListener("scroll", updateHeader, { passive: true })
updateHeader()

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
