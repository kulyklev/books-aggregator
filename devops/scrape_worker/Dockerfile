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

#RUN pip3 install --upgrade pip && \
#    pip3 install pipenv && \
#    pipenv install --dev --deploy --ignore-pipfile --python 3.7

# Installing Scrapy
RUN pip3 install --upgrade pip && \
    pip3 install Pillow && \
    pip3 install scrapy && \
    pip3 install pika

# Installing python-dotenv package to work with .env file
RUN pip3 install -U python-dotenv

# Installing php
RUN apk add php7 \
    php7-opcache \
    php7-mbstring \
    php7-pdo_mysql \
    php7-session \
    php7-json

WORKDIR /var/www/code/src

CMD ["php", "artisan", "queue:work", "database"]