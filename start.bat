@echo off
docker compose up -d
start cmd /k "php artisan serve"
start cmd /k "npm run dev"
start cmd /k "php artisan queue:work"
