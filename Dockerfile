FROM php:8.0-apache

# Copy the application code to the container
COPY . /var/www/html/

# Install and enable the mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Update and upgrade the package lists
RUN apt-get update && apt-get upgrade -y

# Ensure the web server user owns the files
RUN chown -R www-data:www-data /var/www/html

# Copy php.ini to the appropriate directory
COPY php.ini /usr/local/etc/php/

# Copy the entrypoint script
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Set the entrypoint
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Set the default command
CMD ["apache2-foreground"]