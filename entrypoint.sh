#!/bin/sh

# Instala Composer y NPM
composer install
# npm install

# Espera a la base de datos
until nc -z db 3306; do
  echo "Esperando a la base de datos..."
  sleep 2
done

# Genera `APP_KEY`
php artisan key:generate --force

# Ejecuta la migración
php artisan migrate --force
php artisan optimize:clear

exec apache2-foreground
