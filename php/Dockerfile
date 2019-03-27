# prestage build used for handling composer
FROM composer:1.7 as vendor

COPY composer.json composer.json
COPY composer.lock composer.lock

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist

# main build stage
FROM richarvey/nginx-php-fpm
RUN rm /var/www/html/index.php

# copy vendor into the project from the prebuild stage
RUN mkdir /var/www/vendor
COPY --from=vendor /app/vendor/ /var/www/vendor/


#COPY necasary PHP files
RUN mkdir /var/www/php
COPY Classes /var/www/php/Classes
COPY lib /var/www/php/lib
COPY public_html /var/www/html

# configure Secrets for protected information
RUN mkdir /var/www/secrets
COPY secrets/. /var/www/secrets
RUN touch /var/www/secrets/ng-templating.ini && php /var/www/secrets/ng-templating.php


EXPOSE 80


