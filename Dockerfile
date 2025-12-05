FROM php:8.0-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable mod_rewrite (optional but good practice)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Set permissions for upload directories
RUN chown -R www-data:www-data /var/www/html/archivos /var/www/html/subir \
    && chmod -R 755 /var/www/html/archivos /var/www/html/subir

EXPOSE 80
