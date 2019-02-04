FROM python:3.7-alpine

RUN mkdir -p /var/www/code

WORKDIR /var/www/code

# Installing packages necessary for Scrapy
RUN apk update && \
    apk upgrade && \
    apk add --no-cache \
    gcc \
    linux-headers \
    musl-dev \
    libffi-dev \
    libxml2-dev \
    libxslt-dev \
    openssl-dev \
    python3-dev \
    jpeg-dev \
    zlib-dev \
    python3

# Installing Scrapy
RUN pip3 install --upgrade pip && \
    pip3 install Pillow && \
    pip3 install scrapy

# Installing php
RUN apk add php7 \
    php7-opcache \
    php7-mbstring

WORKDIR /var/www/code/src

# TODO add php artisan queue:work
CMD ["php", "artisan", "queue:work"]