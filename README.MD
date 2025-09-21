# 🛒 Jualin Marketplace

Jualin adalah platform e-commerce modern yang dibangun dengan Next.js 15, TypeScript, dan Sanity CMS. Platform ini menyediakan fitur lengkap untuk marketplace online dengan integrasi pembayaran Midtrans.

## 🚀 Fitur Utama

- **🛍️ E-commerce Lengkap**: Katalog produk, keranjang belanja, wishlist
- **💳 Payment Gateway**: Integrasi Midtrans untuk pembayaran
- **👤 User Management**: Autentikasi dengan Clerk
- **📱 Responsive Design**: UI modern dengan Tailwind CSS
- **🎨 Admin Dashboard**: Panel admin untuk mengelola produk, order, dan konten
- **🏷️ Brand & Category**: Manajemen brand dan kategori produk
- **📍 Address Management**: Sistem alamat pengiriman

## 🛠️ Tech Stack

- **Frontend**: Next.js 15 (App Router), TypeScript, Tailwind CSS
- **Backend**: Next.js API Routes, Sanity CMS
- **Database**: Sanity (Headless CMS)
- **Authentication**: Clerk
- **Payment**: Midtrans
- **UI Components**: Radix UI, Lucide Icons
- **Package Manager**: Bun

## 📋 Prerequisites

Pastikan Anda telah menginstall:

- **Node.js** (v18 atau lebih baru)
- **Bun** (Package manager)
- **Git**

### Install Bun

```bash
# macOS/Linux
curl -fsSL https://bun.sh/install | bash

# Windows (PowerShell)
powershell -c "irm bun.sh/install.ps1 | iex"

# Atau via npm
npm install -g bun
```

## 🚀 Instalasi & Setup

### 1. Clone Repository

```bash
git clone <repository-url>
cd jualin
```

### 2. Install Dependencies

```bash
bun install
```

### 3. Environment Variables

Buat file `.env.local` di root directory dan isi dengan konfigurasi berikut:

```env
# APPLICATION CONFIGURATION
NEXT_PUBLIC_BASE_URL=http://localhost:3000

# SANITY CMS CONFIGURATION
NEXT_PUBLIC_SANITY_PROJECT_ID=your_sanity_project_id
NEXT_PUBLIC_SANITY_DATASET=production
NEXT_PUBLIC_SANITY_API_VERSION=2024-01-01
SANITY_API_READ_TOKEN=your_sanity_read_token
SANITY_API_WRITE_TOKEN=your_sanity_write_token

# CLERK AUTHENTICATION
NEXT_PUBLIC_CLERK_PUBLISHABLE_KEY=your_clerk_publishable_key
CLERK_SECRET_KEY=your_clerk_secret_key
NEXT_PUBLIC_CLERK_SIGN_IN_URL=/sign-in
NEXT_PUBLIC_CLERK_SIGN_UP_URL=/sign-up

# MIDTRANS PAYMENT GATEWAY
MIDTRANS_SERVER_KEY=your_midtrans_server_key
NEXT_PUBLIC_MIDTRANS_CLIENT_KEY=your_midtrans_client_key
MIDTRANS_IS_PRODUCTION=false
```

### 5. Setup Clerk Authentication

