FROM php:7.3.11-fpm as base

RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install bcmath sockets

WORKDIR /var/www/html/

CMD ["php", "artisan", "rabbitmq:save_books"]

FROM base as dev
#TODO Maybe add xDebug

FROM base as prod
COPY ./../../src /var/www/html/