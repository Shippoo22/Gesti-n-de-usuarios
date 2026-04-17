FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pgsql pdo pdo_pgsql

# 💣 ELIMINAR TODOS LOS MPM (esto es la clave)
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load

# ✅ ACTIVAR SOLO UNO
RUN a2enmod mpm_prefork

# opcional
RUN a2enmod rewrite

COPY . /var/www/html/

EXPOSE 80
