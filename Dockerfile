# Imagen oficial de PHP 8.4 con Composer
FROM php:8.4-cli

# Instala Composer manualmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instalamos extensiones necesarias para Laravel
RUN apt-get update && apt-get install -y \
    unzip git libzip-dev zip \
    && docker-php-ext-install zip pdo pdo_mysql

# Directorio de trabajo
WORKDIR /app

# Copiamos el proyecto
COPY . /app

# Instalamos dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Exponemos puerto para Railway
EXPOSE 8000

# Comando para iniciar Laravel con puerto dinámico
CMD php artisan serve --host=0.0.0.0 --port=$PORT
