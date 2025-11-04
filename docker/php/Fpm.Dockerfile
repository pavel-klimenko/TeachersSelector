FROM php:8.3-fpm

RUN apt-get update && apt-get install -y lsof librabbitmq-dev libssh-dev libzip-dev libpq-dev && pecl install amqp && docker-php-ext-enable amqp

RUN curl -sS https://getcomposer.org/installer | php && \
  mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install zip \
    pdo \
    pdo_pgsql \
    pgsql

#RUN pecl install xdebug && docker-php-ext-enable xdebug && docker-php-ext-enable amqp

RUN pecl install openswoole && docker-php-ext-enable openswoole

WORKDIR /var/www/app