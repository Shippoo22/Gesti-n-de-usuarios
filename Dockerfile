FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pgsql pdo pdo_pgsql

# 🔥 SOLUCIÓN AL ERROR MPM
RUN a2dismod mpm_event && a2enmod mpm_prefork

# (opcional pero recomendado)
RUN a2enmod rewrite

COPY . /var/www/html/

EXPOSE 80
