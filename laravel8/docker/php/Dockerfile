FROM php:8.5-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

CMD ["php-fpm"]
