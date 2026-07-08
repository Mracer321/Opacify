# SEO Audit Report — OpacifyWeb

- **Site:** https://opacify.in
- **Stack:** Laravel (Blade server-rendered, Vite/Tailwind, Alpine.js), nginx/1.24 (Ubuntu)
- **Audit date:** 2026-07-08
- **Scope:** Source code (`/e/PROJECTS/Opacify`) + deployed site (https://opacify.in)
- **Method:** LLM-first analysis with script-backed evidence (SEO skill v1). Live HTML fetch, robots/sitemap/social/canonical/security/redirect/broken-link/internal-link/a11y/image/indexability checks executed against production.

---

## 1. Executive Summary

| Category | Weight | Score | Rating |
|----------|:------:|:-----:|--------|
| Technical SEO | 25% | 72 | Good |
| Content Quality & E-E-A-T | 20% | 60 | Needs Improvement |
| On-Page SEO | 15% | 80 | Good |
| Schema / Structured Data | 15% | 10 | Critical |
| Performance (CWV) | 10% | 60* | Needs Improvement |
| Image Optimization | 10% | 72 | Good |
| AI Search Readiness (GEO) | 5% | 25 | Poor |
| **Overall** | 100% | **≈58** | **Needs Improvement** |

*\*CWV score is a Hypothesis — Google PageSpeed Insights was rate-limited (no API key). See §16 and Environment Limitations.*

**The single biggest wins:** the site has clean, well-structured on-page fundamentals (unique titles, self-referencing canonicals, one `<h1>` per page, alt text on all images, strong internal linking, valid sitemap and robots). What holds it back is a near-total absence of **social share metadata (Open Graph / Twitter Cards)** and **structured data (Schema.org JSON-LD)**, plus **missing security/caching headers** and one **duplicate-metadata bug on blog posts**. These are high-impact, low-effort fixes concentrated in the shared layout.

### Severity Rollup

- 🔴 **Critical (5):** No Open Graph tags · No Twitter Cards · No structured data · Blog posts share the homepage meta description (duplicate) · No default OG share image.
- ⚠️ **Warning (10):** Security headers missing (HSTS/CSP/X-Frame-Options/etc.) · `Cache-Control: no-cache` on HTML · Placeholder footer social links (one broken) · Non-functional newsletter form · 3 unlabeled form controls · Sitemap missing `<lastmod>` on most URLs · AI crawlers unmanaged in robots · No `llms.txt` · Deep case-study/blog pages weakly linked (orphan-ish) · Thin blog/case-study content volume.
- ✅ **Pass (many):** See per-category detail below.

---

## 2. Technical SEO

| Check | Result | Severity |
|-------|--------|:--------:|
| HTTPS | Yes, valid | ✅ |
| Redirect chain (home) | 0 hops, 200 direct (238 ms) | ✅ |
| Trailing-slash normalization | `.htaccess` 301-strips trailing slashes | ✅ |
| Legacy-slug redirects | `/technologies/{laravel,react,nodejs,flutter}` → `/hire-*-developers` (301); old case-study slug 301; `/faqs` → `/#faqs` (301) | ✅ |
| Server | nginx/1.24 (Ubuntu) | ℹ️ |
| Security headers | 25/100 — 6 missing | ⚠️ |
| HTML cache policy | `Cache-Control: no-cache, private` on every page | ⚠️ |
| Indexability (home) | `indexable`, HTTP 200 | ✅ |

**Evidence — redirects & cannibalization handling (`routes/web.frontend.php:52-73`):** the codebase deliberately 301-redirects technology equivalents to canonical hire pages to avoid duplicate content — a genuinely good practice, mirrored in `app/Support/Sitemap.php` which excludes the redirected slugs.

**Evidence — security headers (`security_headers.py`):** Security Score **25/100**. Missing: `Strict-Transport-Security` (HSTS), `Content-Security-Policy`, `X-Frame-Options`, `X-Content-Type-Options`, `Referrer-Policy`, `Permissions-Policy`. Not a direct ranking factor, but HSTS + `X-Content-Type-Options` are trust/safety signals and `X-Frame-Options` prevents clickjacking.

**Evidence — caching (`curl -I`):** the homepage returns `Cache-Control: no-cache, private`. This is Laravel's default for responses that touch the session (the enquiry forms use CSRF/session cookies). It forces revalidation on every request and defeats browser/CDN caching of HTML — a TTFB and repeat-visit performance drag.

**Config note:** `.env` has `APP_ENV=local` and `APP_URL=http://localhost`. Canonicals are hard-coded absolute in Blade so they render correctly in production, but `app/Support/Sitemap.php` builds URLs from `config('app.url')`. The live sitemap correctly emits `https://opacify.in/...`, so production env differs from the committed `.env` — verify the production `.env` sets `APP_ENV=production` and `APP_URL=https://opacify.in`.

---

## 3. Metadata (Titles & Descriptions)

**Base layout** (`resources/views/layouts/app.blade.php:7-9`) provides sensible `@yield` defaults for `title`, `meta_description`, `canonical`. Every content page overrides them via `@section`.

| Page | Title length | Meta desc | Canonical |
|------|:------------:|:---------:|:---------:|
| Home | 60 | ✅ unique | ✅ |
| About | 52 | ✅ | ✅ |
| Services (index + show) | 45 | ✅ | ✅ |
| Contact | 45 | ✅ | ✅ |
| Case studies (index + show) | 59 / dynamic | ✅ | ✅ |
| Hire-* (4 pages) | 44–46 | ✅ unique per page | ✅ |
| Technologies/{slug} | dynamic, unique | ✅ unique | ✅ |
| Legal (privacy/terms) | 30–32 | ✅ | ✅ |
| Blog index | 60 | ✅ | ✅ |
| **Blog show** | 38 | 🔴 **MISSING** | ✅ |

**🔴 Critical — Blog posts have no meta description.** `resources/views/pages/blog/show.blade.php` sets `@section('title')` and `@section('canonical')` but **omits `@section('meta_description')`**. All four blog posts therefore fall back to the layout default (the homepage's "Hire experienced Laravel, React…" description). Confirmed on the live site (`social_meta.py` shows the home description is the generic default). This produces **duplicate meta descriptions** across the blog and wastes SERP snippet real estate on hire-intent copy that doesn't match the article.

**Titles:** all in the 30–68 char range (good — under the ~60 char pixel limit for most). Consistent `— OpacifyWeb` brand suffix. No duplicates detected.

---

## 4. Canonical URLs

- ✅ Every page emits a self-referencing `<link rel="canonical">` (17 `@section('canonical')` declarations across the views).
- ✅ Canonicals are absolute and hard-coded to the production host (`https://opacify.in/...`), so they're stable regardless of request host.
- ✅ `canonical_checker.py` on the homepage returns `self_canonical` — canonical matches the served URL.
- ⚠️ **Minor consistency nit:** the homepage canonical is `https://opacify.in` (no trailing slash) while the server serves `https://opacify.in/`. Google treats these as equivalent and the checker passed, but for cleanliness align the canonical, sitemap `loc`, and future `og:url` on the same form.

---

## 5. Open Graph & Twitter Cards

**🔴 Critical — effectively absent site-wide.** `social_meta.py` scores the homepage **0/100**.

- Open Graph: **0/7** — `og:title`, `og:description`, `og:image`, `og:url`, `og:type` all missing.
- Twitter Card: **0/6** — `twitter:card` and all others missing.
- The **only** OG tag anywhere in the codebase is a lone `og:image` pushed on case-study detail pages (`resources/views/pages/case-studies/show.blade.php:30`) — but with no `og:title`/`og:type`/`og:url` alongside it, crawlers can't build a valid card from it.

**Impact:** every link shared to LinkedIn, X, Slack, WhatsApp, Facebook, or iMessage renders as a bare URL with no image, no controlled title, and no description. For a B2B lead-gen site that relies on referral and social sharing, this suppresses click-through on exactly the channels where decision-makers share vendors.

**Also:** `https://opacify.in/images/og-default.png` returns **404** — there is no default share image to fall back to.

---

## 6. robots.txt

`public/robots.txt` (live 200):

```
User-agent: *
Allow: /
Disallow: /admin
Disallow: /enquiries
Disallow: /up
Sitemap: https://opacify.in/sitemap.xml
```

- ✅ Correctly disallows admin, the enquiry POST endpoint, and the health-check `/up`.
- ✅ Declares the sitemap.
- ⚠️ **AI crawlers unmanaged (`robots_checker.py`):** 11 AI/LLM crawlers (GPTBot, ChatGPT-User, ClaudeBot, PerplexityBot, Google-Extended, Applebot-Extended, Bytespider, CCBot, anthropic-ai, FacebookBot, Amazonbot) inherit the wildcard `Allow: /`. This is a **policy decision, not a bug** — for a services business, allowing AI crawlers usually *helps* GEO/AEO visibility. Make it explicit either way so the intent is documented.

---

## 7. sitemap.xml

Generated dynamically (`app/Http/Controllers/SitemapController.php` + `app/Support/Sitemap.php`, rendered via `resources/views/sitemap/xml.blade.php`).

- ✅ Live sitemap returns valid XML, **60 URLs**, correct `Content-Type: application/xml`.
- ✅ Includes static pages, hire pages, all services, all non-redirected technologies, blog posts, and published projects.
- ✅ Correctly **excludes** the 4 redirected technology slugs (avoids listing 301 sources).
- ⚠️ **`<lastmod>` missing on most URLs (`sitemap_checker.py`: 56 info-level flags).** Only DB-backed projects carry `lastmod` (from `updated_at`); every static/data-file page has none. `<lastmod>` helps crawl scheduling — add stable dates for data-driven pages.
- ℹ️ No `<changefreq>`/`<priority>` (deprecated/ignored by Google — fine to omit).

---

## 8. Structured Data (Schema.org)

**🔴 Critical — zero structured data.** `grep` across all views finds no `application/ld+json`; the rendered homepage contains **0** JSON-LD blocks.

Missing high-value schema for this site type:

| Schema | Where it belongs | Benefit |
|--------|------------------|---------|
| `Organization` | Global (layout) | Knowledge panel, logo, `sameAs` social profiles |
| `WebSite` + `SearchAction` | Global (layout) | Sitelinks search box eligibility |
| `Service` | `/services/{slug}`, hire pages | Richer service understanding |
| `BreadcrumbList` | Case studies, blog, tech pages (breadcrumb nav already exists in markup) | Breadcrumb rich result |
| `BlogPosting` / `Article` | `/blog/{slug}` | Article rich results, author/date signals, AI citation |
| `FAQPage` | Homepage FAQ block | ⚠️ **Do NOT add** — FAQ rich results are restricted to gov/health authority sites since Aug 2023. |

The breadcrumb navigation is already rendered as visible markup on tech and case-study pages (`aria-label="Breadcrumb"`), so `BreadcrumbList` JSON-LD is a near-free add. Use JSON-LD only (never Microdata/RDFa).

---

## 9. Heading Hierarchy

- ✅ **Exactly one `<h1>` per page.** Live homepage confirmed: 1 × `<h1>`, 11 × `<h2>`. Pages that showed "0 h1" in a raw view grep render their `<h1>` from shared components (`technology-page.blade.php:16`, `service-detail-page.blade.php:15`, `legal-page.blade.php:9`) — verified.
- ✅ Logical `h1 → h2 → h3` nesting in section headers and cards.
- ✅ `<h1>` copy is keyword-aligned ("Hire Expert Laravel Developers", "Hire Top Remote Developers For Your Projects").
- ℹ️ Minor: a few decorative section labels use `<h2>`/`<h3>` via the `x-section-header` component; hierarchy stays valid.

---

## 10. Image ALT Attributes

- ✅ `a11y_seo_checker.py`: **0 images missing alt** on the homepage.
- ✅ All 6 `<img>` sources in the codebase carry `alt`:
  - Brand logo (`brand-logo.blade.php`): `alt="OpacifyWeb"`, plus `width`/`height` and `loading="eager"` / `decoding="async"` — good CLS hygiene.
  - Case-study images (`home.blade.php`, `case-studies/index.blade.php`, `case-studies/show.blade.php`): `alt="{{ $project->title }}"`, `loading="lazy"`.
- ⚠️ Project/case-study images lack explicit `width`/`height` → potential **CLS** as they load. The logo sets them; content images should too (or use aspect-ratio boxes — some already use `aspect-[16/9]`).
- ℹ️ `public/images/logo.png` is 135 KB (PNG). If used anywhere above the fold, convert to WebP/AVIF. The primary brand mark is already an optimized SVG (`opacify-logo.svg`, 2 KB) — good.

---

## 11. Internal Linking

- ✅ **Strong.** `internal_links.py`: 21 pages crawled, **1,026 internal links**, avg **48.9 links/page** (min 48, max 54) — driven by a comprehensive navbar mega-menu and footer.
- ✅ Descriptive anchor text on primary nav ("Case Studies", "Hire Laravel Developers", service names).
- ⚠️ **8 "orphan-ish" deep pages (≤1 incoming link):** all 4 blog posts and 4 case-study detail pages. They're reachable only from their index listing. Add contextual cross-links (related posts, related case studies, blog→service links) to distribute authority and improve crawl depth.
- ⚠️ **21 links with no anchor text** — the logo/home links where the anchor wraps an SVG/image. These already have `aria-label` on the nav brand link, but the footer brand link and social icons rely on `aria-label`; ensure every icon-only link has one (most do).

---

## 12. Broken Links

- `broken_links.py`: 57 links checked → **54 healthy, 1 broken, 2 redirected**.
- 🔴 **Broken:** `https://twitter.com` returns **403** — this is a **placeholder footer social link** (`footer.blade.php:17`). Along with `https://linkedin.com` and `https://github.com`, these point to the networks' generic homepages, not OpacifyWeb profiles.
- ↪️ 2 redirected links are benign (external targets that 301/302).

---

## 13. Duplicate Metadata

- 🔴 **Blog posts (4) share the homepage default meta description** — see §3. This is the only true duplicate-metadata defect, but it affects the entire blog section.
- ✅ Titles: all unique.
- ✅ Canonicals: all unique and self-referencing.
- ✅ No duplicate H1s across templates.

---

## 14. Thin Content

- ⚠️ **Blog:** only **4 posts**, each ~350–450 words (e.g. `how-to-hire-laravel-developers`). Serviceable but on the thin side for competitive "hire developers" queries; aim for 800–1,200 words with unique depth.
- ⚠️ **Case studies:** 4 published projects. Content depth depends on DB records; ensure each has substantive results/process copy, not just a summary.
- ✅ **Hire & technology pages** are content-rich (capabilities, benefits, workflow, engagement models, longform, related tech) — no thin-content concern there.
- ℹ️ **E-E-A-T caution:** homepage testimonials name specific people/companies ("Priya Mehta, CTO, FinEdge Payments") and stats ("320+ developers placed", "Since 2018"). If these are illustrative rather than real, they're an E-E-A-T and trust risk. Similarly the footer's placeholder social profiles weaken authority signals. Verify claims are substantiated.

---

## 15. Mobile Friendliness

- ✅ `<meta name="viewport" content="width=device-width, initial-scale=1.0">` present.
- ✅ Mobile-first indexing is 100% in effect (since 2024-07-05); the responsive Tailwind layout, dedicated mobile nav (`aria-label="Mobile"`), and mobile carousels (`x-mobile-carousel`, swipe sliders) indicate deliberate mobile UX.
- ✅ Tap targets: mobile CTA buttons use `min-h-[3rem]`.
- ℹ️ Could not run PSI mobile (rate-limited) to confirm no mobile-specific layout shifts.

---

## 16. Accessibility

- ✅ `a11y_seo_checker.py`: **92/100**.
- ✅ `<html lang="en">`, viewport set, 1 × h1, all images have alt, landmarks present (main, nav×2, header, footer), honeypot field correctly `aria-hidden`.
- ⚠️ **3 form controls appear unlabeled.** In `lead-form.blade.php` the visible inputs are all properly `<label for>`-associated; the unlabeled ones are the custom country-code **`<button>` dropdown** and the hidden `country_code` input. Give the country button an `aria-label` (e.g. "Select country dial code"). Skip-link/`#main-content` target exists in `app.blade.php` (good).
- ✅ Semantic `<article>`, `<nav aria-label>`, `<ol>`/`<dl>` used appropriately.

---

## 17. Core Web Vitals — Opportunities

> ⚠️ **Confidence: Hypothesis.** Google PageSpeed Insights (mobile + desktop) was **rate-limited without an API key** — no field/lab metrics captured. The following are code-derived opportunities, not measured regressions.

- **Render-blocking Google Fonts:** `app.blade.php:11-13` loads two font families (DM Sans + Plus Jakarta Sans) with many weights/italics from `fonts.googleapis.com`. Preconnect is present (good), but this is still a blocking cross-origin request in the critical path. Self-host the WOFF2 subsets or reduce weights to cut LCP.
- **`Cache-Control: no-cache` on HTML** (see §2) hurts TTFB on repeat views and prevents CDN HTML caching.
- **No `width`/`height` on content images** (§10) → CLS risk.
- **Vite assets** are hashed and `modulepreload`ed (good for cache-busting), and CSS is preloaded — solid setup; the `no-cache` header is the mismatch.
- **Above-the-fold:** hero is text + a lead form (light); LCP is likely the `<h1>` or hero — favorable, assuming fonts don't block.
- ✅ Images use `loading="lazy"` (content) and `loading="eager"` (logo) appropriately.

---

## 18. Indexability

- ✅ Homepage: `indexable`, HTTP 200, no `noindex`.
- ✅ No `<meta name="robots" content="noindex">` found in any view.
- ✅ Admin, enquiry endpoint, and health check are disallowed in robots.
- ✅ Canonical strategy prevents duplicate indexing of the redirected technology slugs.
- ℹ️ Confirm the landing page `/lp/hire-developers` (ad landing, uses the minimal `layouts.landing` with no OG/canonical-default logic beyond the section) should indeed be indexable — it's in the sitemap and has its own canonical, so it is. That's fine unless it's meant for paid traffic only.

---

## 19. URL Structure

- ✅ Clean, lowercase, hyphenated, keyword-rich: `/hire-laravel-developers`, `/services/mobile-app-development`, `/case-studies/{slug}`, `/technologies/{slug}`.
- ✅ No query strings, no IDs, no file extensions, shallow depth (≤2 segments).
- ✅ Hire-intent slugs are the canonical home for high-demand stacks; generic tech pages 301 to them — good keyword consolidation.
- ✅ Trailing slashes normalized via `.htaccess`.

---

## 20. Performance Optimizations (code-level)

- ✅ Vite bundling + hashed assets + `modulepreload` + CSS preload.
- ✅ `preconnect` to Google Fonts origins.
- ✅ Lazy-loaded content images; async-decoded eager logo.
- ⚠️ Self-host or trim Google Fonts (render-blocking).
- ⚠️ Fix HTML cache headers for cacheable (non-session-critical) pages, or move CSRF-dependent bits so static marketing pages can be edge-cached.
- ⚠️ Serve `logo.png` (135 KB) as WebP/AVIF if used; prefer the SVG mark.
- ℹ️ Consider a CDN in front of nginx for static assets and (cacheable) HTML.

---

## Environment Limitations

- **PageSpeed Insights (CWV):** mobile and desktop runs were **rate-limited by Google's API** (no API key configured). CWV findings are Hypotheses derived from source. To get field data, set a `PAGESPEED_API_KEY` and re-run `pagespeed.py`, or use the [PSI web UI](https://pagespeed.web.dev/analysis?url=https://opacify.in).
- **Screenshots / visual regression:** Playwright not invoked in this pass (not required for the requested audit set).
- **Local Python:** the machine's `python3`/`py -3` shims initially failed; audit scripts were run with an explicit CPython 3.14 interpreter and `PYTHONUTF8=1`. All non-PSI checks completed successfully against production.

---

## Evidence Index (scripts run)

| Script | Target | Key output |
|--------|--------|-----------|
| `fetch_page.py` | home | 200, HTML saved |
| `robots_checker.py` | site | 200, 3 disallow, 11 AI crawlers unmanaged |
| `sitemap_checker.py` | site | 60 URLs, 56 missing-lastmod |
| `social_meta.py` | home | **0/100** OG+Twitter |
| `canonical_checker.py` | home | self_canonical OK |
| `security_headers.py` | site | **25/100**, 6 missing |
| `redirect_checker.py` | home | 0 hops, 200 |
| `broken_links.py` | home | 1 broken (twitter.com placeholder) |
| `internal_links.py` | site | 1026 links, 8 orphan-ish, 21 no-anchor |
| `a11y_seo_checker.py` | home | **92/100**, 3 unlabeled controls |
| `image_inventory.py` | home | all images 200/alt OK |
| `indexability_matrix.py` | home | indexable 200 |
| `llms_txt_checker.py` | site | 404 (no llms.txt) |
| `pagespeed.py` | site | rate-limited (env limitation) |

See **SEO_FIX_PLAN.md** for prioritized, file-level remediation.
