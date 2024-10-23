## TTK API

### Installation:

Firstable install docker and then
run these commands inside project directory:

    docker compose -d

    sudo chmod 777 -R ./storage/

    docker exec -it ttk_api_app bash

    composer install

    php artisan key:generate

    php artisan config:cache

    php artisan migrate

    php artisan storage:link

If you want testing data run:

    php artisan db:seed

To run tests:

    php artisan migrate --env=testing

    php artisan test

Api will be available at http://localhost:8876/


