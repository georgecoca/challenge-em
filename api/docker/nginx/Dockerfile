FROM nginx

COPY edumaster.conf /etc/nginx/conf.d/default.conf

ADD certs/cert.pem /etc/nginx/ssl-certs/cert.pem
ADD certs/key.pem /etc/nginx/ssl-certs/key.pem

ARG PHP_UPSTREAM_CONTAINER=php-fpm
ARG PHP_UPSTREAM_PORT=9000

# Set upstream conf and remove the default conf
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf

CMD ["nginx", "-g", "daemon off;"]

EXPOSE 80 443