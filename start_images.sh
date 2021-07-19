#!/bin/bash

docker-compose run wordpress sh -c "\
    sh /var/www/html/wp-content/transform-images.sh"