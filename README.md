# Installation

php artisan storage:link
.env FILESYSTEM_DISK=public
composer require barryvdh/laravel-debugbar --dev
php artisan telescope:install
composer require laravel/telescope
php artisan migrate

# Deploy