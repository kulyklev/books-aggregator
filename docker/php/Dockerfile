FROM php:7.3.2-fpm

RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install bcmath sockets

WORKDIR /var/www/code/