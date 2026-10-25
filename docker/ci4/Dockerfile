FROM php:8.5.11-fpm-alpine

RUN apk add --no-cache \
    icu-dev \
    libzip-dev \
    unzip \
    git

RUN docker-php-ext-install \
    intl \
    mysqli \
    pdo_mysql \
    zip

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Source code is bind-mounted by docker-compose
CMD ["php-fpm"]