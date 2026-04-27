#!/usr/bin/env bash
# DigitalOcean App Platform: single web container (SQLite) — same filesystem for HTTP and scheduler.
set -euo pipefail
cd "${APP_PATH:-$PWD}" || exit 1

mkdir -p database storage/database storage/framework/cache storage/framework/sessions storage/framework/views

php artisan migrate --force
php artisan db:seed --force

php artisan schedule:work &

exec heroku-php-apache2 public/
