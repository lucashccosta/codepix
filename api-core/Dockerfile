FROM php:7.3-fpm-alpine

RUN apk update && apk upgrade  
RUN docker-php-ext-install sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
RUN composer install
EXPOSE 3040
CMD ["php", "index.php"]
