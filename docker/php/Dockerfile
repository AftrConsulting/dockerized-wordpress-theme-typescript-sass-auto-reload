FROM wordpress:5.7.2-php8.0-apache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update
RUN apt-get install -y webp libwebp-dev vim
RUN apt-get install -y locales locales-all

RUN usermod -u 1001 www-data && groupmod -g 1001 www-data

EXPOSE 80