#!/bin/sh
set -e

APP_PORT=${PORT:-8080}

echo "=== Starting pendaftaranLKS ==="
echo "PORT=$APP_PORT"

# Run Laravel setup
php artisan migrate --force
php artisan config:clear
php artisan route:clear

# Update Apache to listen on correct port
sed -i "s/Listen 80/Listen $APP_PORT/" /etc/apache2/ports.conf
sed -i "s/*:80>/*:$APP_PORT>/" /etc/apache2/sites-available/000-default.conf

echo "=== Starting Apache on port $APP_PORT ==="
exec apache2-foreground
