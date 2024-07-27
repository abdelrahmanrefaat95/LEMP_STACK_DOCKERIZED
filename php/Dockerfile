FROM php:8.0-fpm-alpine
#... Your other instructions

# Create the www-data user and group (same UID and GID as in the Nginx container)

# Install necessary extensions (adjust to your needs)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy your PHP code
COPY src/ /var/www/html

