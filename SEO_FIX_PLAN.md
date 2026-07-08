# SEO Fix Plan — OpacifyWeb

Prioritized, file-level remediation for the findings in **SEO_AUDIT_REPORT.md**.
Ordered by **impact ÷ effort**. Nothing here has been applied — this is the plan.

Legend: 🔴 Critical · ⚠️ Warning · Effort: S (<1h) / M (a few hrs) / L (day+)

---

## Priority 0 — Ship This Week (high impact, low effort)

### P0.1 🔴 Add Open Graph + Twitter Card meta to the base layout — Effort: S
**Problem:** 0/100 social score; every shared link is a bare URL. (Audit §5)
**Files:** `resources/views/layouts/app.blade.php`, `layouts/landing.blade.php`

Add to `<head>` (after the `<meta name="description">` line), using `@yield` so pages can override and everything falls back cleanly:

```blade
{{-- Open Graph --}}
<meta property="og:site_name" content="OpacifyWeb">
<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:title" content="@yield('og_title', View::yieldContent('title', 'OpacifyWeb — Hire Skilled Remote Developers'))">
<meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', 'Hire experienced Laravel, React, Node.js, and full-stack developers.'))">
<meta property="og:url" content="@yield('canonical', 'https://opacify.in')">
<meta property="og:image" content="@yield('og_image', 'https://opacify.in/images/og-default.png')">
<meta property="og:locale" content="en_US">

{{-- Twitter --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('og_title', View::yieldContent('title'))">
<meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description'))">
<meta name="twitter:image" content="@yield('og_image', 'https://opacify.in/images/og-default.png')">
```

> Because `og:*` reuse the existing `title`/`meta_description`/`canonical` sections, **no per-page changes are required** for a baseline. Pages needing a custom share image just add `@section('og_image', ...)`. The case-study page (`case-studies/show.blade.php:28-32`) already computes `$ogImageUrl` — replace its lone `@push('head')` `og:image` with `@section('og_image', $ogImageUrl)` and optionally `@section('og_type', 'article')`.

### P0.2 🔴 Create a default OG share image — Effort: S
**Problem:** `https://opacify.in/images/og-default.png` → 404. (Audit §5)
**Action:** Add a 1200×630 PNG at `public/images/og-default.png` (brand + tagline). Reference it as the `@yield('og_image')` default above.

### P0.3 🔴 Fix duplicate/missing meta description on blog posts — Effort: S
**Problem:** All 4 blog posts inherit the homepage meta description. (Audit §3, §13)
**File:** `resources/views/pages/blog/show.blade.php` (add line after `@section('title', ...)`)

```blade
@section('meta_description', $post['excerpt'] ?? \Illuminate\Support\Str::limit(strip_tags($post['title']), 150))
```

Better: add a real `excerpt` (140–160 chars) to each entry in `resources/data/blog-posts.php` and reference it here and on the blog index cards.

### P0.4 🔴 Add Organization + WebSite structured data (global) — Effort: S
**Problem:** Zero JSON-LD site-wide. (Audit §8)
**File:** `resources/views/layouts/app.blade.php` — add a `@stack('schema')` slot in `<head>`, then a global partial (e.g. `@include('components.schema-global')`) rendering:

```blade
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://opacify.in/#org",
      "name": "OpacifyWeb",
      "url": "https://opacify.in",
      "logo": "https://opacify.in/images/logo.png",
      "email": "opacifyweb@gmail.com",
      "telephone": "+91-88020-32023",
      "sameAs": [
        "https://www.linkedin.com/company/REAL_HANDLE",
        "https://twitter.com/REAL_HANDLE",
        "https://github.com/REAL_HANDLE"
      ]
    },
    {
      "@type": "WebSite",
      "@id": "https://opacify.in/#website",
      "url": "https://opacify.in",
      "name": "OpacifyWeb",
      "publisher": { "@id": "https://opacify.in/#org" }
    }
  ]
}
</script>
```

Use **JSON-LD only**. Only include `sameAs` once real profiles exist (see P1.3). Do **not** add a `SearchAction` unless a real on-site search endpoint exists.

### P0.5 🔴 Replace placeholder footer social links (also fixes the 1 broken link) — Effort: S
**Problem:** `twitter.com` (403 broken), `linkedin.com`, `github.com` point to generic homepages. (Audit §12, §14)
**File:** `resources/views/components/footer.blade.php:14,17,20`
**Action:** Point to real OpacifyWeb profiles, or remove the icons until profiles exist. Keep the existing `aria-label`s.

