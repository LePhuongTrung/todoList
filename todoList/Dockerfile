FROM php:8.2-fpm

WORKDIR /todoList

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql mysqli

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /todoList

RUN composer install --no-interaction --prefer-dist

COPY .env.ci .env

RUN php vendor/bin/phinx migrate

EXPOSE 9000

CMD ["php-fpm"]
