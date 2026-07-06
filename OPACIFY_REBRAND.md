# OpacifyWeb Rebrand

Rebrand of the existing HireDeveloper website into **OpacifyWeb** (company: Opacify). The hiring flow, routing, page structure, SEO URL paths, and backend behavior are unchanged.

## Key facts (final)

- **Primary production domain:** https://opacify.in (previous `opacifyweb.in` retired)
- **Official logo:** `public/images/brand/opacify-logo.svg` (owner-provided, 896×194, brand blue `#6377EE`)
- **Official phone:** `+91 88020 32023` — tel link `tel:+918802032023`
- **Contact email:** `opacifyweb@gmail.com` (Linode mail not yet ready; `hello@opacifyweb.in` NOT used)
- **Primary brand color:** `#6377EE`

## 1. Files changed

Theme: `tailwind.config.js`, `resources/css/app.css`
Logo/brand component: `resources/views/components/brand-logo.blade.php`
Layouts: `layouts/app.blade.php`, `layouts/landing.blade.php`
Components: `navbar`, `footer`, `floating-actions`, `cta-banner`, `inquiry-card`
Pages: `home`, `about`, `contact`, `technology`, `services/{index,show}`, `blog/{index,show}`, `case-studies/{index,show}`, `landing/ads`, `hire-{laravel,react,nodejs,flutter}-developers`
Docs: `README.md`, `OPACIFY_REBRAND.md`
Asset moved: `public/images/opacify-logo.svg` → `public/images/brand/opacify-logo.svg`

## 2. Logo

- Official SVG wired into `brand-logo` component (`default` + `dark` variants → `/images/brand/opacify-logo.svg`).
- Used in navbar header and footer (both via `w-auto`, aspect ratio preserved). `icon` variant still uses `favicon.png` (square) for small placements.
- SVG paths/colors untouched. Old temporary `logo.png` / `logo-dark.png` no longer referenced.

## 3. Domain & contact

- `opacifyweb.in` → `opacify.in` in all canonicals, footer link, ads footer, and absolute URLs.
- Placeholder phone `+91 98765 43210` (`tel:+919876543210`, whatsapp `919876543210`) → `+91 88020 32023` (`tel:+918802032023`) across footer, floating actions, cta-banner, inquiry-card, contact, ads.
- Email `hello@opacifyweb.in` → `opacifyweb@gmail.com` (footer + contact mailto).

## 4. Positioning cleanup

Minimally reworded "is a software agency" claims to a developer hiring platform:
- Site default title / meta (`layouts/app.blade.php`).
- About page title, meta, and intro line.
- README tagline.

Left intact (comparative/descriptive, not misrepresenting identity): "agency-grade delivery", "structured agency process", "agency quality without agency friction", "Agency discipline. Staff augmentation speed.", "When agency support helps". Existing correct hiring/technology copy preserved.

## 5. Theme

Primary accent already migrated orange `#FF7A45` → Opacify blue `#6377EE` (central Tailwind `brand`/`accent` scales, hover `#4557d8`, brand-tinted shadows/gradient, `.fab-call`). No obvious orange remains in user-facing components. No redesign performed.

## 6. SEO

- Canonicals/metadata/footer/absolute URLs updated to `opacify.in`. SEO URL paths unchanged; no landing pages removed.
- No OG/Twitter/JSON-LD/sitemap present in codebase — not added (out of scope for this pass). `public/robots.txt` is generic/valid — left unchanged.

## 7. "Since 2018"

Retained as Opacify brand/company history (about intro reworded to attribute it to the Opacify brand, not the OpacifyWeb platform). Stat notes "Since 2018" on `about` (7+ years) and `home` (180+ projects) left in place — see owner review below.

## 8. Placeholder / fabricated data — retained for owner review

Not invented or altered (except the phone number, which was a clear placeholder and is now the official number). Owner should verify or supply real values:
- Stats: `about` "7+ years", `home` "180+ projects delivered".
- Testimonials and client/company names in `home` and `case-studies`.
- Social links in footer point to bare `linkedin.com` / `twitter.com` / `github.com` — replace with real OpacifyWeb profiles or remove.

## 9. Retained old internal references (intentional)

- `.env.example` → `DB_DATABASE=hiredev_db`: internal database name, unchanged per instructions.
- Verb phrases "hire developers who deliver" / "Hire developers across your entire stack" / "whether you hire developers": product action wording, not brand names.

## 10. Test results

- `npm run build` — ✅ built successfully (Vite, ~1.4s). Bundle sizes unchanged.
- `php artisan test` — ✅ 2 passed (2 assertions). No new failures.

## 11. Remaining owner actions

1. Confirm `opacifyweb@gmail.com` is the intended public contact (until Linode mail is ready).
2. Verify/replace the stats, testimonials, and social links listed in §8.
3. Confirm the SVG logo renders acceptably on the dark footer (single-colour blue on navy); provide a light/white variant if higher contrast is wanted.
