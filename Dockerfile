FROM php:8.0-apache

COPY . /var/www/html/

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN apt-get update && apt-get upgrade -y

# Set the correct permissions
RUN chmod -R 775 /var/www/html/image

# Ensure the web server user owns the image directory
RUN chown -R www-data:www-data /var/www/html/image

COPY php.ini /usr/local/etc/php/