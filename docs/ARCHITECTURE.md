# TRETA V1 architecture

## 1. System boundary

TRETA is one Laravel monolith containing:

- Server-rendered public pages
- A small blog
- Contact inquiry persistence
- A staff-only Filament panel
- Locally or CI-compiled frontend assets

It is intentionally not an API platform or distributed system.

## 2. Approved stack

| Layer | Technology | Rule |
| --- | --- | --- |
| Backend | Laravel | One application and deployment |
| Public rendering | Blade | Owns all indexable content and metadata |
| Styling | Tailwind CSS v4 | Preserve extracted homepage tokens |
| Interactive UI | React + TypeScript | Isolated islands only when justified |
| Build | Vite | Runs locally or in CI, not as a production server |
| Administration | Filament | Posts, categories, and inquiries only in V1 |
| Production database | MySQL | Hosting-compatible version |
| Local/test database | SQLite | Use where practical |
| Analytics | GA4 + Search Console | Enable only after IDs and privacy treatment are approved |
| Hosting | Linux PHP shared hosting | Document root must target Laravel `public` |

Exact Laravel, PHP, Filament, Node, and package versions are selected after hosting compatibility is verified. Committed lockfiles are the version authority thereafter.

## 3. Rendering boundary

Blade must render:

- Page titles and metadata
- Navigation and footer links
- Headings and body copy
- Service information
- Portfolio descriptions and links
- Blog article content
- Contact form labels and controls
- Internal links and CTAs

React may enhance:

- An interaction-heavy project browser
- A complex gallery
- Purposeful visual effects
- A component whose state is materially simpler in React

React must not own a full public route or be required to read its main content. Every island mounts inside a dedicated element and receives only small, safely serialized public props. Failure to load an island must leave the page readable and navigable.

Use CSS or small native JavaScript for menus, hover states, reveals, and other simple behavior.

## 4. Public route contract

| Method | URL | Route name | Blade view | Data |
| --- | --- | --- | --- | --- |
| GET | `/` | `home` | `pages.home` | SEO data and approved featured content |
| GET | `/services` | `services.index` | `pages.services.index` | Published code-controlled services |
| GET | `/services/{slug}` | `services.show` | `pages.services.show` | One whitelisted service and related links |
| GET | `/work` | `work.index` | `pages.work.index` | Approved code-controlled projects only |
| GET | `/work/{slug}` | `work.show` | Individual case-study view | One whitelisted approved project |
| GET | `/about` | `about` | `pages.about` | SEO data |
| GET | `/contact` | `contact.show` | `pages.contact` | SEO data and topic options |
| POST | `/contact` | `contact.store` | Redirect response | Validated inquiry fields |
| GET | `/blog` | `blog.index` | `blog.index` | Paginated published posts and categories |
| GET | `/blog/{slug}` | `blog.show` | `blog.show` | One currently published post |
| GET | `/privacy` | `privacy` | `pages.privacy` | Approved privacy content |
| GET | `/sitemap.xml` | `sitemap` | XML response | Canonical public and published URLs only |

Filament owns its authenticated admin routes. Unknown service, work, and article slugs return HTTP 404 rather than a generic SPA page.

## 5. Code-controlled content

The four services are defined in `config/services.php`. Each entry has at least:

- `slug`
- `pillar`
- `name`
- `summary`
- `seo_title`
- `meta_description`
- `problems`
- `deliverables`

Approved work index metadata is defined in `config/work.php`. No entry may be enabled until its publication permission and content are confirmed. Each case study points to an individually coded Blade view under `resources/views/pages/work/`.

These two files are frontend-owned content definitions even though they live under `config/`.

## 6. SEO view contract

The public layout accepts an `$seo` array with safe defaults:

| Key | Required | Meaning |
| --- | --- | --- |
| `title` | Yes | Unique page title |
| `description` | Yes | Accurate meta description |
| `canonical` | Yes | Absolute canonical URL derived from approved application URL unless safely overridden |
| `robots` | No | Defaults to `index,follow` for complete public pages |
| `og_image` | No | Approved absolute social-image URL |
| `type` | No | Defaults to `website`; articles use `article` |
| `json_ld` | No | Valid structured data supported by visible content |

All values are escaped or safely serialized. Canonical overrides are restricted to appropriate URLs. Structured data must not contain unsupported reviews, ratings, clients, people, or outcomes.

Every indexable page has one meaningful H1, semantic headings, crawlable anchors, and a direct 200 response. Redirects and error pages return correct status codes.

## 7. Data model

### `users`

Laravel/Filament staff users only. There is no public registration.

### `categories`

- `id`
- `name`
- `slug` unique
- timestamps

### `posts`

- `id`
- `user_id`
- `category_id` nullable
- `title`
- `slug` unique
- `excerpt`
- constrained rich content
- featured image path
- featured image alt text
- status: draft or published
- `published_at` nullable
- SEO title nullable
- meta description nullable
- social image path nullable
- canonical override nullable
- robots override nullable with safe choices
- timestamps

