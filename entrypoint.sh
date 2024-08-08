#!/bin/bash

composer install

if [ -z "$APP_KEY" ]; then
  echo "No APP_KEY found, setting APP_KEY..."
  php artisan key:generate --force
fi

php artisan config:cache
php artisan config:clear

exec "$@"