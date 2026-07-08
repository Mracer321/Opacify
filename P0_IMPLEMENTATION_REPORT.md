# P0 Implementation Report — OpacifyWeb SEO

- **Branch:** `seo/p0-metadata-schema`
- **Date:** 2026-07-08
- **Scope:** Priority-0 fixes from `SEO_FIX_PLAN.md` (P0.1–P0.6). No P1/P2 work included.
- **Status:** ✅ P0.1–P0.5 complete. All Blade compiles; **93/93 tests pass** (294 assertions); no placeholder or broken social links remain. P0.6 (security/caching headers) is an ops change, still deferred.
- **Last updated:** 2026-07-08 — wired the production `og-default.png` (1200×630) with width/height/alt; confirmed footer links + `sameAs`.

---

## Summary of Changes

| P0 item | Status | Notes |
|---------|:------:|-------|
| P0.1 — Open Graph + Twitter Card tags | ✅ Done | Added to base layout; falls back to existing title/description/canonical sections |
| P0.2 — Default OG image | ✅ Done | `/images/og-default.png` (1200×630 PNG, verified) with `og:image:width/height/alt` + `twitter:image:alt` |
| P0.3 — Blog meta description (duplicate-meta fix) | ✅ Done | Each post now uses its own `excerpt` |
| P0.4 — Organization + WebSite JSON-LD | ✅ Done | Global partial rendered in `<head>` on every page |
| P0.5 — Real footer social links + schema `sameAs` | ✅ Done | Official LinkedIn / X / Instagram profiles wired into footer **and** JSON-LD |
| P0.6 — Security + caching headers | ⛔ Not in this branch | Ops/middleware change; deferred (see "Not Included") |

---

## Files Changed

### 1. `resources/views/layouts/app.blade.php`
- Added a full **Open Graph** block (`og:site_name`, `og:type`, `og:title`, `og:description`, `og:url`, `og:image`, **`og:image:width`, `og:image:height`, `og:image:alt`**, `og:locale`) and **Twitter Card** block (`twitter:card=summary_large_image`, `twitter:title`, `twitter:description`, `twitter:image`, **`twitter:image:alt`**).
- Default `og:image` / `twitter:image` → `https://opacify.in/images/og-default.png`; default dimensions `1200`×`630`; default alt `"Opacify - Custom Software Development Company"`.
- All tags fall back to the existing `@yield('title')` / `@yield('meta_description')` / `@yield('canonical')` sections, so every page gets valid social metadata with no per-page edits required. Pages may override via `@section('og_title'|'og_description'|'og_image'|'og_image_width'|'og_image_height'|'og_image_alt'|'og_type')`.
- Wired `@include('components.schema-global')` and added a `@stack('schema')` slot for future per-page JSON-LD (P1).

### 1a. `public/images/og-default.png` *(production asset)*
- 1200×630 PNG (verified via `getimagesize`), used as the site-wide default social share image.

### 2. `resources/views/components/schema-global.blade.php` *(new)*
- Emits `Organization` + `WebSite` JSON-LD (`@graph`) on every page using `layouts.app`.
- `Organization` includes name, url, logo, email, telephone, and **`sameAs`** with the three official profiles.
- Rendered via `json_encode(..., JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)` — validated as parseable JSON.

### 3. `resources/views/components/footer.blade.php`
- Replaced the three placeholder social links (which pointed at network homepages — `linkedin.com`, `twitter.com` [returned **403 broken**], `github.com`) with the official OpacifyWeb profiles:
  - LinkedIn → `https://in.linkedin.com/company/opacifyweb`
  - X (Twitter) → `https://x.com/opacifyweb` (Twitter bird icon retained; label updated to "X (Twitter)")
  - Instagram → `https://www.instagram.com/opacifypvtltd/` (GitHub slot repurposed; icon swapped to the Instagram glyph)
- Added `target="_blank" rel="noopener noreferrer"` (safe external-link hardening), descriptive `aria-label`s ("OpacifyWeb on …"), and `aria-hidden="true"` on the decorative SVGs.

