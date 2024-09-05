FROM php:8.2-fpm
ARG COMPOSER_VER
ENV COMPOSER_VER ${COMPOSER_VER:-2.2.9}
USER $USER

WORKDIR /var/www/html
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash
RUN apt-get -y install nodejs \
    git \
    unzip

RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        libxml2-dev \
        libpq-dev\
        curl

RUN docker-php-ext-install \
        soap \
        zip \
        bcmath \
        exif \
        gd \
        iconv \
        intl \
        opcache \
        pdo_mysql \
        sockets \
        pgsql \
        pdo_pgsql

RUN pecl install xdebug \
   && docker-php-ext-enable xdebug
RUN pecl install mongodb apcu libmongoc && docker-php-ext-enable mongodb apcu opcache

COPY --from=composer:latest  /usr/bin/composer /usr/bin/composer

ARG EXTERNAL_IP

COPY xdebug.ini $PHP_INI_DIR/conf.d/
USER $USER