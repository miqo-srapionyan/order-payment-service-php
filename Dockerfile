# Use official PHP 8.3 image with Apache
FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libicu-dev zlib1g-dev libzip-dev libonig-dev libxml2-dev

# Enable mod_rewrite for RESTful routes
RUN a2enmod rewrite

RUN echo "ServerName localhost" > /etc/apache2/conf-available/servername.conf \
 && a2enconf servername

# Copy custom Apache configuration file
COPY ./infrastructure/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

# Install dependencies
RUN composer install

# Expose port 80 for HTTP
EXPOSE 80