### 4. `resources/views/pages/blog/show.blade.php`
- Added `@section('meta_description', $post['excerpt'] ?? Str::limit(strip_tags($post['title']), 150))` — fixes the duplicate-metadata bug (all posts previously inherited the homepage description).
- Added `@section('og_type', 'article')`.

### 5. `resources/views/pages/case-studies/show.blade.php`
- Converted the lone `@push('head')` `og:image` to `@section('og_image', $ogImageUrl)` so it integrates with the new global OG block.
- Added `@section('og_type', 'article')`.

> No unrelated code was modified. Controllers, routes, models, config, and data files are untouched.

---

## Verification Results

### Social links (task items 1–3)
```
Placeholder scan (resources/views): NONE FOUND
Social hrefs present in views:
  - https://in.linkedin.com/company/opacifyweb   (footer.blade.php:14)
  - https://x.com/opacifyweb                     (footer.blade.php:17)
  - https://www.instagram.com/opacifypvtltd/     (footer.blade.php:20)
```

**Live reachability (curl, followed redirects):**
```
200  https://in.linkedin.com/company/opacifyweb
200  https://x.com/opacifyweb
200  https://www.instagram.com/opacifypvtltd/
```
No broken (4xx/5xx) social links remain. The previously broken `twitter.com` (403) placeholder is gone.

### Open Graph image asset
```
public/images/og-default.png → 1200x630 image/png  (getimagesize verified)
```

### Rendered output — home page (via artisan tinker)
```
Footer social links:  3 official URLs (LinkedIn, X, Instagram)
JSON-LD:              valid; @graph has 2 nodes (Organization, WebSite)
Organization.sameAs:  3 official URLs (match footer exactly)
og:type            = website
og:image           = https://opacify.in/images/og-default.png
og:image:width     = 1200
og:image:height    = 630
og:image:alt       = Opacify - Custom Software Development Company
twitter:card       = summary_large_image
twitter:image      = https://opacify.in/images/og-default.png
twitter:image:alt  = Opacify - Custom Software Development Company
```

### Rendered output — blog post `how-to-hire-laravel-developers` (duplicate-meta fix + article OG)
```
og:type            = article
og:title           = How to Hire Laravel Developers Without a Six-Month Search — OpacifyWeb Blog
og:description     = A practical framework for evaluating Laravel talent, structuring
                     trials, and avoiding common outsourcing pitfalls.   (unique per post)
og:image           = https://opacify.in/images/og-default.png
og:image:width     = 1200
og:image:height    = 630
og:image:alt       = Opacify - Custom Software Development Company
```

### Build & tests
```
php artisan view:cache  → Blade templates cached successfully (all views compile)
php artisan test        → Tests: 93 passed (294 assertions)
```
Includes the existing `SeoRegressionTest`, `SitemapTest`, and `PublicRouteRegressionTest` suites — all green.

---

## Consistency Note
The footer social links and the `Organization.sameAs` array are the same three URLs. If profiles change, update **both** `components/footer.blade.php` and `components/schema-global.blade.php` (a reminder comment is present in the schema partial).

---

## Not Included (by request / scope)
- **P0.6 security/caching headers** — an nginx or Laravel-middleware change (HSTS/CSP/X-Frame-Options/etc. and HTML cache policy). Not a Blade change; deferred to an ops PR.
- **All P1 / P2 items** — not implemented, per instruction.

> **Deploy note:** `https://opacify.in/images/og-default.png` returned 404 during the original audit. The 1200×630 asset now exists in `public/images/` and must be deployed with this branch so social crawlers can fetch it. Verify it serves HTTP 200 in production post-deploy.

---

## Suggested Next Steps
1. Apply security + caching headers (P0.6).
2. After deploy, confirm `og-default.png` serves 200 in production, then re-run `social_meta.py`, `validate_schema.py`, and Google's Rich Results Test to confirm social 0→90+ and valid Organization/WebSite markup.
