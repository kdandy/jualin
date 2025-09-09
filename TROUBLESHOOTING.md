# Troubleshooting Build Error di Koyeb

## Error yang Terjadi:
```
ERROR: An unknown internal error occurred.
Contact Heroku Support for assistance if this problem persists.
```

## Penyebab dan Solusi:

### 1. **Masalah PHP Buildpack**
- **Penyebab**: Buildpack PHP tidak kompatibel dengan versi PHP yang digunakan
- **Solusi**: 
  - Gunakan `BP_PHP_VERSION = "8.2.*"` di environment variables
  - Pastikan `composer.json` memiliki `"php": "^8.2"`

### 2. **Masalah Composer Dependencies**
- **Penyebab**: Konflik dependencies atau cache yang rusak
- **Solusi**:
  - Hapus `composer.lock` dan biarkan regenerate
  - Gunakan `--no-dev --optimize-autoloader` saat install

### 3. **Masalah File Permissions**
- **Penyebab**: Directory storage dan bootstrap/cache tidak writable
- **Solusi**:
  - Pastikan script `chmod -R 775 storage bootstrap/cache` dijalankan
  - Gunakan `setup-permissions.sh` script

### 4. **Masalah Environment Variables**
- **Penyebab**: APP_KEY tidak ter-generate atau environment variables tidak ter-set
- **Solusi**:
  - Pastikan `php artisan key:generate --force` dijalankan
  - Set semua environment variables di Koyeb dashboard

## File Konfigurasi yang Sudah Dibuat:

### Untuk Buildpack (Recommended):
- `Procfile` - Web server configuration
- `app.json` - Heroku/Koyeb app configuration
- `koyeb.toml` - Koyeb specific configuration
- `buildpack.toml` - Buildpack configuration

### Untuk Docker (Alternative):
- `Dockerfile` - Docker container configuration
- `docker/apache.conf` - Apache configuration
- `.dockerignore` - Docker ignore file

## Langkah-langkah Deployment:

### Option 1: Buildpack (Recommended)
1. Commit semua file konfigurasi
2. Push ke repository
3. Deploy di Koyeb menggunakan buildpack
4. Set environment variables di dashboard

### Option 2: Docker
1. Commit semua file konfigurasi
2. Push ke repository
3. Deploy di Koyeb menggunakan Docker
4. Set environment variables di dashboard

## Environment Variables yang Diperlukan:
```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://independent-rosamund-mahkamah-agung-dd226431.koyeb.app
APP_KEY=base64:YOUR_GENERATED_KEY
LOG_CHANNEL=stderr
DB_CONNECTION=pgsql
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_CONNECTION=sync
BP_PHP_VERSION=8.2.*
COMPOSER_INSTALL_OPTIONS=--no-dev --optimize-autoloader
```

## Tips Tambahan:
1. **Gunakan buildpack terlebih dahulu** sebelum mencoba Docker
2. **Monitor logs** di Koyeb dashboard untuk debugging
3. **Pastikan semua dependencies** ter-install dengan benar
4. **Test locally** dengan Docker sebelum deploy

## Jika Masih Error:
1. Coba deploy dengan Docker sebagai alternatif
2. Kontak Koyeb support jika masalah persist
3. Cek apakah ada konflik dengan PHP extensions
4. Pastikan semua file konfigurasi sudah benar 