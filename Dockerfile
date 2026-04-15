FROM php:8.2-apache

# 🔥 Instalar dependencias necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql

# Copiar proyecto
COPY . /var/www/html/
