# Production-образ nginx: конфиг + статика из public/. Сборка из корня репозитория.
FROM nginx:1.27-alpine

COPY docker/nginx/prod.conf /etc/nginx/conf.d/default.conf
COPY public /var/www/app/public
