cd /var/www/pharma
git pull
composer install --no-dev
php artisan migrate --force
npm run dev
exit