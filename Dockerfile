FROM php:8.4-cli

RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libicu-dev libzip-dev libpq-dev \
    nodejs npm \
    && docker-php-ext-install pdo pdo_pgsql intl zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

COPY . .

COPY docker/php/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

ENV APP_ENV=prod
ENV APP_DEBUG=0
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction

RUN npm install && npm run build

CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]
