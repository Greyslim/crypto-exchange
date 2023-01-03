FROM php:8-cli

RUN apt-get update && apt-get install -y curl git zip npm net-tools

#RUN docker-php-ext-install pdo mysqli pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer create-project laravel/laravel example-app 9.0