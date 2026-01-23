FROM php:8.4-cli

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip zip libzip-dev libpq-dev \
    && docker-php-ext-install \
        zip \
        pdo \
        pdo_pgsql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /app

# Copiar proyecto
COPY . .

# Instalar dependencias Laravel
RUN composer install --no-dev --optimize-autoloader

# Puerto para Railway
EXPOSE 8080

# Arranque
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
