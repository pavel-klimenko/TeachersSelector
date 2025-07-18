FROM php:8.3-fpm

RUN apt-get update && apt-get install -y librabbitmq-dev libssh-dev libzip-dev libpq-dev && pecl install amqp && docker-php-ext-enable amqp

#RUN apt-get update && apt-get install -y \
#    libzip-dev \
#    libpq-dev

RUN curl -sS https://getcomposer.org/installer | php && \
  mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install zip \
    pdo \
    pdo_pgsql \
    pgsql

#RUN pecl install xdebug && docker-php-ext-enable xdebug && docker-php-ext-enable amqp

WORKDIR /var/www/app