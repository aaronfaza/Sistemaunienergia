# Usa una imagen oficial con PHP y Apache
FROM php:8.2-apache


# Instala GD con soporte para PNG y JPEG
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libwebp-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd


# Instala extensiones necesarias para Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpq-dev git curl libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Habilita mod_rewrite para Laravel routing
RUN a2enmod rewrite

# Instala Composer desde la imagen oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define carpeta de trabajo
WORKDIR /app

# Copia los archivos del proyecto
COPY . /app

# Instala dependencias Laravel (genera vendor/autoload.php)
RUN composer install --no-dev --optimize-autoloader

# Asigna permisos correctos
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app

# Configura Apache para servir Laravel desde /public
RUN printf '%s\n' \
    '<VirtualHost *:80>' \
    '    DocumentRoot /app/public' \
    '    <Directory /app/public>' \
    '        AllowOverride All' \
    '        Require all granted' \
    '    </Directory>' \
    '</VirtualHost>' \
    > /etc/apache2/sites-available/000-default.conf

RUN docker-php-ext-install pdo pdo_pgsql
