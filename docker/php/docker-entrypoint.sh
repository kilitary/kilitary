#!/bin/sh
set -e

cd /var/www/html

if [ -f composer.json ] && [ ! -d vendor ]; then
  echo "[docker-entrypoint] vendor/ missing; running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ "$#" -gt 0 ]; then
  exec "$@"
fi

exec php-fpm
