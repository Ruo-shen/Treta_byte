# TRETA V1 product specification

## 1. Product summary

TRETA is a technology solutions studio founded by three friends working as one accountable team. It helps businesses fix technical problems, build useful digital systems, and care for the systems they depend on.

TRETA is not a freelancer marketplace, a large agency, or a SaaS product.

Primary brand statement:

> Technology should work for you. Not the other way around.

Supporting statement:

> We fix what's broken, build what's needed, and care for what matters.

## 2. Business objective

The website is a customer-acquisition asset. It must:

1. Look distinctive, polished, and professionally art-directed.
2. Explain the studio's services clearly.
3. Demonstrate capability using only real, approved work.
4. Establish trust without pretending the company is larger or older than it is.
5. Generate useful customer inquiries.
6. Publish search-focused articles without a frontend rebuild.
7. Provide strong technical SEO and reasonable performance on affordable shared hosting.

Priority order:

1. Visual quality
2. SEO foundations
3. Clear conversion paths
4. Fast launch
5. Simple maintenance

## 3. Audience

- Small and medium businesses
- Entrepreneurs and startups
- Organizations with broken, slow, or outdated websites
- Businesses needing custom websites, applications, integrations, or internal tools
- Organizations seeking reliable ongoing technical support
- Clients in Nepal and international markets

## 4. Service pillars

### Fix

Diagnose and repair existing technical problems, including broken sites, errors, performance issues, failed integrations, and unreliable functionality.

### Build

Create custom websites, web applications, internal tools, integrations, and practical workflow solutions.

### Care

Provide updates, maintenance, monitoring, improvements, and ongoing technical support.

## 5. V1 scope

### Included

- Custom public marketing website
- Four initial service pages
- Code-controlled portfolio and custom case studies
- About page
- Contact form with persisted inquiries
- Blog listing and article pages
- Filament administration for posts, categories, and inquiries
- Privacy page and real 404 response
- Technical SEO, sitemap, robots policy, metadata, and appropriate structured data
- GA4 and Search Console after identifiers and privacy treatment are approved

### Excluded

- Customer accounts or registration
- Client portal
- Payments, invoices, or booking
- CRM automation
- Public API
- Page builder
- General portfolio CMS
- Multi-language publishing
- A/B testing platform
- Custom analytics dashboard
- Live chat
- Redis, queues, WebSockets, or microservices

## 6. Public page inventory

The application contains **11 public page templates**. Four service-detail URLs are planned initially. Case-study and article counts depend on approved real content.

| Template | Route | Instances | Purpose | Content source | Primary action |
| --- | --- | ---: | --- | --- | --- |
| Homepage | `/` | 1 | Explain positioning, services, selected work, and the studio story | Code | Start an inquiry |
| Services overview | `/services` | 1 | Explain Fix, Build, and Care | Code | Choose a service |
| Service detail | `/services/{slug}` | 4 initially | Address a specific customer problem and search intent | Code | Discuss the service |
| Work index | `/work` | 1 | Present approved real projects | Code | View a case study |
| Case study | `/work/{slug}` | Variable | Explain the problem, work, solution, and verified outcome | Individually coded | Discuss a similar project |
| About | `/about` | 1 | Explain the founders' shared philosophy and accountability | Code | Contact the studio |
| Contact | `/contact` | 1 | Capture qualified inquiries | Code + database | Submit inquiry |
| Blog index | `/blog` | 1 | List published articles | CMS | Read an article |
| Article | `/blog/{slug}` | Variable | Provide useful, indexable content | CMS | Contextual service CTA |
| Privacy | `/privacy` | 1 | Explain form and analytics data handling | Code | — |
| Error page | HTTP 404 | 1 | Help visitors recover from invalid URLs | Code | Return to a useful page |

### Initial service URLs

- `/services/web-development`
- `/services/website-repair`
- `/services/website-maintenance`
- `/services/web-applications`

Do not create additional service pages merely to increase page count.

## 7. Page requirements

### Homepage

Use the approved React/Figma Make homepage as the visual source of truth. Preserve its distinctive editorial and technical character rather than redesigning it as a generic agency template.

Expected narrative:

1. Hero and positioning
2. Problems the studio solves
3. Fix / Build / Care services
4. Selected approved work
5. Why TRETA exists
6. Working process
7. Human studio story
8. Contact call to action
9. Footer

Remove placeholder client marquees, unapproved projects, and outdated contact details from the production version.

### Services

