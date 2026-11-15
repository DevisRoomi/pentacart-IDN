# Panduan Deploy PentaCart ke Vercel

Konfigurasi container, PostgreSQL, penyimpanan gambar, dan workflow tes sudah disiapkan. Deploy pertama masih memerlukan layanan cloud dan variabel rahasia milik akunmu; jangan kirim password, API key, atau connection string lewat chat atau commit ke Git.

Vercel Hobby dan Neon Free memiliki kuota bulanan; jika kuota Vercel habis, deployment dapat berhenti sampai kuota pulih. Paket gratis ini sesuai untuk demo kampus non-komersial, bukan jaminan layanan tanpa batas.

## 1. Buat PostgreSQL gratis di Neon

1. Buat project Free di [Neon](https://console.neon.tech/), pilih region Singapore.
2. Salin connection string PostgreSQL **pooled** dari tombol **Connect**. Simpan sebagai `DB_URL`; jangan hilangkan parameter SSL.

## 2. Siapkan penyimpanan gambar di Cloudflare R2

Buat dua bucket di [Cloudflare R2](https://dash.cloudflare.com/):

- Satu bucket gambar permanen yang dapat dibaca publik (QRIS dan foto menu memang ditampilkan kepada pengunjung).
- Satu bucket privat untuk unggahan sementara Livewire.

Buat R2 API token dengan akses baca/tulis hanya ke dua bucket tersebut. Untuk bucket sementara, izinkan CORS `PUT` dan `GET` dari domain Vercel; URL upload Livewire bertanda tangan. Tambahkan lifecycle rule untuk menghapus isi bucket sementara setelah satu hari.

## 3. Hubungkan GitHub ke Vercel

1. Import repository `DevisRoomi/pentacart-IDN` di [Vercel](https://vercel.com/new). `vercel.json` memilih preset **Container** agar Vercel tidak memakai deteksi Vite dari `package.json`.
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
PUBLIC_DISK_DRIVER=s3
LIVEWIRE_TEMPORARY_FILE_UPLOAD_DISK=s3-temp
AWS_ACCESS_KEY_ID=<R2 token access key>
AWS_SECRET_ACCESS_KEY=<R2 token secret key>
AWS_DEFAULT_REGION=auto
AWS_BUCKET=<nama bucket gambar permanen>
AWS_TEMP_BUCKET=<nama bucket unggahan sementara>
AWS_ENDPOINT=https://<account-id>.r2.cloudflarestorage.com
AWS_URL=https://<alamat publik bucket gambar>
AWS_USE_PATH_STYLE_ENDPOINT=true
```

Set `APP_KEY` satu kali, lalu gunakan nilai yang sama pada setiap deployment Production. Jangan gunakan key produksi di Preview. Domain bucket publik diperlukan agar browser dapat menampilkan QRIS dan foto menu.

## 4. Jalankan migrasi pertama

Di GitHub, tambahkan secret `PRODUCTION_DB_URL` (URL Neon yang sama) pada environment `production`. Setelah workflow ini tersedia di branch `main`, jalankan **Actions → Migrate production database → Run workflow** satu kali sebelum menerima data produksi. Workflow hanya menjalankan migrasi yang belum diterapkan.

## 5. Deploy dan pembaruan

Push atau merge ke `main` akan menjalankan tes PostgreSQL melalui GitHub Actions dan memicu deployment Vercel. Atur pemeriksaan GitHub Actions sebagai pemeriksaan wajib sebelum merge agar kode yang gagal tes tidak masuk ke branch produksi. Pull request menghasilkan preview Vercel.

## Batas kuota yang perlu dipantau

- [Vercel Hobby](https://vercel.com/docs/plans/hobby): compute dan jumlah request memiliki batas bulanan; deployment dapat dijeda jika kuota habis.
- [Neon Free](https://neon.com/pricing): batas storage dan compute per project.
- [Cloudflare R2 Free tier](https://developers.cloudflare.com/r2/pricing/): storage dan jumlah operasi bulanan terbatas.
