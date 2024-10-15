## TTK API

firstable install docker and then
run these commands inside project directory:

- docker compose -d

- sudo chmod 777 -R ./storage/

- docker exec -it ttk_api_app bash

- composer install

- php artisan key:generate

- php artisan config:cache

- php artisan migrate

- php artisan storage:link

if you need testing data run: php artisan db:seed

api will be available at http://localhost:8876/


