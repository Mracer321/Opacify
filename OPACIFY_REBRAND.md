# OpacifyWeb Rebrand

Low-cost rebrand of the existing HireDeveloper website into **OpacifyWeb** (company: Opacify, domain: https://opacifyweb.in). The hiring flow, routing, page structure, SEO URLs, and backend behavior are unchanged.

## 1. Files changed

Theme:
- `tailwind.config.js` — primary `brand` + `accent` color scales, `card-hover` shadow tint.
- `resources/css/app.css` — hero gradient tint, `.fab-call` button color.

Branding / SEO (brand name + domain swap only):
- `resources/views/layouts/app.blade.php`, `resources/views/layouts/landing.blade.php`
- `resources/views/components/navbar.blade.php`, `footer.blade.php`, `brand-logo.blade.php`, `floating-actions.blade.php`
- `resources/views/pages/`: `home`, `about`, `contact`, `technology`, `services/index`, `services/show`, `blog/index`, `blog/show`, `case-studies/index`, `case-studies/show`, `landing/ads`, `hire-laravel-developers`, `hire-react-developers`, `hire-nodejs-developers`, `hire-flutter-developers`
- `README.md`

## 2. Branding changes

- Brand name `Hire Developer` → `OpacifyWeb` in titles, meta descriptions, footer, copyright, nav/aria labels, logo alt text, and testimonials.
- Domain `hiredeveloper.co.in` → `opacifyweb.in` in canonicals, footer link, and email.
- Verb phrases like "hire developers…" (e.g. CTA banner, section headings) were intentionally **left unchanged** — they describe the action, not the brand.

## 3. Theme changes

- Primary brand accent changed from orange `#FF7A45` to Opacify blue `#6377EE` at the central Tailwind source (scale `brand.500` / `accent.500`), so all `brand-*` / `accent-*` utilities recolor automatically.
- Matching darker shade `#4557d8` used for hover states; brand-tinted shadow/gradient rgba values updated to blue.
- Layout, spacing, typography, components, and responsive behavior untouched.

## 4. SEO changes

- Page titles, meta descriptions, and canonical URLs rebranded to OpacifyWeb / opacifyweb.in.
- SEO URL paths (e.g. `/hire-laravel-developers`, `/lp/hire-developers`) preserved — only the domain changed.
- No OG/Twitter/JSON-LD/sitemap in the codebase to update; `public/robots.txt` is generic (no domain) and left as-is. No landing pages removed.

## 5. Performance improvements

- No regressions. `brand-logo` already ships explicit `width`/`height`, `decoding="async"`, and eager loading. `npm run build` output unchanged in size (CSS 64.2 kB / gzip 9.6 kB). No oversized assets introduced. No premature optimization performed.

## 6. Owner actions required

- **Logo:** No Opacify logo asset exists in the repo. Existing `public/images/logo.png` / `logo-dark.png` / `favicon.png` are retained (alt text now reads "OpacifyWeb"). Provide the real logo at `public/images/brand/opacify-logo.svg` (or replace the existing PNGs) using the OPACIFY wordmark.
- **Email:** `hello@hiredeveloper.co.in` was updated to `hello@opacifyweb.in` to match the new domain — confirm this mailbox exists.
- **Verify / replace placeholder factual data** (unchanged, may not represent OpacifyWeb):
  - Phone `+91 98765 43210` (footer + floating call button).
  - Testimonials, client names, and "since 2018" agency history in `about`, `home`, `case-studies`.
  - "software agency" positioning copy — left intact per no-rewrite rule; adjust if OpacifyWeb should read strictly as a hiring platform.

## 7. Retained old references (intentional)

- `.env.example` → `DB_DATABASE=hiredev_db`: internal database name, left unchanged per instructions.
- Verb phrases "hire developers who deliver" / "Hire developers across your entire stack" / "whether you hire developers": product action wording, not brand names.

## 8. Test results

- `npm run build` — ✅ built successfully (Vite, ~2s).
- `php artisan test` — ✅ 2 passed (2 assertions). No new failures.
