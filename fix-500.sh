#!/bin/bash

echo "=== Fixing Error 500 - Laravel Application ==="

# 1. Generate APP_KEY
echo "1. Generating APP_KEY..."
php artisan key:generate --force

# 2. Set permissions
echo "2. Setting permissions..."
chmod -R 775 storage bootstrap/cache

# 3. Clear all caches
echo "3. Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# 4. Regenerate caches
echo "4. Regenerating caches..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Discover packages
echo "5. Discovering packages..."
php artisan package:discover

# 6. Check storage permissions
echo "6. Checking storage permissions..."
ls -la storage/
ls -la bootstrap/cache/

# 7. Test database connection (optional)
echo "7. Testing database connection..."
php artisan tinker --execute="try { DB::connection()->getPdo(); echo 'Database connection OK'; } catch (Exception \$e) { echo 'Database connection failed: ' . \$e->getMessage(); }"

# 8. Run migrations (optional)
echo "8. Running migrations..."
php artisan migrate --force

echo "=== Error 500 fix completed ==="
echo "Please check if the application is working now." 