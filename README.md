SETUP
- set .env
- composer install
- php artisan key:generate
- php artisan migrate
- php artisan serve
- buka http://127.0.0.1:8000/admin/login

SETUP FILAMENT
- php artisan filament:install --panels
- php artisan make:filament-user

CARA PULL CODE TERBARU MASTER
- git checkout [branchmu]
- git fetch origin
- git rebase origin/master