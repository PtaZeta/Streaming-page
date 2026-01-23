FROM php:8.4-cli

# Dependencias sistema
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpq-dev curl \
    && docker-php-ext-install \
        zip \
        pdo \
        pdo_pgsql

# Node.js (para Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# Laravel deps
RUN composer install --no-dev --optimize-autoloader

# Vite build
RUN npm install
RUN npm run build

# Puerto Railway
EXPOSE 8080
CMD php artisan serve --host=0.0.0.0 --port=8080
