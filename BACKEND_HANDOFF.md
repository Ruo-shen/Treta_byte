# Backend handoff (branch `first-backend`)

Laravel 12.70 · Filament 5.10 · PHP platform pinned to 8.4.0 (`composer.json`).
**Hosting is UNVERIFIED:** Babal.Host PHP 8.4, extensions, MySQL 8 and the `public/` document root are assumed, not confirmed.

## Setup

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link        # featured/social images live on the public disk
php artisan make:filament-user  # staff accounts; there is no registration
php artisan test
```

Production `.env`: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://<domain>`, `DB_CONNECTION=mysql` plus the DB block, SMTP `MAIL_*`, `MAIL_TIMEOUT` (default 10 s), `INQUIRY_NOTIFY_ADDRESS` (empty means no mail; inquiries are still saved). `QUEUE_CONNECTION=sync`.

## Routes → views → data

Every public view receives `$seo` = `title, description, canonical, robots, og_image, type, json_ld` (docs §6). Canonical URLs are built from `APP_URL`, never from the request host.

| Route name | URL | View | Extra data |
| --- | --- | --- | --- |
| `home` | `/` | `pages.home` | `$services`, `$projects` |
| `services.index` | `/services` | `pages.services.index` | `$services` (slug => entry) |
| `services.show` | `/services/{slug}` | `pages.services.show` | `$slug`, `$service`, `$projects` (related) |
| `work.index` | `/work` | `pages.work.index` | `$projects` (enabled only) |
| `work.show` | `/work/{slug}` | `pages.work.{slug}` | `$slug`, `$project` |
| `about` | `/about` | `pages.about` | — |
| `contact.show` | `/contact` | `pages.contact` | `$topics` (value => label) |
| `contact.store` | `POST /contact` | redirect | — |
| `blog.index` | `/blog` | `blog.index` | `$posts` (paginator, 12 per page), `$categories` (with live posts) |
| `blog.show` | `/blog/{slug}` | `blog.show` | `$post`, `$preview` (false) |
| `posts.preview` | `/admin/preview/posts/{id}` | `blog.show` | `$preview` = true; staff only; `noindex` header |
| `privacy` | `/privacy` | `pages.privacy` | — |
| `sitemap` | `/sitemap.xml` | XML | — |

Unknown service, work and blog slugs return a real 404. Laravel uses `errors/404.blade.php` once the frontend adds it.

- **Article body:** render it only with `{!! $post->contentHtml() !!}`, which is sanitized. Every other field uses `{{ }}`.
- **Image URLs:** `Storage::url($post->featured_image_path)`, with alt text from `$post->featured_image_alt`.

## Contact form contract

- **Fields:** `name` (required, 100 max), `email` (required, RFC), `company` (optional, 150 max), `topic` (`fix|build|care|general`), `message` (required, 10–5000 chars), plus `@csrf`.
- **Honeypot:** a field named `website`. Keep it hidden and empty: visually hidden, `tabindex="-1"`, `autocomplete="off"`. A filled honeypot gets the normal success response but nothing is stored.
- **Success:** a redirect back to the same-site previous page, flashing `session('inquiry_sent') === true`.
- **Errors:** Laravel's `$errors` bag plus `old()`. The rate limit (3 per minute, 20 per day per IP) reports as an error on `message`.

## Content config (frontend-owned)

- `config/services.php` → `offerings`: the four slugs. They currently hold only `pillar` and `name`; `summary`, `seo_title`, `meta_description`, `problems` and `deliverables` are still null or empty. A service enters the sitemap only once `seo_title` and `meta_description` are set. The Laravel credential keys in the same file are untouched.
- `config/work.php`: empty. Its shape is documented in the file. An entry is public only with `'enabled' => true` and an existing view at `pages/work/{slug}.blade.php`.
- `config/seo.php` (backend): `default_description` and `sitemap_static_routes`. `privacy` is left out until its content is approved.

## Blade stubs to replace

These are unstyled, contain no final copy, and sit under `resources/views/`: `_stubs/layout.blade.php`, `pages/{home,about,contact,privacy}.blade.php`, `pages/services/{index,show}.blade.php`, `pages/work/index.blade.php`, `blog/{index,show}.blade.php`. Delete `_stubs/` once `layouts/app.blade.php` exists.

The skeleton's `package.json`, `vite.config.js` and `resources/{css,js}` are committed unmodified for the frontend owner to take over. `welcome.blade.php` was removed.

## Verified (2026-10-18, local Windows, PHP 8.4.23, SQLite)

- **Install and checks:** clean `composer install` from the lockfile; `composer audit` finds no advisories; `check-platform-reqs` passes; Pint passes.
- **Database:** `migrate:fresh` works on an empty SQLite file, and rollback works.
- **Routes:** `route:cache` works; there is no registration route.
- **Tests:** `php artisan test` passes 37 tests. They cover:
  - admin access (guests, staff, registration 404)
  - draft, scheduled and unpublished visibility
  - slug validation
  - publishing and unpublishing
  - upload limits (rejects SVG, PHP-as-PNG and files over 2 MB; requires alt text)
  - inquiry fields locked against edits
  - 404s
  - canonical host
  - sanitized article body
  - preview access
  - sitemap contents
  - contact persistence, validation, honeypot, rate limit, mail failure and same-site redirect

## Not verified / deferred

- MySQL 8 migrations (no local MySQL), real SMTP delivery and the production host itself.
- `robots.txt` still uses Laravel's default (allow all, no sitemap line). Add the sitemap reference once the production domain is set.
- Category archives have no route in docs §4 and stay out of the sitemap.
- Staff 2FA is not enabled. Filament supports it when wanted.
- Docs say `feat/backend`; this branch and worktree are named `first-backend` at the user's request.
