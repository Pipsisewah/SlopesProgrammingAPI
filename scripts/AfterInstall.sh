#!/bin/bash
cd /var/www/html/SlopesProgrammingAPI/
php artisan migrate
php artisan config:cache
