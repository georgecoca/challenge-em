FROM php:8.4-fpm

# Update
RUN apt-get update && apt-get install -y --no-install-recommends

# Install Zip Archive (required by composer)
RUN apt-get install -y libzip-dev zip && \
    docker-php-ext-install zip

# Install Laravel Dependencies
RUN docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install pcntl

# Install Dependencies for Redis
RUN pecl install redis && rm -rf /tmp/pear && docker-php-ext-enable redis

# Tweak PHP
COPY "memory-limit-php.ini" "/usr/local/etc/php/conf.d/memory-limit-php.ini"

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

RUN usermod -u 1000 www-data

CMD ["php-fpm"]

EXPOSE 9000