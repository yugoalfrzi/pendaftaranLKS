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
RUN mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Run migrations and clear cache at build time
RUN php artisan config:clear \
    && php artisan route:clear

EXPOSE 8080

CMD php -d upload_max_filesize=100M \
        -d post_max_size=105M \
        -d memory_limit=256M \
        -S 0.0.0.0:${PORT:-8080} \
        -t public \
        public/index.php
