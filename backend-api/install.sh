
docker compose up -d --build

sudo chmod -R 777 ./

cp .env.example .env

docker exec -it ttk_api_app bash -c "
  cd /var/www &&
  composer install &&
  php artisan key:generate &&
  php artisan config:cache &&
  php artisan migrate:fresh --seed &&
  php artisan storage:link
"
