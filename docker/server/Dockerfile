FROM php:8.1-apache

RUN apt-get update && apt-get install -y vim curl qrencode zbar-tools libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*

RUN printf "\n" | pecl install imagick \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install bcmath

COPY ./default.conf /etc/apache2/sites-available/000-default.conf

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Enable apache modules !!!IMPORTANT!!!
RUN a2enmod rewrite headers

COPY ./ /var/www/html/

