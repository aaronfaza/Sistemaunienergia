# Usa una imagen oficial con PHP y Apache
FROM php:8.2-apache

# Instala extensiones necesarias para Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    libzip-dev unzip libpq-dev git curl libonig-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip

# Habilita mod_rewrite para Laravel routing
RUN a2enmod rewrite

# Define tu carpeta de trabajo (donde vive Laravel)
WORKDIR /app

# Copia todos los archivos del proyecto al contenedor
COPY . /app

# Asigna permisos correctos
RUN chown -R www-data:www-data /app \
    && chmod -R 755 /app

# Configura Apache para servir el contenido desde /app/public
RUN cat <<EOF > /etc/apache2/sites-available/000-default.conf
<VirtualHost *:80>
    DocumentRoot /app/public
    <Directory /app/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
EOF





# Añade esto si usas postgres
RUN docker-php-ext-install pdo_pgsql

