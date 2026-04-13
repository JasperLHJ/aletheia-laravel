#!/bin/sh
set -e
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

if [ "${DB_CONNECTION:-}" = "sqlite" ]; then
    dbpath="${DB_DATABASE:-database/database.sqlite}"
    case "$dbpath" in
        /*) ;;
        *) dbpath="/var/www/html/$dbpath" ;;
    esac
    if [ ! -f "$dbpath" ]; then
        install -d -o www-data -g www-data "$(dirname "$dbpath")"
        touch "$dbpath"
        chown www-data:www-data "$dbpath"
        chmod 664 "$dbpath"
    fi
fi

if [ -n "${APP_KEY:-}" ]; then
    php artisan package:discover --ansi 2>/dev/null || true
    php artisan config:cache 2>/dev/null || true
    php artisan route:cache 2>/dev/null || true
    php artisan view:cache 2>/dev/null || true
    php artisan migrate --force 2>/dev/null || true
    chown -R www-data:www-data /var/www/html/bootstrap/cache
fi

exec "$@"
