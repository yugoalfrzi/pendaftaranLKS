#!/bin/sh
set -e

# Railway injects PORT, fallback to 8080
APP_PORT=${PORT:-8080}

echo "=== Starting pendaftaranLKS ==="
echo "PORT=$APP_PORT"

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan route:clear

echo "=== Starting PHP server on 0.0.0.0:$APP_PORT ==="

exec php \
    -d upload_max_filesize=100M \
    -d post_max_size=105M \
    -d memory_limit=256M \
    -S 0.0.0.0:$APP_PORT \
    -t public \
    public/index.php
