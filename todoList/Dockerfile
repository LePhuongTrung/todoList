FROM php:8.2-fpm

WORKDIR /todoList

COPY . /todoList

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql mysqli

EXPOSE 9000

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# RUN composer install

CMD ["php-fpm"]
