# TFELTA Setup & Deployment

Laravel 12 school management system (single-school mode).

## Requirements

- PHP 8.2+
- MySQL 8+
- Composer
- Node.js & npm (for frontend assets)

## Local Setup (Laragon)

1. Clone/copy the project to `D:\laragon\www\TFELTA` (or your Laragon `www` folder).
2. Copy environment file and configure:
   ```bash
   copy .env.example .env
   php artisan key:generate
   ```
3. Create a fresh MySQL database (example: `tfelta`).
4. Update `.env` database settings:
   ```
   DB_DATABASE=tfelta
   DB_USERNAME=root
   DB_PASSWORD=
   APP_URL=http://tfelta.test
   APP_SAAS=false
   APP_DEMO=false
   ```
5. Install dependencies:
   ```bash
   composer install
   npm install && npm run build
   ```
6. Initialize the database (migrations + essential seeders):
   ```bash
   php artisan app:setup --fresh
   ```
   For an existing database without wiping tables, omit `--fresh`:
   ```bash
   php artisan app:setup
   ```
7. Link storage and clear caches:
   ```bash
   php artisan storage:link
   php artisan optimize:clear
   ```
8. Point Laragon virtual host to `public/` (e.g. `http://tfelta.test`).

### Default Admin Login

After seeding (with `APP_DEMO=false`):

- **Email:** `superadmin@onest.com`
- **Password:** `123456`

Change this password immediately after first login.

## Production Deployment

1. Deploy code from GitHub to the server.
2. Copy `.env.example` to `.env` and set production values (`APP_ENV=production`, `APP_DEBUG=false`, database, mail, etc.).
3. Run:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan key:generate
   php artisan app:setup
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Set web server document root to `public/`.
5. Ensure `storage/` and `bootstrap/cache/` are writable.

**Do not import the bundled SQL dumps.** The schema is created entirely from Laravel migrations.

## Notes

- The web installer at `/install` is bypassed once migrations have run and the `users` table exists.
- Set `APP_DEMO=false` to avoid demo/sample student and staff data during seeding.
- Disabled modules (e.g. `VehicleTracker`) are skipped automatically during setup.
