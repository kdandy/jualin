#!/bin/bash

# Setup permissions for Laravel deployment
echo "Setting up Laravel permissions..."

# Create storage directories if they don't exist
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/logs
mkdir -p bootstrap/cache

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (if running as root)
if [ "$EUID" -eq 0 ]; then
    chown -R www-data:www-data storage
    chown -R www-data:www-data bootstrap/cache
fi

echo "Permissions set successfully!"
echo "Storage and bootstrap/cache directories are now writable." 