### P0.6 ⚠️ Add security + caching headers — Effort: S/M
**Problem:** Security 25/100; HTML `no-cache`. (Audit §2, §17)
**Options (pick one):**
- **nginx** (fastest): add to the server block —
  ```nginx
  add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;
  add_header X-Content-Type-Options "nosniff" always;
  add_header X-Frame-Options "SAMEORIGIN" always;
  add_header Referrer-Policy "strict-origin-when-cross-origin" always;
  add_header Permissions-Policy "camera=(), microphone=(), geolocation=()" always;
  ```
- **Laravel middleware** (portable): create `App\Http\Middleware\SecurityHeaders`, register globally in `bootstrap/app.php`. Add a CSP last, after auditing inline scripts (Alpine/Vite).
**Caching:** static marketing pages (home, services, about, hire-*, technologies, legal) don't need `no-cache`. Add a middleware that sets `Cache-Control: public, max-age=600, s-maxage=3600` on GET marketing routes (exclude anything rendering session/CSRF-sensitive state).

---

## Priority 1 — This Month (high impact, moderate effort)

### P1.1 🔴/⚠️ Page-type structured data — Effort: M
**Files & schema:**
- `resources/views/pages/blog/show.blade.php` → `BlogPosting` (headline, datePublished, author, publisher→`#org`, mainEntityOfPage, image). Requires real `date`/`author` fields (already in `blog-posts.php`).
- `resources/views/components/service-detail-page.blade.php` & hire pages → `Service` (name, provider→`#org`, areaServed, serviceType).
- `resources/views/components/technology-page.blade.php`, `case-studies/show.blade.php`, `blog/show.blade.php` → `BreadcrumbList` (the visible breadcrumb markup already exists — mirror it in JSON-LD).
- **Do NOT** add `FAQPage` to the homepage FAQ (restricted to gov/health since Aug 2023) or any `HowTo` (deprecated).

Push per-page via `@push('schema')`.

### P1.2 ⚠️ Fix orphan/deep-page internal linking — Effort: M
**Problem:** 4 blog posts + 4 case studies have ≤1 incoming link. (Audit §11)
**Actions:**
- Add a "Related posts" block to `blog/show.blade.php` (link 2–3 sibling posts from `blog-posts.php`).
- Add "Related case studies" to `case-studies/show.blade.php`.
- Link blog posts contextually from relevant service/hire pages (e.g. the Laravel hire page → "How to Hire Laravel Developers" post — the post already exists).
- Cross-link case studies to the matching service/technology pages.

### P1.3 ⚠️ E-E-A-T / trust cleanup — Effort: M
**Problem:** Placeholder social profiles; testimonials/stats may be illustrative. (Audit §14)
**Actions:** Stand up real LinkedIn/X/GitHub profiles (feeds `sameAs`). Verify or clearly frame testimonials, "320+ developers placed", "Since 2018", "94% retention". Consider an author bio/`Person` schema for blog authors.

### P1.4 ⚠️ Add `<lastmod>` to all sitemap URLs — Effort: S/M
**File:** `app/Support/Sitemap.php`
**Action:** Give static/data-file pages a stable `lastmod`. Options: a per-page constant map, or derive from the data file's `filemtime()` / a content-hash date. DB projects already emit `updated_at` — good pattern to extend.

### P1.5 ⚠️ Label the country-code dropdown (a11y) — Effort: S
**File:** `resources/views/components/lead-form.blade.php:72-82`
**Action:** Add `aria-label="Select country dial code"` to the `<button>`. Optionally add a visually-hidden `<label>` for the hidden `country_code` input. Targets the 3 unlabeled controls in the 92/100 a11y score. (Audit §16)

### P1.6 ⚠️ Make (or remove) the newsletter form — Effort: S/M
**File:** `resources/views/components/footer.blade.php:57` (`action="#"`)
**Action:** Wire to a real subscribe route/provider, or remove until ready. A dead POST-to-`#` form is a UX/trust smell.

---

## Priority 2 — Performance & GEO (measure first)

### P2.1 ⚠️ Self-host / trim Google Fonts — Effort: M
**File:** `resources/views/layouts/{app,landing}.blade.php:11-13`
**Action:** Subset to used weights, self-host WOFF2 (kills a render-blocking third-party request in the LCP path), keep `font-display: swap`. Re-measure LCP.

### P2.2 ⚠️ Add `width`/`height` (or aspect-ratio) to content images — Effort: S
**Files:** `home.blade.php:376`, `case-studies/index.blade.php`, `case-studies/show.blade.php`
**Action:** Set intrinsic dimensions to prevent CLS. Some containers already use `aspect-[16/9]` — extend that pattern. (Audit §10, §17)

