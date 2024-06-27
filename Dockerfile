# Usa una imagen base oficial de PHP con Apache
FROM php:8.2-apache

# Instala las extensiones de PHP necesarias para Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copia el contenido de tu aplicación Laravel al contenedor
COPY . /var/www/html

# Establece los permisos adecuados
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el archivo de configuración de Apache para Laravel
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo de reescritura de Apache
RUN a2enmod rewrite

