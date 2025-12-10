FROM php:8.2-apache

# nainštaluje PDO a PDO MySQL driver
RUN docker-php-ext-install pdo pdo_mysql

# povolenie mod_rewrite
RUN a2enmod rewrite
