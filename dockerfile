FROM php:8.0-apache

COPY . /var/www/xastre_final

RUN docker-php-ext-install mysqli