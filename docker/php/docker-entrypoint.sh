#!/bin/sh
set -e
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

if [ "$1" = "php-fpm" ] || [ "$1" = "php-fpm8.3" ]; then
    if [ -n "${APP_KEY:-}" ]; then
        php artisan package:discover --ansi 2>/dev/null || true
        php artisan config:cache 2>/dev/null || true
        php artisan route:cache 2>/dev/null || true
        php artisan view:cache 2>/dev/null || true
        chown -R www-data:www-data /var/www/html/bootstrap/cache
    fi
fi

exec docker-php-entrypoint "$@"
