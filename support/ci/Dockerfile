FROM php:7.2-fpm-alpine

ENV project_dir='/app'

RUN apk update -q && apk upgrade -q \
    && apk add \
        gd \
        libpng \
        curl libcurl \
        ca-certificates \
        libjpeg \
        libpng \
        icu \
    && apk add -q --virtual build-deps \
    build-base \
    icu-dev \
    freetype-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    jpeg-dev \
    gd-dev \
    curl-dev \
    && docker-php-ext-install gd intl pdo_mysql curl \
    && apk del -q build-deps

# apcu
RUN docker-php-source extract \
    && apk add --no-cache --virtual .phpize-deps-configure $PHPIZE_DEPS \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && apk del .phpize-deps-configure \
    && docker-php-source delete

WORKDIR $project_dir/tests/app/web
