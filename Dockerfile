FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update

RUN apt-get install -y libsqlite3-dev

RUN apt-get install -y libicu-dev \
    && docker-php-ext-configure intl

RUN docker-php-ext-install pdo pdo_mysql mysqli pdo_sqlite intl

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Copy CakePHP application to the container
COPY . /var/www/html

# Set permissions for the application
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 tmp/

# Set the working directory
WORKDIR /var/www/html

EXPOSE 80