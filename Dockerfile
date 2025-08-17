# Dockerfile (di root project)
FROM php:8.2-apache

# Deps untuk build ekstensi
RUN set -eux; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
        libicu-dev \
        libzip-dev \
        zlib1g-dev \
        libonig-dev \
        unzip git \
        $PHPIZE_DEPS; \
    docker-php-ext-configure intl; \
    docker-php-ext-install -j"$(nproc)" intl pdo_mysql mysqli mbstring zip; \
    a2enmod rewrite headers; \
    sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
        /etc/apache2/sites-available/*.conf /etc/apache2/apache2.conf; \
    sed -ri -e 's!<Directory /var/www/>!<Directory /var/www/html/public/>!g' \
        /etc/apache2/apache2.conf; \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html
