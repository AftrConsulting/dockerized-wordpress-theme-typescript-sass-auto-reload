#!/bin/bash

sh start.sh

docker-compose run node sh -c "\
    npm install; \
    npm run build;"