FROM nginx:1.17.5 as base
COPY nginx.conf /etc/nginx/conf.d/default.conf

FROM base as dev

FROM base as prod
COPY ./../../src /var/www/code