# Stage 1: Build stage (install composer dependencies)
FROM php:8.2-fpm-alpine AS build

# Install system dependencies
RUN apk add --no-cache \
    git \
    unzip \
    libzip-dev \
    oniguruma-dev

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip

# Copy the application
WORKDIR /var/www/html
COPY . .

# Install Composer manually (no composer images)
RUN wget https://getcomposer.org/download/latest-stable/composer.phar -O /usr/bin/composer \
    && chmod +x /usr/bin/composer

# Install dependencies (no dev)
RUN composer install --no-dev --optimize-autoloader


# Stage 2: Production image (clean, light)
FROM php:8.2-fpm-alpine

# Install production dependencies only
RUN apk add --no-cache \
    libzip \
    oniguruma

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip

WORKDIR /var/www/html

# Copy app from build stage
COPY --from=build /var/www/html /var/www/html

# Give permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Run PHP-FPM
CMD ["php-fpm"]
