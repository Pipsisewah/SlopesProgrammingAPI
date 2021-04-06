#!/bin/bash
php artisan migrate
php artisan config:cache
