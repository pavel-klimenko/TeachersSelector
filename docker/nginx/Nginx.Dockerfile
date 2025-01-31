FROM nginx:latest

ADD ./docker/nginx/host.conf /etc/nginx/conf.d/default.conf

WORKDIR /var/www/app

#для соединения по unix socket
CMD ["nginx", "-g", "daemon off;"]