FROM php:cli-buster AS build
WORKDIR /app
COPY . /app
COPY docker/php/conf.d/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY --from=composer:lts /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get install libldap2-dev zip -y && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install ldap

RUN composer install --prefer-dist --no-dev --optimize-autoloader

FROM node:18-alpine AS frontend-build
WORKDIR /app
COPY --from=build /app /app
RUN npm install && \
    npm run build

FROM php:apache-buster AS production

ENV APP_ENV=production
ENV APP_DEBUG=false


RUN docker-php-ext-configure opcache --enable-opcache && \
    docker-php-ext-install pdo pdo_mysql

COPY --from=frontend-build /app /var/www/html
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY .env.prod /var/www/html/.env

RUN ls -al /var/www/html && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    touch /var/www/html/database/database.sqlite && \
#    php artisan migrate && \
    chmod 777 -R /var/www/html/storage && \
    chown -R www-data:www-data /var/www/html/storage &&\
    a2enmod rewrite
