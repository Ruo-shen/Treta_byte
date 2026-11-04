// Problems scene: from lg the section pins and steps through the four problems while the track scrolls.
// IntersectionObserver reads four sentinels against the viewport top; no scroll listener.
const section = document.querySelector<HTMLElement>("[data-problems]")

if (section) {
  const STEP = 24

  const wide = matchMedia("(min-width: 1024px)")

  const scrub =
    CSS.supports("animation-timeline: view()") &&
    !matchMedia("(prefers-reduced-motion: reduce)").matches

  const items = [...section.querySelectorAll<HTMLElement>(".pb-item")]

  const marks = [...section.querySelectorAll<HTMLElement>(".pb-mk")]

  const sentinels = [...section.querySelectorAll<HTMLElement>(".pb-s")]

  const ring = section.querySelector<HTMLElement>(".pb-ring")

  let observer: IntersectionObserver | undefined

  let active = false

  const show = (index: number) => {
    items.forEach((el, i) => el.toggleAttribute("data-on", i === index))

    marks.forEach((el, i) => el.toggleAttribute("data-on", i === index))

    ring?.style.setProperty("--rot", `${-index * STEP}deg`)
  }

  const sync = () => {
    if (wide.matches && !active) {
      active = true

      section.classList.add("pb-on")

      if (scrub) {
        section.classList.add("pb-scrub")

        return
      }

      show(0)

      observer = new IntersectionObserver(
        (entries) => {
          for (const entry of entries)
            if (entry.isIntersecting)
              show(Number((entry.target as HTMLElement).dataset.i))
        },

        { rootMargin: "0px 0px -100% 0px" },
      )

      sentinels.forEach((el) => observer?.observe(el))
    } else if (!wide.matches && active) {
      active = false

      observer?.disconnect()

      observer = undefined

      section.classList.remove("pb-on")

      section.classList.remove("pb-scrub")

      items.forEach((el) => el.removeAttribute("data-on"))
    }
  }

  wide.addEventListener("change", sync)

  sync()
}
