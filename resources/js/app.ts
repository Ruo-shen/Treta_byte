import Lenis from "lenis"

const header = document.querySelector("header")
const toggle = document.querySelector<HTMLButtonElement>("[data-menu-toggle]")
const menu = document.querySelector<HTMLElement>("#mobile-navigation")
const reducedMotion = matchMedia("(prefers-reduced-motion: reduce)")
let lenis: Lenis | undefined
const configureScrolling = () => {
  lenis?.destroy()
  if (reducedMotion.matches) {
    document.getAnimations().forEach((animation) => animation.cancel())
  }
  lenis = reducedMotion.matches
    ? undefined
    : new Lenis({
        duration: 1.1,
        easing: (t) => 1 - Math.pow(1 - t, 4),
        autoRaf: true,
        prevent: (node) =>
          node === header || node instanceof HTMLTextAreaElement,
      })
}
configureScrolling()
reducedMotion.addEventListener("change", configureScrolling)

// Keep native link/history/focus semantics while Lenis owns only the movement.
document.addEventListener("click", (event) => {
  if (
    !lenis ||
    event.defaultPrevented ||
    event.button !== 0 ||
    event.metaKey ||
    event.ctrlKey ||
    event.shiftKey ||
    event.altKey
  )
    return
  const link = (event.target as Element).closest<HTMLAnchorElement>("a[href]")
  if (
    !link ||
    link.hasAttribute("download") ||
    (link.target && link.target !== "_self")
  )
    return
  const url = new URL(link.href)
  if (
    url.origin !== location.origin ||
    url.pathname !== location.pathname ||
    url.search !== location.search ||
    !url.hash
  )
    return
  let id: string
  try {
    id = decodeURIComponent(url.hash.slice(1))
  } catch {
    return
  }
  const target = document.getElementById(id)
  if (!target) return
  event.preventDefault()
  if (location.hash !== url.hash) history.pushState(null, "", url.hash)
  lenis.scrollTo(target, {
    offset: link.classList.contains("skip-link") ? 0 : -80,
    immediate: link.classList.contains("skip-link"),
    onComplete: () => {
      if (!target.hasAttribute("tabindex")) {
        target.setAttribute("tabindex", "-1")
        target.addEventListener(
          "blur",
          () => target.removeAttribute("tabindex"),
          { once: true },
        )
      }
      target.focus({ preventScroll: true })
    },
  })
})

let scrolled = false
const syncHeader = () =>
  header?.toggleAttribute("data-compact", scrolled && !!menu?.hidden)

function closeMenu(restoreFocus = false) {
  if (!toggle || !menu) return
  menu.hidden = true
  toggle.setAttribute("aria-expanded", "false")
  toggle.setAttribute("aria-label", "Open menu")
  header?.removeAttribute("data-open")
  lenis?.start()
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
  if (open) lenis?.stop()
  else lenis?.start()
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

if (!reducedMotion.matches) {
  const observer = new IntersectionObserver(
    (entries) => {
      for (const entry of entries) {
        if (!entry.isIntersecting) continue
        const element = entry.target as HTMLElement
        if (!reducedMotion.matches)
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
