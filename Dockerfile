FROM php:8.2-apache

# 🔥 Instalar PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql

# 🔥 FIX Apache (evitar error MPM)
RUN a2dismod mpm_event && a2enmod mpm_prefork

# Copiar proyecto
COPY . /var/www/html/
