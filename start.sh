#!/bin/bash

docker-compose up --build -d

docker-compose run wordpress sh -c "\
    cd wp-content/themes/theme
    composer install;
    chown -R www-data:www-data /var/www/html/wp-content"