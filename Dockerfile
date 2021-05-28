FROM php:7.4-fpm
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/www

RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www
COPY .env /var/www

COPY --chown=www:www . /var/www
USER www

RUN composer install --no-scripts --no-suggest --optimize-autoloader

EXPOSE 9000
CMD ["php-fpm"]
