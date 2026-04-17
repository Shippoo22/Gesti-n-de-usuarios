FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pgsql pdo pdo_pgsql

# 🔥 FORZAR SOLO UN MPM (QUITAR TODOS Y DEJAR PREFORK)
RUN a2dismod mpm_event || true
RUN a2dismod mpm_worker || true
RUN a2enmod mpm_prefork
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load
RUN a2enmod mpm_prefork
RUN a2enmod rewrite

COPY . /var/www/html/

EXPOSE 80
