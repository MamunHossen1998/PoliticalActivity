## Quick orientation

This repository is a Laravel 12 web application (PHP 8.2). Key high-level facts an AI code assistant should know up-front:

- The app lives under `app/` (models in `app/Models`, controllers in `app/Http/Controllers`).
- Frontend assets are built with Vite (`vite.config.js`) and node scripts in `package.json`.
- Database migrations and seeders live in `database/migrations` and `database/seeders`.
- Tests use Pest (see `phpunit.xml` and `tests/`), with an in-memory SQLite test DB configured for CI/local tests.
- Several third-party packages are important: `spatie/laravel-permission`, `spatie/laravel-activitylog`, and `barryvdh/laravel-dompdf` (see `composer.json`).

## Important files & where to look for patterns

- Routing and segmentation: `routes/web.php` — the app uses a dynamic `{segment}` prefix and middleware `ensure.segment`. When changing routes or authentication, read `web.php` first.
- Helpers: `app/Helpers/helpers.php` is autoloaded via Composer (`composer.json`) and contains global helper functions used across the app.
- Models: examples include `app/Models/User.php`, `Role.php`, `Permission.php`, `Branch.php`, `Doctor.php`, `Appointment.php`. Check these for relationships and attribute casts.
- Config & packages: `config/permission.php` and `config/activitylog.php` configure Spatie packages — changes to roles/permissions should respect these configs.
- Seeds & migrations: use `database/seeders/` and `database/migrations/` to understand initial data and DB shape (seeders include `BranchSeeder.php`, `AppointmentStatusSeeder.php`, etc.).
- Tests: `tests/` and `phpunit.xml` — tests run with `DB_CONNECTION=sqlite` and `:memory:` DB by default.

## Common developer workflows (commands you can suggest or run)

- Install & setup (recommended): run `composer install`, copy `.env.example` to `.env`, `php artisan key:generate`, `php artisan migrate --seed`, then `npm install` and `npm run dev` or `npm run build`.
- Helpful composer scripts (in `composer.json`):
  - `composer run setup` — runs an opinionated setup sequence (composer install, env copy, key generate, migrate, npm build).
  - `composer run dev` — runs `php artisan serve`, worker, and Vite concurrently (uses `npx concurrently`).
  - `composer run test` — clears config cache then runs `php artisan test` (Pest).
- Run tests locally: `composer run test` or `vendor/bin/pest`.
- Serve locally: `php artisan serve` (the codebase author commonly uses Laragon on Windows; you may see `d:\laragon` in paths).
- Asset dev: `npm run dev` (Vite) and `npm run build` for production assets.

## Project-specific conventions & gotchas

- Multiple non-standard route files exist (e.g., `routes/asad.php`, `routes/karzon.php`, `routes/mehedi.php`) — search `routes/` when adding routes; these may contain domain-specific features or legacy endpoints.
- Routes rely on a session key `route_segment` and the `ensure.segment` middleware. Be careful when changing authentication or redirect logic — preserve segmented routing.
- Global helper functions are defined in `app/Helpers/helpers.php` and are expected to be available everywhere because Composer `files` autoloads it.
- Role & permission model mapping follows Spatie's package conventions; changes to DB schema or seeding should update `config/permission.php` and relevant seeders.
- Tests assume an in-memory SQLite DB (see `phpunit.xml`) — if a test requires raw SQL features absent in SQLite, either adapt the test or run with a MySQL/Postgres test config.

## Integration points to watch

- Auth & session — controllers in `app/Http/Controllers/Backend/` handle login/session and tie into segmented routing.
- Queue workers — `composer run dev` runs `php artisan queue:listen`; background job behavior matters for features like notifications.
- Third-party config: vendor publishers and migrations for Spatie packages are important when upgrading or changing permissions/activity logging.

## How to propose code changes (short checklist for suggestions/PRs)

1. Run `composer run test` locally and make sure tests pass (Pest). If you add DB-affecting code, update or add seeders under `database/seeders/`.
2. For route/controller changes, confirm behavior across segmented routes in `routes/web.php` and middleware `ensure.segment`.
3. If touching frontend assets, run `npm run dev` and ensure Vite rebuilds (or `npm run build` for production).
4. When modifying global helpers, put tests under `tests/Unit` and avoid changing function names used across the app.

## Quick examples from the codebase

- Segmented dashboard redirect (see `routes/web.php`): when hitting `/dashboard` the app reads `session('route_segment')` and redirects to `/{segment}/dashboard`.
- Composer autoload `files`: `app/Helpers/helpers.php` is autoloaded automatically — do not remove from `composer.json` unless you update the autoload.
- Tests: `phpunit.xml` uses `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:` — unit/feature tests expect this.

If anything here is unclear or you want the instructions to emphasize other areas (CI, deploy, or a different dev workflow), tell me which parts to expand and I will iterate.
