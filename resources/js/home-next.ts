// /home-next only: scoped scroll reveal and the live Process spine. No scroll listeners; no-JS and reduced motion render everything final.

const root = document.querySelector<HTMLElement>(".hn")

if (root && !matchMedia("(prefers-reduced-motion: reduce)").matches) {
  const vh = innerHeight

  const items = [...root.querySelectorAll<HTMLElement>(".hx-reveal")]

  items.forEach((el) => {
    if (el.getBoundingClientRect().top < vh * 0.92) el.classList.add("is-in")
  })

  root.classList.add("hx-js")

  const reveal = new IntersectionObserver(
    (entries) =>
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return

        entry.target.classList.add("is-in")

        reveal.unobserve(entry.target)
      }),

    { rootMargin: "0px 0px -8% 0px" },
  )

  items.forEach((el) => !el.classList.contains("is-in") && reveal.observe(el))

  const process = root.querySelector<HTMLElement>("[data-process]")

  const steps = process ? [...process.children] as HTMLElement[] : []

  if (process && steps.length) {
    // The step nearest the middle of the viewport is active; recomputed on load, resize, entry and (rAF-throttled) scroll while the section is near.

    const compute = () => {
      const mid = innerHeight * 0.5

      const active = steps.reduce(
        (n, step, i) => (step.getBoundingClientRect().top < mid ? i : n),
        -1,
      )

      steps.forEach((step, i) => {
        step.dataset.state =
          i < active ? "past" : i === active ? "active" : "future"
      })
    }

    let frame = 0

    let near = false

    const queue = () => {
      if (!frame) frame = requestAnimationFrame(() => ((frame = 0), compute()))
    }

    process.classList.add("hx-live")

    compute()

    new IntersectionObserver(
      (entries) => {
        near = entries.some((entry) => entry.isIntersecting)

        compute()
      },

      { rootMargin: "20% 0px" },
    ).observe(process)

    addEventListener("scroll", () => near && queue(), { passive: true })

    addEventListener("resize", queue)

    addEventListener("load", compute)
  }
}
