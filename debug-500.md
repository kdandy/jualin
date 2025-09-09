# Debug Error 500 - Laravel Application

## 🔍 **Error yang Terjadi:**
```
10.250.0.22 - - [29/Jul/2025:07:51:37 +0000] "GET / HTTP/1.1" 500 - "-" "Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:141.0) Gecko/20100101 Firefox/141.0"
```

## 🚨 **Penyebab Umum Error 500:**

### 1. **APP_KEY tidak ter-generate**
- Laravel memerlukan APP_KEY untuk enkripsi
- Jika tidak ada, akan menyebabkan error 500

### 2. **Permission storage tidak benar**
- Directory storage dan bootstrap/cache tidak writable
- Akan menyebabkan error saat menulis cache/log

### 3. **Cache configuration error**
- Config cache rusak atau tidak ter-generate
- Route cache error

### 4. **Database connection error**
- Database tidak tersedia atau credentials salah
- Migration belum dijalankan

## 🔧 **Langkah Debugging di Koyeb Console:**

### **Step 1: Cek Environment Variables**
```bash
echo $APP_KEY
echo $APP_URL
echo $DB_CONNECTION
```

### **Step 2: Generate APP_KEY**
```bash
php artisan key:generate --force
```

### **Step 3: Set Permissions**
```bash
chmod -R 775 storage bootstrap/cache
ls -la storage/
ls -la bootstrap/cache/
```

### **Step 4: Clear dan Regenerate Cache**
```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### **Step 5: Cek Logs**
```bash
tail -f storage/logs/laravel.log
```

### **Step 6: Test Database Connection**
```bash
php artisan tinker
# Di dalam tinker:
DB::connection()->getPdo();
```

### **Step 7: Run Migrations (jika ada database)**
```bash
php artisan migrate --force
```

## 🚀 **Quick Fix Script:**

Jalankan script ini di Koyeb Console:

```bash
#!/bin/bash

echo "=== Debugging Error 500 ==="

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

echo "=== Debugging completed ==="
```

## 📋 **Checklist Debugging:**

- [ ] APP_KEY sudah ter-generate
- [ ] Storage permissions sudah benar (775)
- [ ] Bootstrap/cache permissions sudah benar (775)
- [ ] Config cache sudah ter-generate
- [ ] Route cache sudah ter-generate
- [ ] View cache sudah ter-generate
- [ ] Database connection berfungsi (jika ada)
- [ ] Logs tidak menunjukkan error fatal

## 💡 **Tips Tambahan:**

1. **Gunakan APP_DEBUG=true** sementara untuk melihat error detail
2. **Cek logs di Koyeb dashboard** untuk error detail
3. **Pastikan semua environment variables** ter-set dengan benar
4. **Test database connection** jika menggunakan database
5. **Clear semua cache** dan regenerate

## 🎯 **Expected Result:**

Setelah menjalankan debugging steps:
- ✅ Error 500 hilang
- ✅ Aplikasi bisa diakses normal
- ✅ Login berfungsi
- ✅ Semua fitur berjalan normal 