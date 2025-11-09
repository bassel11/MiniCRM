# Mini CRM - Backend (Laravel)

## Requirements
- PHP 8.2, Composer, MySQL / SQLite, XAMPP (Windows)
- Node (optional for frontend)

## Setup
1. `composer install`
2. copy `.env.example` → `.env` and set DB credentials
3. `php artisan key:generate`
4. `php artisan migrate --seed`
5. `php artisan serve`

## Running queue & scheduler (dev)
- Queue worker: `php artisan queue:work`
- Scheduler (dev): `php artisan schedule:work` (or use OS scheduler in prod)

## API
- `POST /api/login` → {email,password} returns token
- `GET /api/clients` (auth)
- `POST /api/communications` (auth)
- `GET /api/dashboard` (auth)

## Design decisions
- Auth: Sanctum — lightweight token-based auth for SPA/Mobile
- Roles: spatie/laravel-permission — robust role system
- Architecture: simple Clean Architecture layering (Domain / Application / Infrastructure)
- Events & Jobs: Communication events update client state asynchronously
