# syntax=docker/dockerfile:1
# Production-образ приложения: php-fpm + код + vendor. Один образ для web, messenger-worker, chat-ws и migrations.
# Сборка из корня репозитория: docker build -f docker/php/Prod.Dockerfile -t teachers-selector/php .

FROM php:8.3-fpm AS base

RUN apt-get update && apt-get install -y --no-install-recommends \
        librabbitmq-dev libssh-dev libzip-dev libpq-dev \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install amqp openswoole redis \
    && docker-php-ext-enable amqp openswoole redis \
    && docker-php-ext-install zip pdo pdo_pgsql pgsql opcache

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/conf.d/prod-php.ini /usr/local/etc/php/conf.d/prod-php.ini

WORKDIR /var/www/app


FROM base AS vendor

RUN apt-get update && apt-get install -y --no-install-recommends git unzip \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

# PersonalChatBundle подключён path-репозиторием (symlink), поэтому нужен до install
COPY composer.json composer.lock symfony.lock ./
COPY PersonalChatBundle ./PersonalChatBundle
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --prefer-dist

COPY . .
RUN composer dump-autoload --no-dev --classmap-authoritative --no-scripts


FROM base AS app

COPY --from=vendor /var/www/app /var/www/app

# .env нужен Symfony Dotenv; реальные значения приходят из переменных окружения
RUN printf 'APP_ENV=prod\n' > .env \
    && APP_ENV=prod APP_DEBUG=0 APP_SECRET=build \
       DATABASE_URL='postgresql://u:p@localhost:5432/db?serverVersion=14&charset=utf8' \
       MESSENGER_TRANSPORT_DSN='amqp://guest:guest@localhost:5672/%2f/messages' \
       REDIS_URL='redis://localhost:6379' \
       MAILER_DSN='null://null' \
       php bin/console cache:warmup \
    && chown -R www-data:www-data var
