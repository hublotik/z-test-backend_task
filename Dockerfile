FROM php:8.1-fpm

RUN apt-get update -y \
    && apt-get install -y nginx

ARG BUILD_ENV

ENV COMPOSER_VERSION=v2

RUN apt-get update --fix-missing
RUN apt-get install -y supervisor
RUN apt-get update --fix-missing
#COPY supervisor-queue.conf /etc/supervisor/conf.d/queue.conf

RUN apt-get install -y --no-install-recommends git zip wget unzip libzip-dev ssh libc-client-dev libkrb5-dev
RUN docker-php-source extract
#RUN docker-php-ext-configure imap --with-kerberos --with-imap-ssl
RUN apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
RUN docker-php-ext-configure gd
RUN docker-php-ext-install -j$(nproc) gd pdo_mysql
RUN docker-php-source delete
RUN pecl install zip

RUN docker-php-ext-enable zip
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install opcache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY --chown=www-data:www-data . /var/www/html

COPY entrypoint.sh /etc/entrypoint.sh
RUN chmod +x /etc/entrypoint.sh

WORKDIR /var/www/html

RUN mkdir -p /var/www/html/storage/logs \
        && mkdir -p /var/www/html/storage/framework/cache \
        && chmod -R 777 /var/www/html/storage/framework/cache \
        && chmod -R 777 /var/www/html/storage/logs
        
RUN COMPOSER_ALLOW_SUPERUSER=1 COMPOSER_MEMORY_LIMIT=-1 composer install

EXPOSE 80

COPY nginx.conf /etc/nginx/sites-available/default
COPY nginx.conf /etc/nginx/sites-enabled/default

#COPY php-uploads.ini /usr/local/etc/php/conf.d/uploads.ini
#COPY php-opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY php.ini /usr/local/etc/php/conf.d/php.ini

#COPY supervisor-queue.conf /etc/supervisor/conf.d/queue.conf

ENTRYPOINT ["/etc/entrypoint.sh"]

#CMD set -e && php-fpm -D && nginx -g 'daemon off;'
