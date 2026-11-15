# Panduan Deploy PentaCart ke Vercel

PentaCart dapat dijalankan di Vercel dengan Neon PostgreSQL tanpa Cloudflare R2. Gambar QRIS dan foto menu baru disimpan sebagai data biner di PostgreSQL, bukan di filesystem sementara Vercel.

Vercel Hobby dan Neon Free memiliki batas kuota. Penyimpanan gambar menggunakan kuota database Neon, jadi pantau kapasitas penyimpanan dan compute secara berkala. Paket gratis tidak menjamin layanan tanpa batas atau gratis selamanya.

## 1. Buat PostgreSQL di Neon

1. Buat project di [Neon](https://console.neon.tech/) dan pilih region yang dekat dengan pengguna, misalnya Singapore.
2. Salin connection string PostgreSQL **pooled** dari tombol **Connect**. Simpan sebagai `DB_URL`; jangan hilangkan parameter SSL.

## 2. Hubungkan GitHub ke Vercel

1. Import repository `DevisRoomi/pentacart-IDN` di [Vercel](https://vercel.com/new). `vercel.json` memilih preset **Container**.
2. Pastikan **Framework Preset** adalah **Container** dan root directory tetap `.`.
3. Tambahkan environment variables ini untuk **Production**:

```text
APP_ENV=production
APP_DEBUG=false
APP_URL=https://<domain-vercel>
APP_KEY=<buat sekali dengan: php artisan key:generate --show>
DB_CONNECTION=pgsql
DB_URL=<connection string pooled Neon>
SESSION_DRIVER=database
SESSION_ENCRYPT=true
CACHE_STORE=database
QUEUE_CONNECTION=sync
LOG_CHANNEL=stderr
VIEW_COMPILED_PATH=/tmp/laravel/views
```

Gunakan `APP_KEY` yang sama pada setiap deployment Production. Jangan gunakan key produksi di Preview. Simpan connection string dan key hanya di Vercel Environment Variables atau GitHub Secrets, bukan di chat atau commit.

## 3. Jalankan migrasi pertama

Di GitHub, tambahkan secret `PRODUCTION_DB_URL` (URL Neon yang sama) pada environment `production`. Setelah workflow migrasi tersedia di branch `main`, jalankan **Actions → Migrate production database → Run workflow** satu kali sebelum menerima data produksi. Workflow hanya menjalankan migrasi yang belum diterapkan.

Jika ingin mengimpor daftar lapak awal dari formulir, pilih input **Import the unclaimed student listings and QRIS images** saat menjalankan workflow. Import ini membuat lapak tanpa akun atau password, menyimpan QRIS di PostgreSQL, dan aman dijalankan ulang. Lapak yang sudah terhubung ke akun akan dilewati.

## 4. Deploy dan pembaruan

Push atau merge ke `main` akan menjalankan tes PostgreSQL melalui GitHub Actions dan memicu deployment Vercel. Atur pemeriksaan GitHub Actions sebagai pemeriksaan wajib sebelum merge agar kode yang gagal tes tidak masuk ke branch produksi. Pull request menghasilkan preview Vercel.

## Catatan gambar dan kuota

- Setiap unggahan QRIS atau foto menu dibatasi maksimal 2 MB dan disimpan di tabel PostgreSQL `image_blobs`.
- Data formulir yang tersedia tidak menyertakan foto produk; QRIS dapat diimpor dari tautan Drive publik.
- Data gambar tetap tersedia setelah deployment atau restart karena tersimpan di database, tetapi ikut mengurangi kuota penyimpanan Neon.
- Gambar lama yang hanya berupa path filesystem lokal tidak otomatis dipindahkan ke database. Unggah ulang gambar tersebut setelah deploy; URL gambar eksternal tetap didukung.
- Vercel Hobby dan Neon Free memiliki batas penggunaan yang dapat berubah. Periksa [paket Vercel](https://vercel.com/docs/plans/hobby) dan [paket Neon](https://neon.com/pricing) sebelum menerima beban produksi.
