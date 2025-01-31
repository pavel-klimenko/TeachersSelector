FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpq-dev

COPY ./docker/unix_socket.conf /usr/local/etc/php-fpm.d/unix_socket.conf


RUN curl -sS https://getcomposer.org/installer | php && \
  mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql

RUN docker-php-ext-install zip \
    pdo \
    pdo_pgsql \
    pgsql

WORKDIR /var/www/app

# Запускаем PHP-FPM
CMD ["php-fpm"]