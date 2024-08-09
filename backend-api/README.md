## TTK API

firstable install docker and then
run these commands inside project directory: 
- docker compose -d

- docker exec -it ttk_api_app bash

- composer install --no-dev --optimize-autoloader

- php artisan key:generate

- php artisan config:cache

- php artisan migrate

- sudo chmod 777 -R ./

if you need testing data run: php artisan db:seed

api will be available at http://localhost:8876/


