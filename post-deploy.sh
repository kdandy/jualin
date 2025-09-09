#!/bin/bash

# Post-deploy script for Laravel application
echo "Running post-deploy commands..."

# Generate application key if not exists
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Cache configuration
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
echo "Setting permissions..."
chmod -R 775 storage bootstrap/cache

# Discover packages
echo "Discovering packages..."
php artisan package:discover

echo "Post-deploy commands completed successfully!" 