# Stage 1 — PHP dependencies
FROM composer:2.6 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist --no-scripts


# Stage 2 — Node/Vite build
FROM node:20-alpine AS build
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 3 — Final PHP runtime
FROM php:8.2-fpm

# Install required PHP extensions
# For Debian-based PHP image
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libzip-dev libonig-dev \
    && docker-php-ext-install pdo_mysql bcmath gd \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy Composer dependencies from vendor stage
COPY --from=vendor /app/vendor ./vendor

# Copy built frontend assets from build stage
COPY --from=build /app/public ./public

# Copy app source code (without node_modules)
COPY . .

# Correct permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000

CMD ["php-fpm"]

