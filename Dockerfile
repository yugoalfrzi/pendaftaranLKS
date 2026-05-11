FROM php:8.3-cli

# Install system dependencies + gd dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    libxml2-dev libzip-dev libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
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
    && chmod -R 777 storage bootstrap/cache

# Create startup script
COPY docker-start.sh /app/start.sh
RUN chmod +x /app/start.sh

EXPOSE 8080

CMD ["/bin/sh", "/app/start.sh"]
