# Backend handoff (branch `feat/backend`, integrated with the frontend)

Laravel 12.70 · Filament 5.10 · PHP platform pinned to 8.4.0 (`composer.json`).
**Hosting is UNVERIFIED:** Babal.Host PHP 8.4, extensions, MySQL 8, the `public/` document root and symlink support are assumed, not confirmed.

## Setup (local)

```powershell
composer install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link        # featured/social images live on the public disk
php artisan make:filament-user  # staff accounts; there is no registration
npm ci; npm run build           # Vite manifest (the test suite does NOT need it: TestCase uses withoutVite())
php artisan test
```

## DEPLOY (shared hosting, no Node at runtime)

1. **Build assets off the server** (local machine or CI): `npm ci && npm run build`, then upload `public/build/` (gitignored, so it must be uploaded or built in CI).
2. On the server (SSH or the host's Composer tool): `composer install --no-dev -o`. Its `post-autoload-dump` script runs `filament:upgrade`, which publishes Filament assets to `public/css/filament`, `public/js/filament`, `public/fonts/filament` (all gitignored). If Composer cannot run on the host, run `composer install --no-dev -o` locally and upload `vendor/` plus those three folders.
3. `.env` (never committed): `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://<domain>`, `APP_KEY` (`php artisan key:generate --show` locally), `DB_CONNECTION=mysql` plus the DB block, `SESSION_SECURE_COOKIE=true` once HTTPS-only, `QUEUE_CONNECTION=sync`, `MAIL_MAILER=smtp` with `MAIL_*`, **`MAIL_FROM_ADDRESS` set to a real sender** (empty makes every notification fail; the inquiry is still saved), `INQUIRY_NOTIFY_ADDRESS` (empty = no mail). `TRUSTED_PROXIES` only if behind a proxy/CDN.
4. `php artisan migrate --force`
5. `php artisan storage:link`. If the host forbids symlinks, create the link `public/storage -> ../storage/app/public` in the host panel; without it uploaded images 404 (and post pages simply omit the image).
6. `php artisan optimize` (config, route, event and view caches; verified working). After any `.env` or deploy change run `php artisan optimize:clear && php artisan optimize`. Re-run `php artisan filament:upgrade` after updating Filament.
7. Document root must be `public/`. Make `storage/` and `bootstrap/cache/` writable.
8. Post-deploy checks: confirm `APP_URL` is the public https URL (production logs a warning at boot otherwise, and canonicals, sitemap and robots depend on it); `/robots.txt` (production shows `Disallow: /admin` and the sitemap line); `/sitemap.xml`; `/admin/login`; a 404 URL; `/blog?page=2` with 13+ posts; submit the contact form; `request()->ip()` behind a proxy returns the visitor IP, not the proxy (set `TRUSTED_PROXIES`); `public/storage` link resolves an uploaded image.

No cron and no queue worker are needed: scheduled posts go live by themselves because the `published` scope compares `published_at` to the current time on each request (verified by tests). Nothing is scheduled in `routes/console.php`. `CACHE_STORE=database` and `SESSION_DRIVER=database` use the same MySQL database.

## Routes → views → data

Every public view receives `$seo` = `title, description, canonical, robots, og_image, type, json_ld` (docs §6). Canonical URLs are built from `APP_URL`, never from the request host.

| Route name | URL | View | Extra data |
| --- | --- | --- | --- |
| `home` | `/` | `pages.home` | `$services`, `$projects` |
| `services.index` | `/services` | `pages.services.index` | `$services` (slug => entry) |
| `services.show` | `/services/{slug}` | `pages.services.show` | `$slug`, `$service`, `$projects` (related) |
| `work.index` | `/work` | `pages.work.index` | `$projects` (enabled only) |
| `work.show` | `/work/{slug}` | `pages.work.{slug}` | `$slug`, `$project` |
| `about` | `/about` | `pages.about` | none |
| `contact.show` | `/contact` | `pages.contact` | `$topics` (value => label) |
| `contact.store` | `POST /contact` | redirect | none |
| `blog.index` | `/blog` | `blog.index` | `$posts` (paginator, 12 per page, project pagination view), `$categories` |
| `blog.show` | `/blog/{slug}` | `blog.show` | `$post`, `$preview` (false), `$contentHtml`, `$featuredImage` (`null` or `{url,width,height}`); a changed slug of a live post 301s to the new one |
| `posts.preview` | `/admin/preview/posts/{id}` | `blog.show` | same, `$preview` = true; staff only; `noindex` header; the view shows "Preview — not published" |
| `privacy` | `/privacy` | `pages.privacy` | none |
| `sitemap` | `/sitemap.xml` | XML | none |
| `robots` | `/robots.txt` | text | production: allow all, `Disallow: /admin`, sitemap line; any other env: `Disallow: /` |

Unknown service, work and blog slugs and unknown paths return a real 404 rendered by `errors/404.blade.php` with title "Page not found — TRETA Lab" and `noindex,follow`. Configured redirects (`config/redirects.php`, 301, empty by default) are registered before the public routes.

- **Article body:** render it only with `{!! $contentHtml !!}` (sanitized by `$post->contentHtml()`). Every other field uses `{{ }}`.
- **SEO:** page titles come from `config/seo.php` `titles` (the approved copy); services use their own `seo_title`/`meta_description`; description defaults to `seo.default_description`, the same text as the layout's fallback.
- **Structured data** (`$seo['json_ld']`, one `@graph` per page, JSON-safe): home = Organization + WebSite (name and URL only); service = Service (provider Organization) + BreadcrumbList; article = BlogPosting + BreadcrumbList.

## Contact form contract

- **Fields:** `name` (required, 100 max), `email` (required, RFC), `company` (optional, 150 max), `topic` (`fix|build|care|general`), `message` (required, 10–5000 chars), plus `@csrf`. The view's `maxlength` values match.
- **Honeypot:** a field named `website`, inside an `aria-hidden` container, `tabindex="-1"`, `autocomplete="off"`, positioned off-screen. A filled honeypot gets the normal success response but nothing is stored.
- **Success:** a redirect back to the same-site previous page, flashing `session('inquiry_sent') === true`.
- **Errors:** Laravel's `$errors` bag plus `old()`. The rate limit (3 per minute, 20 per day per IP) reports as an error on `message`.

## Environment variables added

| Variable | Purpose |
| --- | --- |
| `TRUSTED_PROXIES` | Comma list of proxy IPs/CIDRs (or `*`), read by `config/trustedproxy.php`. Default empty = trust none |
| `GA4_MEASUREMENT_ID` | GA4 `G-XXXX`. The gtag snippet renders only when set, valid, `APP_ENV=production`, and never on admin or preview pages |
| `GOOGLE_SITE_VERIFICATION` | Search Console meta token; rendered only when set |

Both analytics values stay empty until the IDs and the privacy/consent wording are approved. That is an open launch decision, and `/privacy` must describe analytics before enabling it.

## Security

`App\Http\Middleware\SecurityHeaders` (web group): `X-Content-Type-Options: nosniff`, `Referrer-Policy: strict-origin-when-cross-origin`, `X-Frame-Options: SAMEORIGIN`, a minimal `Permissions-Policy`, and HSTS (1 year, no `includeSubDomains`/preload) only for secure requests in production. There is **no CSP**: Filament and the GA4/Google Fonts snippets need inline scripts and third-party origins, so a CSP needs real browser verification first. Requests that match no route (plain 404 paths) skip the web group and get no extra headers.

## Content config (frontend-owned)

- `config/services.php` → `offerings`: four services with approved `seo_title`/`meta_description`, so they are in the sitemap.
- `config/work.php`: empty. An entry is public only with `'enabled' => true` and an existing view at `pages/work/{slug}.blade.php`.
- `config/seo.php` (backend): `default_description`, `titles`, `sitemap_static_routes` (`privacy` stays out until its content is approved), GA4/verification keys.
- `config/redirects.php` (backend): `'/old-path' => '/new-path'`. Loops, chains into another entry's source, and off-site targets are silently ignored (`App\Support\Redirects`); point each entry at the final URL.

## Frontend-owned files touched by the backend (coordinated)

`resources/views/blog/show.blade.php` (`$featuredImage`, null-safe date, preview notice), `resources/views/pages/contact.blade.php` (honeypot, maxlength alignment), `resources/views/layouts/app.blade.php` (GA4 snippet and verification meta, both conditional), new `resources/views/pagination/default.blade.php`. No design tokens, classes or layout were added beyond existing ones.

## Verified (local Windows, PHP 8.4.23, SQLite)

- `php artisan test`: 74 passed. Added: view contracts, approved titles and unique descriptions, 404 (no canonical), structured data, redirects (reserved paths), old-slug 301, robots, GA4 gating, headers, trusted proxies, open-redirect payloads, CSRF 419, blog pagination SEO, sitemap column selection.
- `vendor/bin/pint --test` passes; `npm run build` and `npm run check` pass.
- `migrate:fresh` and `migrate:rollback` on an empty SQLite file; `php artisan optimize` (config, events, routes, views) and `filament:assets` work.
- Earlier, on the first-backend branch: MySQL 8.4.3 suite, `composer audit`, upload limits, preview access, rate limits.

## Not verified / deferred

- Real SMTP delivery, the production host, symlink support, and a MySQL re-run of the new migration and tests.
- Browser console showed two `Failed to fetch` errors on the Filament create-post page right after saving. No custom redirect or JS exists in our code; it looks like an aborted Livewire request during the post-save redirect (possibly the single-threaded `artisan serve`). Not reproduced or confirmed.
- Staff 2FA is not enabled. Filament supports it.
- Category archives have no route in docs §4 and stay out of the sitemap.
- `db:seed` seeds nothing on purpose (every user is an admin).
- The Vite manifest is not required by tests (`withoutVite()`); real asset loading is checked only by `npm run build`.

## Known tradeoffs and launch inputs

- **Contact limiter** counts every POST to `/contact` (valid, invalid and honeypot): 3 per minute and 20 per day per IP. A visitor correcting validation errors can hit it; accepted for V1.
- **`User::canAccessPanel` returns true for every user.** That is safe only because there is no registration or import path; any future way to create users must restrict panel access first.
- **Pagination SEO:** `/blog?page=N` (N ≥ 2) has a self-canonical and a "— Page N" title suffix; out-of-range pages return 404; the page-1 link is `/blog`.
- **Meta descriptions** live in `config/seo.php` `descriptions`, copied from approved on-page text. `/privacy` still carries its "being prepared" text and is not in the sitemap.
- **Social cards:** `twitter:card` is `summary_large_image` only when a post has an og image, otherwise `summary`. **No default og:image exists**; launch input: an approved site-wide social image.
- **Redirect config** is GET/HEAD only and rejects sources that are application paths (`/admin`, `/livewire`, `/filament`, `/up`, `/storage`, `/build`, `/contact`, `/sitemap.xml`, `/robots.txt`, the static pages and asset folders).
- **Contact redirect-back** accepts the previous URL only when scheme, host and port equal `APP_URL` and it has no backslash or userinfo; otherwise `/contact`. With a dev host that differs from `APP_URL`, the visitor lands on `/contact`.
