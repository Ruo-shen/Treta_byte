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
    const mark = (active: number) =>
      steps.forEach((step, i) => {
        step.dataset.state =
          i < active ? "past" : i === active ? "active" : "future"
      })

    process.classList.add("hx-live")

    mark(
      steps.reduce(
        (n, step, i) => (step.getBoundingClientRect().top < vh * 0.55 ? i : n),
        -1,
      ),
    )

    const spine = new IntersectionObserver(
      (entries) =>
        entries.forEach(
          (entry) =>
            entry.isIntersecting &&
            mark(steps.indexOf(entry.target as HTMLElement)),
        ),

      { rootMargin: "-45% 0px -45% 0px" },
    )

    steps.forEach((step) => spine.observe(step))
  }
}
