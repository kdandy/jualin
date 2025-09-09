# Langkah-langkah Deployment Koyeb - FIXED (HTTP Support)

## ✅ Masalah yang Sudah Diperbaiki:

1. **Composer.lock tidak sinkron** - ✅ Sudah diupdate dengan `composer update`
2. **Script post-install bermasalah** - ✅ Sudah dihapus dari composer.json
3. **File .env tidak ada** - ✅ Akan menggunakan environment variables
4. **HTTPS redirect** - ✅ Sudah dinonaktifkan untuk mendukung HTTP
5. **Artisan command error** - ✅ Script composer sudah disederhanakan

## 🚀 Langkah Deployment di Koyeb:

### 1. **Set Environment Variables di Koyeb Dashboard:**

Buka Koyeb Dashboard → App → Settings → Environment Variables, lalu tambahkan:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=http://independent-rosamund-mahkamah-agung-dd226431.koyeb.app
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
LOG_CHANNEL=stderr
DB_CONNECTION=pgsql
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_CONNECTION=sync
BP_PHP_VERSION=8.2.*
COMPOSER_INSTALL_OPTIONS=--no-dev --optimize-autoloader
FORCE_HTTPS=false
SESSION_SECURE_COOKIE=false
```

### 2. **Generate APP_KEY:**

Jalankan di local:
```bash
php artisan key:generate
```

Copy hasilnya dan paste ke environment variable `APP_KEY` di Koyeb.

### 3. **Deploy di Koyeb:**

1. Buka Koyeb Dashboard
2. Pilih "Create App"
3. Connect ke GitHub repository: `KKN-BankSampah/kkn`
4. Pilih branch: `main`
5. Buildpack: `heroku/php`
6. Deploy

### 4. **Setelah Deploy Berhasil:**

Jalankan command ini di Koyeb Console untuk setup aplikasi:

```bash
# Generate application key
php artisan key:generate --force

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 775 storage bootstrap/cache

# Discover packages
php artisan package:discover
```

Atau jalankan script yang sudah disediakan:
```bash
./post-deploy.sh
```

## 📁 File Konfigurasi yang Sudah Dibuat:

- ✅ `composer.json` - Script sudah disederhanakan (tanpa artisan commands)
- ✅ `composer.lock` - Lock file yang sudah diupdate
- ✅ `Procfile` - Web server configuration
- ✅ `app.json` - Heroku/Koyeb configuration (HTTP support)
- ✅ `public/.htaccess` - URL rewriting
- ✅ `koyeb.toml` - Koyeb specific config (HTTP support)
- ✅ `app/Http/Middleware/ForceHttps.php` - HTTPS control middleware
- ✅ `config/app.php` - Force HTTPS configuration
- ✅ `post-deploy.sh` - Script untuk post-deploy commands

## 🔧 Troubleshooting:

### Jika masih error build:
1. Pastikan semua environment variables ter-set
2. Pastikan APP_KEY sudah di-generate
3. Cek logs di Koyeb dashboard
4. Pastikan composer.lock sudah ter-commit

### Jika error 403 setelah deploy:
1. Jalankan command artisan di Koyeb console
2. Pastikan permission storage dan bootstrap/cache
3. Cek apakah database connection berfungsi

### Jika masih redirect ke HTTPS:
1. Pastikan `FORCE_HTTPS=false` di environment variables
2. Pastikan `SESSION_SECURE_COOKIE=false` di environment variables
3. Clear cache: `php artisan config:clear`

### Jika artisan command error:
1. Script composer sudah disederhanakan
2. Jalankan command artisan manual di Koyeb console
3. Gunakan script `post-deploy.sh` untuk automation

## 💡 Tips:

1. **Monitor logs** di Koyeb dashboard untuk debugging
2. **Gunakan APP_DEBUG=true** sementara untuk melihat error detail
3. **Pastikan semua environment variables** ter-set dengan benar
4. **Test locally** sebelum deploy
5. **Aplikasi sekarang mendukung HTTP** tanpa redirect ke HTTPS
6. **Script composer sudah disederhanakan** untuk menghindari error build

## 🎯 Expected Result:

Setelah mengikuti langkah-langkah di atas, aplikasi Laravel Anda seharusnya:
- ✅ Build berhasil tanpa error
- ✅ Deploy berhasil
- ✅ Bisa diakses di http://independent-rosamund-mahkamah-agung-dd226431.koyeb.app
- ✅ Tidak ada error 403
- ✅ Tidak ada redirect ke HTTPS
- ✅ Login berfungsi dengan HTTP
- ✅ Artisan commands berjalan normal setelah deploy 