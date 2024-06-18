#!/bin/bash
set -e

# Change ownership and permissions of the /var/www/html/image directory
chown -R www-data:www-data /var/www/html/image
chmod -R 775 /var/www/html/image

# Execute the CMD
exec "$@"
