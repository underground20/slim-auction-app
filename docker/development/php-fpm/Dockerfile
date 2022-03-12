FROM php:8.1-fpm-alpine

RUN apk update && apk add autoconf g++ make \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN apk add libpq-dev \
    && docker-php-ext-configure pgsql --with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY conf.d /usr/local/etc/php/conf.d

WORKDIR /app

COPY entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint
