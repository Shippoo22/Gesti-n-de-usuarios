FROM php:8.2-cli

# Instalar PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql

# Copiar proyecto
COPY . /app

WORKDIR /app

# 🔥 Servidor PHP (sin Apache)
CMD php -S 0.0.0.0:$PORT
