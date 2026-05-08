FROM php:8.2-fpm

# Install semua system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    gd \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    zip \
    xml \
    dom

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file project
COPY . /var/www/html

# Hapus vendor folder yang mungkin corrupt
RUN rm -rf vendor

# Install dependencies
RUN composer install --ignore-platform-req=ext-gd --ignore-platform-req=ext-zip --no-interaction --optimize-autoloader

# Generate APP_KEY jika belum ada
RUN php artisan key:generate --force || true

# **INI YANG PENTING: Cache semua konfigurasi**
RUN php artisan config:clear
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# Set permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 8000

# **GANTI: Gunakan perintah yang benar untuk membaca env**
CMD sh -c "php artisan config:clear && php artisan config:cache && php artisan serve --host=0.0.0.0 --port=8000"