### P2.3 ⚠️ Serve raster images as WebP/AVIF — Effort: M
**Action:** Convert `public/images/logo.png` (135 KB) and project uploads; prefer the existing SVG mark where possible. Consider an image pipeline for `storage/projects/*`.

### P2.4 ℹ️ AI crawler policy in robots.txt — Effort: S
**File:** `public/robots.txt`
**Action:** Make the decision explicit. For a services business, **allowing** AI crawlers typically aids GEO/AEO — document it, e.g.:
```
User-agent: GPTBot
Allow: /
User-agent: ClaudeBot
Allow: /
# ...or Disallow: / if you want to opt out
```

### P2.5 ℹ️ Add `llms.txt` — Effort: S
**Problem:** `/llms.txt` 404. (Audit §6, GEO)
**Action:** Add `public/llms.txt` with site name, one-line description, and links to key pages (services, hire pages, case studies, blog) to aid AI-search comprehension.

### P2.6 ⚠️ Get real CWV numbers — Effort: S
**Action:** Configure a `PAGESPEED_API_KEY` and re-run `pagespeed.py --strategy mobile|desktop`, or use https://pagespeed.web.dev. Re-baseline before/after P2.1–P2.3. (Audit §17 — currently Hypothesis-only.)

### P2.7 ℹ️ Confirm production env — Effort: S
**Action:** Verify production `.env` has `APP_ENV=production` and `APP_URL=https://opacify.in` (committed `.env` shows `local`/`http://localhost`). Affects sitemap generation and any `config('app.url')` consumer. (Audit §2)

---

## Quick-Reference: Fix → File Map

| # | Fix | Primary file(s) | Sev | Effort |
|---|-----|-----------------|:---:|:------:|
| P0.1 | OG/Twitter tags | `layouts/app.blade.php`, `layouts/landing.blade.php` | 🔴 | S |
| P0.2 | Default OG image | `public/images/og-default.png` | 🔴 | S |
| P0.3 | Blog meta description | `pages/blog/show.blade.php`, `data/blog-posts.php` | 🔴 | S |
| P0.4 | Org + WebSite JSON-LD | `layouts/app.blade.php`, new schema partial | 🔴 | S |
| P0.5 | Real footer social links | `components/footer.blade.php` | 🔴 | S |
| P0.6 | Security + cache headers | nginx conf / new middleware | ⚠️ | S/M |
| P1.1 | Page-type JSON-LD | blog/service/tech/case-study views | 🔴/⚠️ | M |
| P1.2 | Orphan internal links | blog/show, case-studies/show, hire/service pages | ⚠️ | M |
| P1.3 | E-E-A-T / trust | footer, testimonials, author bios | ⚠️ | M |
| P1.4 | Sitemap `lastmod` | `app/Support/Sitemap.php` | ⚠️ | S/M |
| P1.5 | Country dropdown a11y | `components/lead-form.blade.php` | ⚠️ | S |
| P1.6 | Newsletter form | `components/footer.blade.php` | ⚠️ | S/M |
| P2.1 | Self-host fonts | `layouts/*.blade.php` | ⚠️ | M |
| P2.2 | Image dimensions/CLS | case-study & home image views | ⚠️ | S |
| P2.3 | WebP/AVIF | `public/images/`, storage pipeline | ⚠️ | M |
| P2.4 | AI crawler policy | `public/robots.txt` | ℹ️ | S |
| P2.5 | llms.txt | `public/llms.txt` | ℹ️ | S |
| P2.6 | Measure CWV | (ops) PSI API key | ⚠️ | S |
| P2.7 | Prod env check | production `.env` | ℹ️ | S |

---

## Suggested Rollout

1. **Sprint 1 (P0):** OG/Twitter + default image + blog meta + Org/WebSite schema + real social links + headers. One PR touching mostly `layouts/app.blade.php` — recovers social sharing, kills the duplicate-meta bug, and lands baseline structured data.
2. **Sprint 2 (P1):** Per-page schema, internal-link cross-references, sitemap lastmod, a11y + newsletter fixes, E-E-A-T cleanup.
3. **Sprint 3 (P2):** Fonts, images/CLS, robots AI policy, llms.txt, then re-measure CWV and re-run the audit scripts to confirm score movement.

**Re-audit after Sprint 1:** re-run `social_meta.py`, `validate_schema.py`, and `security_headers.py` — expect social 0→90+, security 25→~75, and the blog duplicate-meta flag cleared.
