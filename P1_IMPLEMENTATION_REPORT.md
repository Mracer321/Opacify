# P1 Implementation Report — OpacifyWeb SEO

- **Branch:** `seo/p0-metadata-schema`
- **Date:** 2026-07-08
- **Scope:** Priority-1 fixes from `SEO_FIX_PLAN.md` (P1.1–P1.6). No P0.6 or P2 work included.
- **Status:** ✅ Complete. All Blade compiles; **93/93 tests pass** (294 assertions). Every JSON-LD block validated (correct `@context`/`@type`, parseable).

---

## Summary of Changes

| P1 item | Status | Notes |
|---------|:------:|-------|
| P1.1 — Page-type structured data | ✅ Done | `BlogPosting`, `Service`, `BreadcrumbList` via reusable schema components |
| P1.2 — Orphan/deep-page internal linking | ✅ Done | Related articles, related case studies, hire→blog cross-links |
| P1.3 — E-E-A-T author schema | ✅ Done | Author `Person` embedded in `BlogPosting` (testimonial/stat verification flagged, see below) |
| P1.4 — Sitemap `lastmod` on all URLs | ✅ Done | 56/56 URLs now carry `<lastmod>` (was projects-only) |
| P1.5 — Country-code dropdown a11y | ✅ Done | `aria-label` added |
| P1.6 — Newsletter dead form | ✅ Done (interim) | Repointed to contact via GET; documented for a real provider later |

> **Bonus bugfix:** while adding schema I discovered the P0 global `Organization`/`WebSite` JSON-LD was shipping a **corrupted `@context` key** — Blade was interpreting the `@context` string as its `@context` *directive*. Fixed here for all schema (see "Blade `@context` collision" below). Without this fix, none of the site's structured data would have validated in Google's Rich Results Test.

---

## Files Changed

### New — reusable JSON-LD components
- **`resources/views/components/schema/breadcrumbs.blade.php`** — `BreadcrumbList` from an `items` array.
- **`resources/views/components/schema/service.blade.php`** — `Service` with `provider` → `#org`.
- **`resources/views/components/schema/blog-posting.blade.php`** — `BlogPosting` + author `Person`, `publisher` → `#org`.

All three assemble JSON inside a `@php` block and push to the global `schema` stack (`@stack('schema')` in the layout, added in P0).

### P1.1 / P1.3 — schema wiring
- **`resources/views/pages/blog/show.blade.php`** — `<x-schema.blog-posting>` + `<x-schema.breadcrumbs>` (Home › Blog › post).
- **`resources/views/components/service-detail-page.blade.php`** — `<x-schema.service>` + `<x-schema.breadcrumbs>` (Home › Services › service).
- **`resources/views/components/technology-page.blade.php`** — `<x-schema.service>` + `<x-schema.breadcrumbs>` (Home › {Tech} Developers). Covers both the hire-* pages and `/technologies/{slug}`.
- **`resources/views/pages/case-studies/show.blade.php`** — `<x-schema.breadcrumbs>` (Home › Case Studies › project).
- **`resources/views/components/schema-global.blade.php`** — rewritten to build JSON in `@php` (fixes the `@context` collision).

> Per the audit and skill rules: **no `FAQPage`** (restricted to gov/health since Aug 2023) and **no `HowTo`** (deprecated) were added.

### P1.2 — internal linking
- **`app/Http/Controllers/BlogController.php`** — `show()` passes `relatedPosts` (up to 3 sibling posts).
- **`app/Http/Controllers/CaseStudyController.php`** — `show()` passes `relatedProjects` (up to 3 other published projects).
- **`resources/views/pages/blog/show.blade.php`** — "Related articles" section (3 cards → sibling posts).
- **`resources/views/pages/case-studies/show.blade.php`** — "Related case studies" section (3 cards → sibling projects).
- **`resources/views/components/technology-page.blade.php`** — renders an optional `related_article` link (hire page → blog post).
- **`resources/views/pages/hire-laravel-developers.blade.php`** — `related_article` → "How to Hire Laravel Developers…".
- **`resources/views/pages/hire-react-developers.blade.php`** — `related_article` → "The React Team Augmentation Checklist…".

