FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pgsql pdo pdo_pgsql

WORKDIR /app
COPY . .

# 🔥 servidor PHP (sin Apache)
CMD ["php", "-S", "0.0.0.0:8080"]
