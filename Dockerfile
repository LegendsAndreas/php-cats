FROM php:8.2-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y \
        libsqlite3-dev \
        libicu-dev \
        unzip \
        git \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo pdo_mysql mysqli pdo_sqlite intl \
    && rm -rf /var/lib/apt/lists/*

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Copy CakePHP application to the container
COPY . /var/www/html

# Set permissions for the application
RUN mkdir -p tmp
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 777 tmp/

# Set the working directory
WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer install

EXPOSE 80