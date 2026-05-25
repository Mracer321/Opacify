# Hire Developer

Premium software agency & developer hiring platform — **Laravel 12** + Blade + Tailwind CSS + Alpine.js.

**Site:** [hiredeveloper.co.in](https://hiredeveloper.co.in)

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+

## Quick start

```bash
# Install PHP dependencies (if vendor/ is missing)
composer install

# Install frontend dependencies
npm install

# Build assets (or use dev server)
npm run build

# Configure environment
copy .env.example .env   # Windows
php artisan key:generate

# Run the app
php artisan serve
```

Open **http://127.0.0.1:8000**

### Development (hot reload)

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

## Frontend pages

| URL | View |
|-----|------|
| `/` | `resources/views/pages/home.blade.php` |
| `/services` | `pages/services/index.blade.php` (overview) |
| `/services/{slug}` | `pages/services/show.blade.php` (detail) |
| `/about`, `/contact` | `pages/about`, `pages/contact` |
| `/blog`, `/blog/{slug}` | `pages/blog/*` |
| `/case-studies`, `/case-studies/{slug}` | `pages/case-studies/*` |
| `/lp/hire-developers` | `pages/landing/ads.blade.php` |
| `/hire-*-developers` | SEO technology pages |

Routes are defined in `routes/web.frontend.php` (included from `routes/web.php`).

### Service detail URLs

- `/services/web-development`
- `/services/mobile-app-development`
- `/services/erp-solutions`
- `/services/software-development`
- `/services/digital-marketing`
- `/services/ai-automation`

Service content lives in `resources/data/services.php`.

## Project structure

```
app/                 # Laravel application
resources/views/     # Blade layouts, components, pages
resources/css/       # Tailwind entry (app.css)
resources/js/        # Alpine.js entry
routes/web.php       # Includes web.frontend.php
```

Forms are UI-only (`action="#"`) until backend logic is added.
