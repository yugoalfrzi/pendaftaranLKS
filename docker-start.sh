#!/bin/sh
set -e

APP_PORT=${PORT:-8080}

echo "=== Starting pendaftaranLKS on port $APP_PORT ==="

php artisan migrate --force
php artisan config:clear
php artisan route:clear

exec php \
    -d upload_max_filesize=100M \
    -d post_max_size=105M \
    -d memory_limit=256M \
    -S 0.0.0.0:$APP_PORT \
    /app/server.php
