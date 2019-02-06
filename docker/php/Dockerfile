FROM php:7.3.1-fpm-alpine

#RUN apk add php7-pdo_mysql
RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www/code/