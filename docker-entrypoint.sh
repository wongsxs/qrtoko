#!/bin/sh
set -e

# Link storage
php artisan storage:link || true

# Run database migrations and seed default data
php artisan migrate --force
php artisan db:seed --force

# Cache routes and views for speed
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Laravel server on Render's assigned port (default 10000)
PORT=${PORT:-10000}
echo "Starting Laravel server on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
