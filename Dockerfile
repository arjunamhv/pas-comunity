ARG PHP_VERSION=8.3

ARG FRANKENPHP_VERSION=latest

FROM dunglas/frankenphp:${FRANKENPHP_VERSION}-php${PHP_VERSION}

RUN install-php-extensions pcntl

RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev libonig-dev libxml2-dev nodejs npm libzip-dev \
    && docker-php-ext-install pdo_mysql gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /app

WORKDIR /app

RUN composer install --no-dev --optimize-autoloader && \
    php artisan config:cache && \
    php artisan route:cache

# tailwind
RUN npm install && npm run build

RUN cp .env.example .env

RUN php artisan key:generate

ENTRYPOINT ["php", "/app/artisan", "octane:frankenphp"]
