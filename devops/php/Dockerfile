FROM php:7.3.11-fpm as base

RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install bcmath sockets


FROM base as dev
RUN apt-get update && apt-get install -y wget git unzip \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/html/


FROM base as prod
COPY ./../../src /var/www/html/

#RUN php artisan vendor:publish --provider="Code16\Sharp\SharpServiceProvider" --tag=assets