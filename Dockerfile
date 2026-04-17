FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pgsql pdo pdo_pgsql

COPY . /var/www/html/
