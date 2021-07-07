FROM php:7.3-fpm-alpine

RUN apk update && apk upgrade && apk add --no-cache postgresql-dev
RUN docker-php-ext-install pdo_pgsql pgsql sockets
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /app
COPY . /app
RUN composer install
RUN mv .env.example .env
EXPOSE 3030
CMD ["php", "-S", "0.0.0.0:3030", "-t", "public"]
