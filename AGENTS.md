# TRETA agent instructions

This file is the operating contract for every coding agent working in this repository.

## Read first

Before changing code, read:

1. `docs/PRODUCT.md` — product scope, page inventory, content rules, and acceptance criteria.
2. `docs/ARCHITECTURE.md` — stack, rendering boundary, routes, data contracts, and deployment constraints.
3. The task assigned for the current branch.

Repository documents are authoritative. A task prompt may narrow the work, but it must not silently override the approved stack or product boundaries.

## Product rule

TRETA V1 is a customer-acquisition website, not a software platform. Build the smallest reliable implementation that produces an excellent public website, publishes articles, and stores inquiries.

Do not add a client portal, customer accounts, payments, CRM, page builder, public API, multi-tenancy, Redis, queues, WebSockets, Node production server, or speculative infrastructure.

## Non-negotiable architecture

- One Laravel application.
- Blade renders all meaningful content and metadata for indexable pages.
- Tailwind CSS v4 provides public styling.
- Vite builds assets locally or in CI.
- React and TypeScript are allowed only for isolated interactions that genuinely benefit from React.
- Filament provides the staff-only blog and inquiry administration.
- Production uses PHP, MySQL, and compiled static assets. It must not require Node.js at runtime.
- Services and portfolio pages are code-controlled in V1.
- Blog posts and categories are database-driven.
- Never publish placeholder projects, invented clients, fabricated results, fake reviews, or unverified team claims.

## Branches and worktrees

**Active workspace (since 2026-10-18):** `C:\laragon\www\Treta-labs`, a clone on `main` served at `http://treta-labs.test`. Frontend and backend are integrated there; create short-lived feature branches from `main` in that clone. The original `C:\treta` worktrees described below are kept for reference only.

- `main` is integration-only.
- Codex works in `feat/frontend` using the frontend worktree.
- Claude works in `feat/backend` using the backend worktree.
- Both feature branches start from the same approved foundation commit.
- Commit one coherent change at a time.
- Integrate small, working slices into `main`; do not let feature branches drift for weeks.
- After integration, update both worktrees from `main` before continuing.
- Never push, deploy, rewrite shared history, or remove the React reference without explicit authorization.

Each worktree uses its own ignored `.env`, SQLite database, `vendor`, and `node_modules`. Do not share these directories using links or junctions.

## File ownership

### Codex — frontend owner

- `resources/views/**`
- `resources/css/**`
- `resources/js/**`
- Public visual assets under `public/images/**`
- `package.json` and the JavaScript lockfile
- `vite.config.*` and `tsconfig*.json`
- `config/services.php` and `config/work.php` as public content definitions
- Responsive behavior, animation, accessibility, and visual verification

### Claude — backend owner

- `app/**`
- `database/**`
- `routes/**`
- Filament resources and authentication
- `composer.json` and `composer.lock`
- Backend configuration other than the two public content files above
- Contact persistence and mail notification behavior
- Blog publishing, sitemap queries, authorization, validation, and PHP feature tests

### Integration-only

- `AGENTS.md`, `CLAUDE.md`, `README.md`, and `docs/**`
- CI workflows
- Cross-owner dependency upgrades
- Changes to the contracts in `docs/ARCHITECTURE.md`

If a task requires another owner's file, report the required change in the handoff. Do not casually edit it. A tiny coordinated change may be made only when the task explicitly assigns it.

## Working loop

1. Read the relevant product requirement and architecture contract.
2. Inspect the existing implementation and all callers before changing shared behavior.
3. Make the smallest change that completes the assigned slice.
4. Reuse Laravel, browser, CSS, or existing project facilities before adding dependencies.
5. Run the checks relevant to the changed files.
6. Fix failures caused by the change.
7. Report changed files, checks actually run, remaining uncertainty, and any cross-owner request.

Continue without asking for routine implementation decisions already settled by the documentation.

Stop and ask only when:

- A required hosting capability is unknown or incompatible.
- A real project, client claim, contact address, logo, licensed asset, or analytics decision is missing.
- A change would alter the approved stack, routes, public contract, hosting cost, SEO model, or security boundary.
- Credentials, deployment, destructive data changes, or a push require authorization.
- Two authoritative documents genuinely conflict.

## Required checks

Run only applicable checks, but do not claim checks that were not run.

### Every change

- Review `git diff` and `git status`.
- Confirm no secret, `.env`, placeholder claim, or unrelated generated file was added.

### PHP/backend changes

- Laravel formatter used by the repository.
- Targeted PHPUnit/Pest tests, followed by the full suite before integration.
- Relevant route, authorization, validation, and database behavior.

### Frontend changes

- Formatter used by the repository.
- Production Vite build.
- Direct route loading and browser console check.
- Responsive review at approximately 1440px, 768px, and 390px.
- Keyboard, focus, touch, and reduced-motion behavior where relevant.

### Indexable page changes

- Raw HTTP response contains the primary heading, copy, navigation, links, and metadata before JavaScript.
- Canonical, robots, Open Graph data, status code, image dimensions, and alt text are correct.
- No draft or placeholder URL enters the sitemap.

## Definition of done

A slice is complete only when:

- Its documented acceptance condition is met.
- Relevant automated checks pass.
- Browser or HTTP behavior was verified where applicable.
- The change respects file ownership and the Blade/React boundary.
- No unverified public claim was introduced.
- Remaining blockers are stated plainly.

## Skill routing

Use only the skills relevant to the current task. Do not load every skill for every change.

| Work | Preferred skill |
| --- | --- |
| New public-page visual work | `frontend-design` |
| Design-system consistency | `design-system-compliance` |
| React island implementation or review | `react-best-practices` |
| PHP implementation | `php-pro` |
| Security-sensitive backend work | `backend-security-coder` |
| Accessibility audit | `accessibility-compliance-accessibility-audit` |
| Browser and responsive verification | `browser-automation` |
| SEO verification | `seo-audit` |
| Final code review | `code-review-excellence` |

There is currently no installed Laravel- or Filament-specific skill. Use repository conventions and official framework documentation when version-specific behavior must be verified.

