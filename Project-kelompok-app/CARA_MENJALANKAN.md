# Panduan Menjalankan Aplikasi dan Menguji Pembayaran (Midtrans)

Dokumen ini menjelaskan langkah-langkah untuk menyiapkan, menjalankan, dan menguji aplikasi **Project-kelompok-app** berbasis Laravel, khususnya untuk menguji `PaymentNotificationController.php` (Webhook Midtrans Callback).

---

## 📋 Prasyarat Sistem
Sebelum memulai, pastikan perangkat Anda sudah terinstal:
* **PHP >= 8.2**
* **Composer**
* **Node.js & NPM**
* **SQLite** (default database yang digunakan pada project ini)

---

## 🚀 Langkah Instalasi & Setup Pertama Kali

Ikuti langkah-langkah berikut di terminal/PowerShell pada direktori project:

### 1. Instal Dependensi PHP
```bash
composer install
```

### 2. Instal Dependensi Frontend (CSS/JS)
```bash
npm install
```

### 3. Konfigurasi Environment File
Salin file `.env.example` menjadi `.env` jika belum ada:
```bash
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Setup Database & Seeding Data Produk
Aplikasi ini dikonfigurasi menggunakan SQLite (`database/database.sqlite` sudah disediakan). Jalankan perintah berikut untuk menyegarkan database dan mengisi data produk contoh:
```bash
php artisan migrate:fresh --seed
```
*Seeder akan otomatis membuat 4 produk demo (Mesa Wallpaper Pack, Zen Monolithic Icons, dll).*

---

## 💻 Menjalankan Aplikasi Secara Lokal

Anda perlu menjalankan dua server berikut secara bersamaan:

1. **Jalankan Laravel Development Server:**
   ```bash
   php artisan serve
   ```
   Aplikasi akan berjalan di [http://127.0.0.1:8000](http://127.0.0.1:8000).

2. **Jalankan Asset Compiler (Vite):**
   ```bash
   npm run dev
   ```

---

## 💳 Cara Kerja & Metode Pembayaran

Aplikasi ini mendukung dua mode pembayaran untuk mempermudah proses pengembangan:

### A. Mode Simulasi (Sangat Direkomendasikan untuk Development Awal)
Anda **tidak memerlukan** API Key Midtrans untuk mencoba alur checkout.
1. Buka storefront di browser ([http://127.0.0.1:8000](http://127.0.0.1:8000)).
2. Pilih produk dan klik tombol **Checkout**.
3. Isi data pelanggan dan klik **Bayar Sekarang**.
4. Anda akan diarahkan ke halaman status pesanan yang berstatus **PENDING**.
5. Karena dalam Mode Simulasi, akan muncul tombol **"Simulasi Bayar Sukses"**, **"Simulasi Bayar Gagal"**, atau **"Simulasi Kadaluarsa"** di bagian bawah halaman. Anda tinggal mengkliknya untuk mengubah status transaksi langsung di database.

### B. Mode Integrasi Midtrans Sandbox (Menggunakan API Key Asli)
Jika ingin mencoba integrasi langsung dengan pop-up Snap Midtrans:
1. Daftar atau masuk ke [Midtrans Dashboard Sandbox](https://dashboard.sandbox.midtrans.com/).
2. Masuk ke menu **Settings > Access Keys**, dapatkan **Client Key** dan **Server Key**.
3. Tambahkan baris berikut ke file `.env` Anda:
   ```env
   MIDTRANS_SERVER_KEY=SB-Mid-server-XXXXXXXXXXXXXX
   MIDTRANS_CLIENT_KEY=SB-Mid-client-XXXXXXXXXXXXXX
   MIDTRANS_IS_PRODUCTION=false
   ```
4. Restart server Laravel (`php artisan serve`). Saat Anda melakukan checkout, pop-up pembayaran resmi dari Midtrans akan muncul.

---

## 🔔 Menguji Webhook Callback (`PaymentNotificationController.php`)

Ketika pembayaran diselesaikan di Midtrans, Midtrans akan mengirimkan HTTP POST (Webhook) ke endpoint aplikasi Anda:
`POST /payment/callback` yang ditangani oleh [PaymentNotificationController.php](file:///d:/Pengembangan%20Web%20FrameWork/Laravel/Project-kelompok-app/app/Http/Controllers/PaymentNotificationController.php).

Berikut cara mengujinya secara lokal:

### Metode 1: Simulasi Webhook via `curl` (Tanpa Internet / Ngrok)
Karena aplikasi memiliki **Simulation Mode** (bila API key Midtrans tidak diatur), validasi signature key akan secara otomatis bernilai `true` (dipercaya). Anda bisa mengirimkan request simulasi langsung menggunakan `curl` atau Postman ke server lokal Anda.

1. Buat pesanan terlebih dahulu melalui web untuk mendapatkan **Order ID** (misal: `KS-ABC-1717650000`).
2. Jalankan perintah `curl` berikut di terminal/command prompt (sesuaikan `order_id` dengan ID pesanan Anda):

```bash
curl -X POST http://127.0.0.1:8000/payment/callback \
     -H "Content-Type: application/json" \
     -d '{
       "order_id": "KS-ABC-1717650000",
       "transaction_status": "settlement",
       "payment_type": "bank_transfer",
       "transaction_id": "TRX-SIMULATED-99999",
       "gross_amount": "29000.00"
     }'
```

3. Periksa log Laravel di `storage/logs/laravel.log` atau buka halaman status pesanan Anda. Status pesanan akan berubah menjadi **PAID** (Lunas).

---

### Metode 2: Menggunakan Terowongan (Ngrok) untuk Menerima Webhook Asli Midtrans
Jika Anda menggunakan API Key asli dan ingin Midtrans mengirimkan callback langsung ke laptop/komputer lokal Anda:

1. Unduh dan jalankan **Ngrok** atau Local Tunnel:
   ```bash
   ngrok http 8000
   ```
2. Salin URL forwarding HTTPS yang diberikan oleh Ngrok (misal: `https://abcd-123-456.ngrok-free.app`).
3. Buka **Midtrans Dashboard Sandbox**, masuk ke menu **Settings > Configuration**.
4. Pada kolom **Payment Notification URL**, masukkan URL Ngrok Anda ditambahkan dengan `/payment/callback`. 
   Contoh: `https://abcd-123-456.ngrok-free.app/payment/callback`.
5. Klik **Save**.
6. Lakukan transaksi. Midtrans akan mengirimkan callback asli, dan file `PaymentNotificationController.php` Anda akan memproses status tersebut secara otomatis secara real-time.
