FROM php:8.4-fpm

# system deps
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    curl \
    && docker-php-ext-install intl pdo pdo_pgsql zip opcache

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# install deps WITHOUT scripts (safe build)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# run Symfony manually
RUN php bin/console cache:clear --env=prod
RUN php bin/console cache:warmup --env=prod

RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
