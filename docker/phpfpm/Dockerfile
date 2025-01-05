FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
    zip \
    libzip-dev \
    coreutils \
    freetype-dev \
    libjpeg-turbo-dev \
    libjpeg-turbo \
    libpng-dev \
    libzip-dev \
    jpeg-dev \
    icu-dev \
    libgcrypt-dev \
    oniguruma-dev


RUN #docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install -j$(nproc) \
    pdo_mysql
#    zip \
#    intl \
#    gd \
#    opcache \
#    mbstring
#    curl \
#    iconv

RUN #docker-php-ext-enable intl
RUN #docker-php-ext-enable pdo_mysql

RUN rm -rf /tmp/*

WORKDIR /var/www
EXPOSE 9000
