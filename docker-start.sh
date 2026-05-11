#!/bin/sh
set -e

echo "=== Starting pendaftaranLKS ==="
echo "PORT=$PORT"

# Run migrations
php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan route:clear

echo "=== Starting PHP server on 0.0.0.0:$PORT ==="

exec php \
    -d upload_max_filesize=100M \
    -d post_max_size=105M \
    -d memory_limit=256M \
    -S 0.0.0.0:$PORT \
    -t public \
    public/index.php
