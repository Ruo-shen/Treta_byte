# TRETA Lab

TRETA Lab is a small technology studio offering **Fix**, **Build**, and **Care** services. This repository will contain one Laravel application for its public website, blog, inquiry form, and staff administration.

Canonical GitHub repository: [Ruo-shen/treta_labs](https://github.com/Ruo-shen/treta_labs)

## Current status

Frontend (Blade, Tailwind CSS v4, native TypeScript) and backend (Laravel 12, Filament 5) are integrated on `main`. The site is under development and not launched. See [`BACKEND_HANDOFF.md`](BACKEND_HANDOFF.md) for routes, data contracts, environment variables and deploy notes.

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

## Active local workspace (Laragon)

All development now happens in `C:\laragon\www\Treta-labs` (a clone of this repository, `main`).

- Site: `http://treta-labs.test` (hosts entry required) or `http://treta-labs.localhost` (no hosts entry needed). The Apache vhost `C:\laragon\etc\apache2\sites-enabled\treta-labs.test.conf` points at `public/` only.
- Admin: `/admin`. Create staff with `php artisan make:filament-user`; there is no registration.
- PHP 8.4 (Laragon Apache uses PHP 8.4.23 via FastCGI), MySQL 8.4 database `treta_labs`, mail caught by Mailpit (`http://localhost:8025`).

First-time setup:

```powershell
composer install
npm ci
Copy-Item .env.example .env   # then set APP_URL, DB_* (mysql, treta_labs) and MAIL_* (Mailpit: smtp 127.0.0.1:1025)
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build                 # or `npm run dev` while editing CSS/JS
php artisan test
```

Node.js is used only locally to build assets; production serves the compiled `public/build`.

## History: original worktrees

The frontend and backend were built in separate worktrees under `C:\treta` (`treta_labs` on `main`, `treta_labs-frontend` on `feat/frontend`, `treta_labs-backend` on `feat/backend`, plus `first-backend`). They were merged into `main` and are kept unchanged for reference; do not develop there.

## Known launch dependencies

- Hosting PHP version, extensions, and deployment method
- Final logo and approved visual assets
- Verified contact email
- Approved case studies and project permissions
- Analytics and privacy/consent decision
- Initial launch articles

Agents must leave these unresolved rather than inventing values.