A post is publicly visible only when its status is published and `published_at` is not in the future.

### `inquiries`

- `id`
- `name`
- `email`
- `company` nullable
- `topic`: fix, build, care, or general
- `message`
- `status`
- internal notes nullable
- mail notification state or timestamp when useful for operations
- timestamps

Do not store unnecessary tracking or sensitive fields.

## 8. Contact contract

Public field names are:

- `name`
- `email`
- `company`
- `topic`
- `message`

The backend provides:

- CSRF protection
- Server-side validation
- Rate limiting
- A honeypot or similarly lightweight spam control
- Database persistence before notification
- Bounded synchronous mail attempt because no queue worker is required
- Logging of notification failure without exposing private form content unnecessarily
- Redirect-back success state using `inquiry_sent`
- Laravel's normal validation error bag

Saving an inquiry and sending its notification are separate outcomes. A saved inquiry is never deleted because mail delivery fails.

## 9. Blog and Filament contract

Filament provides:

- Authenticated staff access
- Post create/edit/preview/publish/unpublish
- Category management
- Inquiry listing, status, and internal notes
- Image validation and alt-text fields

Use Filament's established authentication and authorization facilities. Do not build custom RBAC for V1. Public registration is disabled.

Rich content is constrained and sanitized appropriately before rendering. Uploads are limited by expected MIME type, extension, and size and must not be executable.

## 10. Sitemap and robots

The sitemap contains only:

- Complete canonical static pages
- The four approved service pages
- Approved public case studies
- Currently published canonical blog articles
- Useful category archives only when they contain sufficient published content

It excludes drafts, previews, admin routes, incomplete projects, placeholders, search/filter URLs, and error pages.

`robots.txt` references the production sitemap only after the production domain is configured. Robots rules are not used as an access-control mechanism.

## 11. Frontend structure

Expected structure:

```text
resources/
  views/
    layouts/app.blade.php
    components/
    pages/
      home.blade.php
      services/
      work/
      about.blade.php
      contact.blade.php
      privacy.blade.php
    blog/
    errors/404.blade.php
  css/app.css
  js/app.ts
  js/islands/
public/images/
```

Extract the approved Figma Make tokens into the Tailwind v4 CSS theme. Do not introduce a second public design system or a component library merely for ordinary sections.

Use responsive images, intrinsic width and height, appropriate modern formats, local assets where approved, and font loading that avoids unnecessary render blocking.

## 12. Security baseline

- Laravel CSRF protection
- Server-side validation and escaped output
- Explicit authorization for Filament operations and previews
- No public registration
- Strong staff credentials and supported 2FA where practical
- Contact rate limiting and spam control
- Safe rich-content rendering
- Upload type, size, path, and serving controls
- Secrets only in environment configuration
- `APP_DEBUG=false` in production
- HTTPS and secure production cookies
- Laravel `public` as the web document root
- Writable `storage` and `bootstrap/cache` without exposing application internals
- Database and uploaded-media backups
- Dependency maintenance, error logs, and access logs

## 13. Build and deployment

Local or CI preparation includes:

1. Install locked Composer dependencies.
2. Install locked JavaScript dependencies.
3. Run tests and formatters.
4. Build Vite assets into `public/build`, including its manifest.
5. Deploy the Laravel application and compiled assets.
6. Configure production environment values.
7. Run migrations.
8. Create the storage link when hosting supports the standard layout.
9. Warm or clear Laravel caches as appropriate.
10. Verify routes, assets, form persistence, mail, logs, sitemap, TLS, and backups.

Production must not run Vite, a Node server, Redis, or a permanent queue worker.

## 14. Worktree integration contract

The foundation is created sequentially before parallel work:

1. Backend owner creates the compatible Laravel/Filament foundation and Composer lockfile.
2. Frontend owner adds the Blade layout, Tailwind v4, Vite, TypeScript, minimal React-island entrypoint, and JavaScript lockfile.
3. A server-rendered sample route, production asset build, and baseline tests pass.
4. The common commit becomes the base for `feat/frontend` and `feat/backend` worktrees.

Integrate small vertical slices. Backend changes should preserve the route and data contracts above; frontend changes should consume those contracts without moving indexable content into React. Contract changes are reviewed and merged through the integration checkout before either owner depends on them.

## 15. Verification baseline

Before launch, verify:

- Fresh dependency installation from lockfiles
- Database migrations on an empty database
- Full PHP test suite
- Production Vite build
- Raw HTML and metadata for every indexable route
- Draft and preview authorization
- Contact validation, persistence, rate limit, success state, and mail-failure behavior
- Real 404 and redirect responses
- Sitemap and robots contents
- Desktop, tablet, and mobile screenshots
- Keyboard, focus, touch, and reduced-motion behavior
- Image loading, dimensions, compression, and alt text
- Production-host document root, writable directories, HTTPS, logging, and backup recovery

