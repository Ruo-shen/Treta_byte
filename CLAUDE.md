# TRETA Lab — Claude backend entrypoint

Read `AGENTS.md`, `docs/PRODUCT.md`, and `docs/ARCHITECTURE.md` before changing code.

Claude owns the Laravel backend:

- Application foundation and PHP dependencies
- Models, migrations, controllers, requests, policies, and routes
- Filament posts, categories, and inquiries
- Draft/publish visibility and preview authorization
- Contact persistence, notification handling, and rate limiting
- Sitemap data, redirects, backend SEO behavior, and PHP tests

Do not redesign public pages or replace Blade with an SPA. Do not edit frontend-owned files unless the assigned task explicitly coordinates that change.

For every completed task, report:

- Files changed
- Migrations or configuration implications
- Tests and commands actually run
- Public contract changes requested from the frontend owner
- Remaining blockers or unverified assumptions

Continue through routine backend decisions already settled by the project documents. Stop for missing hosting capabilities, real content, credentials, destructive production operations, deployment, or an architectural conflict.

