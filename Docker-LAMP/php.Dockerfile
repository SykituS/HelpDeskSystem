FROM php:8.1.18-apache-buster
RUN docker-php-ext-install mysqli pdo pdo_mysql