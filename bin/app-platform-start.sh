#!/usr/bin/env bash
# DigitalOcean App Platform: single web container (SQLite) — same filesystem for HTTP and scheduler.
set -euo pipefail
cd "${APP_PATH:-$PWD}" || exit 1

mkdir -p \
  database \
  storage/database \
  storage/framework/cache \
  storage/framework/sessions \
  storage/framework/views \
  storage/logs \
  bootstrap/cache

# Writable cache, logs, and SQLite parent dirs (PaaS user must be able to write).
chmod -R ug+rwX storage bootstrap/cache database 2>/dev/null || true

if [ ! -f public/build/manifest.json ]; then
  echo "FATAL: public/build/manifest.json missing. The build step must run npm run build and commit the output, or the build failed." >&2
  exit 1
fi

php artisan migrate --force
php artisan db:seed --force

php artisan schedule:work &

exec heroku-php-apache2 public/
