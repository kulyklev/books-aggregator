FROM python:3.7-alpine

RUN mkdir -p /var/www/code

WORKDIR /var/www/code

RUN apk update && \
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
    zlib-dev\
    python3

RUN pip3 install --upgrade pip
RUN pip3 install Pillow
RUN pip3 install scrapy