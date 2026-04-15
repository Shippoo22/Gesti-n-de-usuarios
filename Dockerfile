FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql

# 🔥 SOLO desactivar event (NO activar prefork otra vez)
RUN a2dismod mpm_event || true

# Copiar proyecto
COPY . /var/www/html/