The overview introduces Fix, Build, and Care. Each detail page must have distinct useful copy, explain relevant problems and deliverables, link to related work or articles where available, and end with an appropriate inquiry CTA.

### Work and case studies

Publish only projects for which team involvement and publication permission are confirmed. Each case study should include:

- Client or project context
- Actual problem
- Work performed
- Solution and technical approach where helpful
- Verified outcome, or no outcome claim
- Approved images and accurate alt text
- Related service and contact CTA

Case-study layouts may be individually coded. Do not force every project into an identical CMS template.

### About

Tell the genuine story of three friends combining their skills as one responsible studio. Do not invent biographies, job titles, awards, credentials, portraits, or scale.

### Contact

Collect:

- Name
- Email
- Optional company
- Topic: Fix, Build, Care, or General
- Message

Show clear validation and success states. Store the inquiry before attempting email notification. A mail failure must not discard the saved inquiry.

### Blog

Anonymous visitors see only posts whose status is published and whose publication time has arrived. Editors can create, edit, preview, publish, unpublish, and categorize posts.

Each article supports:

- Title and slug
- Excerpt
- Structured rich content
- Featured image and alt text
- Category
- Draft/published status and publication date
- SEO title and meta description
- Optional social image
- Safe canonical and robots overrides

Publishing must update the live Blade-rendered page and sitemap without rebuilding frontend assets.

### Privacy and errors

The privacy page must accurately describe actual form storage, email delivery, analytics, retention, and contact practices before launch. Unknown legal or consent requirements must be reviewed rather than fabricated.

Invalid public URLs return a real HTTP 404 with a branded recovery page.

## 8. Visual direction

The site should feel clean, artistic, technically sophisticated, human, spacious, and approachable.

Avoid:

- Generic SaaS layouts
- Repetitive card grids
- Dashboard styling
- Meaningless glowing or 3D decorations
- Fake statistics or client logos
- Stock layouts unrelated to the approved homepage

Preserve the reference's typography, spacing, responsive behavior, colors, shadows, and restrained motion. Known design tokens include:

- Inter Tight
- Caveat
- JetBrains Mono
- Dark ink text
- Cobalt blue accent
- Warm off-white surfaces
- Problems-section background `#F7F6F2`

Use existing local illustrations where approved. Optimize them without changing their visual identity. Respect `prefers-reduced-motion`, visible focus, keyboard access, touch use, and readable contrast.

## 9. Content integrity

- Never publish fictional clients, projects, testimonials, results, awards, or statistics.
- Never present placeholder content as finished work.
- Do not invent a contact email.
- Only index complete, approved pages.
- Use a direct, capable, approachable tone.
- Explain outcomes in plain language.
- Treat `tretabyte.com` as the intended domain, but enforce canonical production behavior only after domain and HTTPS configuration are confirmed.

## 10. Acceptance criteria

| ID | Requirement | Acceptance condition |
| --- | --- | --- |
| P-01 | Server rendering | Raw responses contain meaningful headings, content, navigation, links, and metadata without JavaScript |
| P-02 | Homepage | Matches approved desktop and mobile references without fake claims |
| P-03 | Services | All four service URLs load directly with distinct content and a useful CTA |
| P-04 | Work | Only approved real projects are public or included in the sitemap |
| P-05 | Blog drafts | Drafts are restricted, non-indexable, and absent from public listings and sitemap |
| P-06 | Blog publishing | Published articles appear through Blade without an asset rebuild |
| P-07 | Contact | Validated, CSRF-protected submissions persist even when mail notification fails |
| P-08 | Admin | Only authorized staff can access Filament; public registration is disabled |
| P-09 | SEO | Titles, descriptions, canonicals, status codes, sitemap, robots, and valid structured data are verified |
| P-10 | Accessibility | Navigation and controls work with keyboard, touch, visible focus, and reduced motion |
| P-11 | Performance | Main content needs no client JavaScript; assets and images are appropriately optimized |
| P-12 | Hosting | Production requires PHP, MySQL, and compiled assets only |

## 11. Unresolved launch inputs

Implementation may proceed around these items, but agents must not guess them:

- Babal.Host plan, PHP version, required extensions, document-root support, deployment access, logs, backups, and HTTPS
- Final logo or wordmark
- Approved font and image licensing
- Verified contact email and alternative contact method
- Approved real projects, permissions, images, and outcomes
- Final founder information intended for publication
- GA4 measurement ID, Search Console verification method, and privacy/consent treatment
- Launch articles and categories

