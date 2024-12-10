ARG PHP_VERSION=8.3

ARG FRANKENPHP_VERSION=latest

FROM dunglas/frankenphp:${FRANKENPHP_VERSION}-php${PHP_VERSION}

RUN install-php-extensions pcntl

RUN apt-get update && apt-get install -y \
    nodejs npm \
    && docker-php-ext-install pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /app

WORKDIR /app

RUN composer install --no-dev --optimize-autoloader && \
    php artisan config:cache && \
    php artisan route:cache

RUN npm install && npm run build

ENTRYPOINT ["php", "artisan", "octane:frankenphp"]
