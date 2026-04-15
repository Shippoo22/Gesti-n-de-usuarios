FROM php:8.2-apache

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql

# 🔥 LIMPIAR TODOS LOS MPM Y DEJAR SOLO UNO
RUN a2dismod mpm_event || true \
 && a2dismod mpm_worker || true \
 && a2enmod mpm_prefork

# Copiar proyecto
COPY . /var/www/html/
