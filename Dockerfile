FROM php:8.3-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libxml2-dev libzip-dev libonig-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring xml zip gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first for layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Copy rest of application
COPY . .

# Run post-install scripts
RUN composer run-script post-autoload-dump || true

# Set permissions
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache \
    storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Create startup script
RUN echo '#!/bin/sh' > /app/start.sh \
    && echo 'php artisan migrate --force' >> /app/start.sh \
    && echo 'php artisan config:clear' >> /app/start.sh \
    && echo 'php artisan route:clear' >> /app/start.sh \
    && echo 'echo "Starting PHP server on port $PORT"' >> /app/start.sh \
    && echo 'exec php -d upload_max_filesize=100M -d post_max_size=105M -d memory_limit=256M -S 0.0.0.0:${PORT} -t public public/index.php' >> /app/start.sh \
    && chmod +x /app/start.sh

EXPOSE 8080

CMD ["/bin/sh", "/app/start.sh"]
