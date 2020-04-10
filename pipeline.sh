cd /var/www/pharma
git pull
composer install --no-dev
php artisan migrate
npm run dev
exit