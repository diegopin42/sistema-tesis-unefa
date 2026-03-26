FROM php:8.2-fpm

WORKDIR /var/www

# 1. Instalamos TODAS las dependencias del sistema de una vez
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libpq-dev \
    libzip-dev \
    libonig-dev \
    zip \
    unzip \
    git \
    curl \
    pkg-config

# 2. Limpiamos caché de apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Instalamos las extensiones una por una o en grupos lógicos
#    Esto ayuda a que Docker gestione mejor las dependencias
RUN docker-php-ext-install pdo_pgsql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl

# 4. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Copiamos el proyecto
COPY . /var/www

# 6. Permisos para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]