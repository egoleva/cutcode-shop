# Installation

composer install
php artisan shop:install
make .env and env.testing from .env.example !IMPORTANT

.env FILESYSTEM_DISK=public
composer require barryvdh/laravel-debugbar --dev
php artisan telescope:install
composer require laravel/telescope

composer require intervention/image

npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
# см https://tailwindcss.ru/docs/guides/laravel/?ysclid=l9q2bqtoqj264516789

npm run build

# Deploy