# Laravel Product Dashboard

This directory contains the key source files required to fulfil the Product CRUD + Sync assignment. To run it end-to-end, scaffold a fresh Laravel installation and drop these files in place (overwriting the generated stubs where applicable).

## Quick start

1. Install Laravel (11.x recommended):
   ```bash
   composer create-project laravel/laravel product-dashboard
   cd product-dashboard
   ```
2. Copy the files from this `laravel-app` folder into the corresponding locations of the generated project. Respect the same folder hierarchy (`app/Models`, `routes/web.php`, etc.).
3. Install dependencies and build the frontend assets (uses Bootstrap via CDN, so Vite build is optional).
4. Configure your `.env` with a database connection and run the migrations:
   ```bash
   php artisan migrate
   ```
5. (Optional) Seed demo data:
   ```bash
   php artisan db:seed --class=ProductSeeder
   ```
6. Serve the application:
   ```bash
   php artisan serve
   ```
7. Visit `http://127.0.0.1:8000` to manage products and sync from Fake Store.

## Features

- Product CRUD with validation and pagination.
- Fake Store API integration via a dedicated service class and a one-click “Sync Products” button.
- JSON API endpoint at `GET /api/products` returning a paginated list using a resource transformer.
- Bootstrap-powered dashboard with responsive layout and actionable feedback.

## Deployment tips

- For Render/Railway: push the full Laravel project to GitHub, create a new web service, set the build command to `composer install --no-dev` (or `composer install` for demos) and `php artisan migrate --force`, and set the start command to `php artisan serve --host 0.0.0.0 --port $PORT`.
- Remember to set your `APP_KEY`, `APP_ENV`, and database credentials (e.g., PostgreSQL add-on) in the platform environment variables.
- Export your database using `php artisan db:export` helpers or native tools (`pg_dump`, `mysqldump`) and include the SQL file alongside the code deliverable if required.
