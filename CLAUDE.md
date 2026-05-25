# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Stack

Laravel 7 (PHP ^7.2.5) app with server-rendered Blade views. Frontend assets built via Laravel Mix (webpack) with Sass. No SPA — both the public site and the admin dashboard are traditional MVC.

Key Composer packages: `spatie/laravel-permission` (RBAC), `laravelcollective/html` (form helpers), `barryvdh/laravel-dompdf` (PDF generation), `phpoffice/phpspreadsheet` (Excel), `stripe/stripe-php`, `fruitcake/laravel-cors`.

## Commands

```bash
# PHP
composer install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
php artisan serve                       # dev server on :8000
php artisan tinker

# Frontend assets (webpack.mix.js -> public/{js,css})
npm install
npm run dev          # one-shot dev build
npm run watch        # rebuild on change
npm run prod         # production build

# Tests (PHPUnit 8.5)
vendor/bin/phpunit
vendor/bin/phpunit --filter SomeTest    # single test class/method
vendor/bin/phpunit tests/Feature/X.php  # single file

# Cache / config (after editing .env, config/*, or routes)
php artisan config:clear && php artisan route:clear && php artisan view:clear
```

## Architecture

### Two-surface routing

`routes/web.php` defines two distinct surfaces, both rendered server-side:

1. **Public website** — controllers under `app/Http/Controllers/website/` (`WebsiteController`, `AccountController`) render views from `resources/views/website/`. Includes blog, services, pages, contact, user signup/login, account area, and order placement.
2. **Admin backend** — controllers under `app/Http/Controllers/backend/` render views from `resources/views/backend/`. Mounted at `/dashboard/*` and gated by `['role:Admin','auth']` middleware (Spatie). Logged-in customer area is gated by `['role:User|Admin','auth']`.

The login flow has two entry points: `/login` (admin, via `backend\LoginController`) and `/user/login` (customer, via `website\WebsiteController@userlogin`). Don't conflate them.

`routes/api.php` exists but is minimal — this app is not API-first.

### Domain model

Eloquent models live in `app/Models/` (note: the default `App\User` is at `app/User.php`, not in `Models/`). Core entities: `Orders` + `Orderchat` (customer orders with a per-order chat thread), `Blog` + `Comments`, `Services`, `Pages`, plus singleton-style content models (`Homepage`, `Aboutus`, `Privacypolicy`, `Disclaimer`, `Settings`). `Media` holds uploads.

Roles/permissions use `spatie/laravel-permission` — seeded roles include `Admin` and `User`. Use `role:` middleware (not gates) for route protection, matching the existing pattern.

### Migrations

`database/migrations/` mixes the original Laravel scaffold (users, failed_jobs, permission tables) with a later inventory schema (brands, items, suppliers, purchase_orders, locations, categories) added in 2023. The inventory tables exist in the schema but are not currently wired into the route file — verify before assuming a feature is live.

### Views & assets

- Blade templates: `resources/views/{backend,website,mail}/` with `welcome.blade.php` at the root.
- Sass entry: `resources/sass/` compiled to `public/css/` per `webpack.mix.js`.
- JS entry: `resources/js/` compiled to `public/js/`.
- Public uploads land in `public/` (served directly) rather than `storage/app/public/` in the typical Laravel pattern — check existing controller code before changing upload paths.

### Conventions to preserve

- Route definitions use the long-form array syntax (`['uses' => 'namespace\Controller@method', 'as' => 'name']`) with backslash-namespaced controller strings. New routes should match this style rather than the tuple `[Controller::class, 'method']` form, since the `RouteServiceProvider` namespace prefix is in effect.
- Controllers are organized by surface (`backend\`, `website\`), not by resource.
- There's a `cronjob` web route (`/cronjob` -> `WebsiteController@deleteUnverifiedUserCron`) invoked by an external scheduler rather than `app/Console`.