These give every previously orphan-ish deep page (4 blog posts, 4 case studies) multiple new incoming internal links.

### P1.4 — sitemap `lastmod`
- **`app/Support/Sitemap.php`** — added `viewDate()` / `fileDate()` helpers; static & data-file-backed URLs now emit a stable `<lastmod>` derived from the backing source file's modified time (Blade view for static pages; `services.php` / `technologies.php` / `blog-posts.php` for data groups). DB projects keep `updated_at`. `entry()` now accepts `Carbon|string|null`.

### P1.5 — accessibility
- **`resources/views/components/lead-form.blade.php`** — `aria-label="Select country dial code"` on the custom country-code `<button>` (targets the 3 unlabeled controls from the a11y check).

### P1.6 — newsletter form
- **`resources/views/components/footer.blade.php`** — the dead `action="#" method="post"` newsletter form now does `action="{{ route('contact') }}" method="get"`, so submitting lands on a real page instead of erroring. Commented as interim; swap for a real subscribe endpoint when a provider is chosen.

> No routes, models, migrations, or business logic were added/changed. Controller edits are read-only queries.

---

## Blade `@context` collision (root-cause note)

Laravel registers Blade directives named `@context`, `@php`, `@stack`, etc. When the JSON-LD keys `@context` / `@type` appeared inside an inline `{!! json_encode([...]) !!}` — **and** when those tokens appeared inside `{{-- --}}` comments — Blade compiled them as directives, corrupting the output (e.g. `@context` → `<?php … context() … ?>`, `@php` in a comment → `<?php`, causing a fatal parse error).

**Fix applied to all four schema files:**
1. Assemble the JSON array + `json_encode()` inside a `@php … @endphp` block (Blade does not parse directives there), then echo the resulting string.
2. Keep `@`-prefixed tokens (`@context`, `@type`, `@php`, `@stack`) out of Blade comments.

This is why the P0 global schema is touched in a P1 PR — it shared the same latent defect.

---

## Verification Results

### Structured data (rendered via `artisan tinker`, JSON re-parsed)
```
blog/show      : Organization+WebSite  BlogPosting  BreadcrumbList   (all @context=ok, valid)
services/show  : Organization+WebSite  Service      BreadcrumbList   (all @context=ok, valid)
hire-laravel   : Organization+WebSite  Service      BreadcrumbList   (all @context=ok, valid)
case-studies   : Organization+WebSite  BreadcrumbList                (all @context=ok, valid)
home           : Organization+WebSite                                (@context=ok, valid)
```
BlogPosting sample includes `author {Person: Neha Kapoor, Head of Delivery}`, `datePublished 2026-05-12T00:00:00+00:00`, `publisher → #org`.

### Internal linking
```
blog/show      : related-article cards render sibling post links
case-studies   : related case-study cards render sibling project links
hire-laravel   : contextual link → /blog/how-to-hire-laravel-developers
hire-react     : contextual link → /blog/react-team-augmentation-checklist
```

### Sitemap
```
Sitemap::urls() → total=56  with_lastmod=56   (previously only DB projects had lastmod)
```

### Accessibility / newsletter
```
lead-form country button: aria-label="Select country dial code"  ✓
footer newsletter form  : action=route('contact') method="get"    ✓
```

### Build & tests
```
php artisan view:cache  → all Blade compiles
php artisan test        → Tests: 93 passed (294 assertions)
```
Existing `SeoRegressionTest`, `SitemapTest`, `PublicRouteRegressionTest`, enquiry, and admin suites all green.

---

## Deferred / flagged (not code changes)
- **P1.3 testimonial & stat verification** — the homepage testimonials ("Priya Mehta, FinEdge Payments", etc.) and stats ("320+ developers placed", "94% retention", "Since 2018") are a **content/business-truth decision**, not a code fix. If illustrative, they should be substantiated or reframed. Left untouched.
- **P1.6 real newsletter provider** — wiring an actual subscribe endpoint needs a provider + route + storage (business logic), out of scope for "minimal"; interim GET-to-contact shipped instead.

## Not Included (by request)
- **P0.6** security/caching headers — ops/middleware change.
- **All P2 items** — performance/GEO; measure-first.
