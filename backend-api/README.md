# TTK API

## Installation

1. First, install Docker and then run these commands inside the project directory:

   ```bash
   docker compose up -d
   sudo chmod -R 777 ./storage/
   docker exec -it ttk_api_app bash
2. Inside the Docker container, run the following commands to set up the application:
   ```bash
   composer install
   php artisan key:generate
   php artisan config:cache
   php artisan migrate
   php artisan storage:link
4. To get the test data
   ```bash
   php artisan db:seed
5. To run tests:
    ```bash
    php artisan migrate --env=testing
    php artisan test
Api will be available at http://localhost:8876/


