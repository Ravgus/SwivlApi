#!/bin/bash

docker-compose up -d --build

docker exec -it swivl_php composer install

docker exec -it swivl_php sh -c "php bin/console d:d:d --force;
                                    php bin/console d:d:c &&
                                    yes | php bin/console d:m:m"

echo "Done"
