# Use an official PHP image based on Debian
FROM php:5.6.34-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install additional PHP extensions if necessary
RUN docker-php-ext-install mysqli

# Copy the PHP application files to the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Expose port 80 to access the web server
EXPOSE 80
