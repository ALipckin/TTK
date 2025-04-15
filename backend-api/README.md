# TTK API

## Installation

- First, install Docker and then run inside the project directory install.sh

- To get the test data
   ```bash
   php artisan db:seed
- To run tests:
    ```bash
    php artisan migrate --env=testing
    php artisan test
Api will be available at http://localhost:8876/
