# TRETA Lab

TRETA Lab is a small technology studio offering **Fix**, **Build**, and **Care** services. This repository will contain one Laravel application for its public website, blog, inquiry form, and staff administration.

Canonical GitHub repository: [Ruo-shen/treta_labs](https://github.com/Ruo-shen/treta_labs)

## Current status

Documentation and workflow are defined. Laravel implementation has not started.

The existing Figma Make React project is a visual reference. It is not the production architecture and must be preserved separately during implementation.

## Read before development

1. [`docs/PRODUCT.md`](docs/PRODUCT.md) — what the site must contain and why.
2. [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md) — how the application must work.
3. [`AGENTS.md`](AGENTS.md) — ownership, workflow, skills, and completion rules.
4. [`CLAUDE.md`](CLAUDE.md) — backend-agent entrypoint.

## Approved stack

- Laravel
- Blade server-rendered public pages
- Tailwind CSS v4
- Vite
- Selective React + TypeScript islands
- Filament
- MySQL in production
- SQLite for local development and tests where practical
- GA4 and Google Search Console after identifiers and privacy handling are approved

Production must run on conventional PHP shared hosting without a Node.js server, Redis, or queue worker.

## Environment prerequisites

Exact versions are pinned only after the hosting PHP version and extensions are confirmed. Committed Composer and JavaScript lockfiles then become authoritative.

Required locally:

- Git
- A hosting-compatible PHP version and extensions
- Composer
- Node.js and npm
- SQLite or MySQL

## Expected local commands

The final commands will be confirmed after the Laravel foundation exists. The normal workflow will use:

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
php artisan test
php artisan serve
```

Do not run `composer create-project`, install Filament, or pin framework versions until hosting compatibility has been recorded.

## Worktrees

After the shared foundation commit:

```text
treta_labs/             main
treta_labs-frontend/    feat/frontend
treta_labs-backend/     feat/backend
```

`main` is used for integration. Codex owns the frontend worktree; Claude owns the backend worktree. See `AGENTS.md` for exact boundaries.

## Known launch dependencies

- Hosting PHP version, extensions, and deployment method
- Final logo and approved visual assets
- Verified contact email
- Approved case studies and project permissions
- Analytics and privacy/consent decision
- Initial launch articles

Agents must leave these unresolved rather than inventing values.

