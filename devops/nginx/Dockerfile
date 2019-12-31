FROM nginx:1.17.5 as base
COPY nginx-site.conf /etc/nginx/conf.d/default.conf
COPY nginx.conf /etc/nginx/nginx.conf


FROM base as dev


FROM base as prod
COPY ./../../src /var/www/code