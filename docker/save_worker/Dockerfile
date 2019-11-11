FROM php:7.3.11-fpm

RUN docker-php-ext-install pdo_mysql && \
    docker-php-ext-install bcmath sockets

WORKDIR /var/www/html/

CMD ["php", "artisan", "rabbitmq:save_books"]