1. Buat akun di [Clerk.com](https://clerk.com)
2. Buat aplikasi baru
3. Copy API keys ke `.env.local`
4. Konfigurasi redirect URLs:
   - Sign-in URL: `http://localhost:3000/sign-in`
   - Sign-up URL: `http://localhost:3000/sign-up`
   - After sign-in: `http://localhost:3000`
   - After sign-up: `http://localhost:3000`

### 6. Setup Midtrans Payment

1. Daftar di [Midtrans](https://midtrans.com)
2. Dapatkan Server Key dan Client Key dari dashboard
3. Konfigurasi di `.env.local`
4. Setup Webhook URLs di Midtrans Dashboard:
   - **Notification URL**: `http://localhost:3000/api/midtrans/notification`
   - **Finish Redirect URL**: `http://localhost:3000/api/midtrans/finish`
   - **Error Redirect URL**: `http://localhost:3000/cart?error=payment_failed`
   - **Pending Redirect URL**: `http://localhost:3000/cart?status=pending`

## 🏃‍♂️ Menjalankan Aplikasi

### Development Mode

```bash
bun dev
```

Aplikasi akan berjalan di `http://localhost:3000`

### Production Build

```bash
# Build aplikasi
bun run build

# Jalankan production server
bun start
```

##  Login Admin

### Akses Admin Dashboard

1. Buka browser dan navigasi ke: `http://localhost:3000/admin/login`

2. Gunakan kredensial admin berikut:
   - **Email**: `admin@jualin.com`
   - **Password**: `Jualinyuk2025#`

3. Setelah login berhasil, Anda akan diarahkan ke dashboard admin di: `http://localhost:3000/admin/dashboard`

### Fitur Admin Dashboard

- **Dashboard**: Overview statistik dan analytics
- **Products**: Manajemen produk (tambah, edit, hapus)
- **Orders**: Kelola pesanan dan status pembayaran
- **Categories**: Manajemen kategori produk
- **Brands**: Manajemen brand/merek
- **Authors**: Manajemen penulis
- **Addresses**: Manajemen alamat pengiriman
- **Settings**: Konfigurasi sistem

## 📁 Struktur Project

```
jualin/
├── app/
│   ├── (client)/           # Client-side pages
│   │   ├── api/           # API routes
│   │   ├── cart/          # Shopping cart
│   │   ├── product/       # Product pages
│   │   ├── success/       # Payment success
│   │   └── ...
│   ├── admin/             # Admin dashboard
│   │   ├── dashboard/     # Admin dashboard
│   │   ├── products/      # Product management
│   │   ├── orders/        # Order management
│   │   └── ...
│   └── api/               # Global API routes
├── components/            # Reusable components
├── actions/              # Server actions
├── lib/                  # Utility libraries
├── sanity/               # Sanity CMS configuration
├── store.ts              # Zustand store
└── ...
```

## 🔧 Konfigurasi Tambahan

### Sanity Studio

Akses Sanity Studio untuk mengelola konten:

```bash
# Jalankan Sanity Studio
bun run sanity dev
```

Studio akan tersedia di `http://localhost:3000/studio`

### Database Seeding

Jika Anda memiliki data seed:

```bash
# Import data ke Sanity
sanity dataset import seed/data.ndjson production
```

### Environment Variables untuk Production

Pastikan semua environment variables sudah diset dengan nilai production:

- Update `NEXT_PUBLIC_BASE_URL` dengan domain production
- Set `MIDTRANS_IS_PRODUCTION=true` untuk production
- Update Midtrans webhook URLs dengan domain production

## 🔍 Testing

### Test Payment Flow

1. Tambahkan produk ke keranjang
2. Checkout dengan alamat pengiriman
3. Test pembayaran dengan kartu test Midtrans:
   - **Card Number**: `4811 1111 1111 1114`
   - **CVV**: `123`
   - **Exp Date**: `01/25`

### Test Admin Functions

1. Login ke admin dashboard
2. Test CRUD operations untuk produk
3. Verifikasi order management
4. Test blog management

## 🐛 Troubleshooting

### Common Issues

1. **Sanity Connection Error**
   - Pastikan project ID dan tokens benar
   - Cek network connection

2. **Clerk Authentication Error**
   - Verifikasi API keys
   - Cek redirect URLs configuration

3. **Midtrans Payment Error**
   - Pastikan server key dan client key valid
   - Cek webhook URLs configuration

4. **Build Errors**
   - Clear cache: `bun run clean`
   - Reinstall dependencies: `rm -rf node_modules && bun install`

### Logs

Check logs untuk debugging:

```bash
# Development logs
bun dev

# Production logs
bun start
```

## License

This project is licensed under the MIT License.

---
