# 🛒 PentaCart IDN - Katalog QRIS & Pesan Antar Asrama Mahasiswa

> **Tugas Pekanan 2 – Project Kolaborasi Laravel + Livewire**  
> Dikerjakan secara berkelompok menggunakan GitHub Collaborator.

---

## 📌 Tentang Project
PentaCart IDN adalah platform agregator lapak mahasiswa di lingkungan kampus dan asrama. Memfasilitasi mahasiswa wirausaha untuk memajang QRIS dan katalog jualan, serta memudahkan pembeli memesan jajanan/barang dengan layanan antar kamar asrama dan konfirmasi otomatis via WhatsApp.

### 👥 Anggota Kelompok
1. **Devis Roomi (Lead / Core Backend & Architecture)** - [@DevisRoomi](https://github.com/DevisRoomi)
2. **Ahmad Inumair (Merchant Product Manager)** - [@ahmadinumair](https://github.com/ahmadinumair)
3. **Apip (Public Catalog & Buyer Order Flow)** - [@apipsuper67-web](https://github.com/apipsuper67-web)

---

## 🛠️ Tech Stack
- **Framework:** Laravel 12 / PHP 8.2+
- **Reactive UI:** Livewire 4
- **CSS:** Tailwind CSS v4
- **Database:** MySQL
- **Environment:** Laravel Herd / Flyenv

---

## 🚀 Panduan Setup Lokal untuk Collaborator

1. **Clone repository:**
   ```bash
   git clone https://github.com/DevisRoomi/pentacart-IDN.git
   cd pentacart-IDN
   ```

2. **Install dependency PHP & Node:**
   ```bash
   composer install
   npm install
   ```

3. **Setup Environment (`.env`):**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   *Pastikan setting database MySQL di `.env` disesuaikan dengan kredensial lokal masing-masing.*

4. **Jalankan Database Migration & Symlink Storage:**
   ```bash
   php artisan migrate
   php artisan storage:link
   ```

5. **Jalankan Aplikasi:**
   - Bila menggunakan **Laravel Herd**: Langsung akses via `http://pentacart-idn.test`
   - Bila tanpa Herd:
     ```bash
     php artisan serve
     npm run dev
     ```

---

## 🌿 Aturan Kolaborasi Git (Anti Conflict)

1. **Dilarang langsung commit ke branch `main`.**
2. Buat branch baru sebelum coding fitur:
   ```bash
   git checkout -b feature/nama-fitur
   ```
3. Commit dan push ke branch fitur:
   ```bash
   git add .
   git commit -m "feat: deskripsi pekerjaan"
   git push origin feature/nama-fitur
   ```
4. Buka **Pull Request (PR)** di GitHub menuju branch `main` untuk direview dan dimerge.
5. Sebelum membuat fitur baru berikutnya, update branch `main` lokal:
   ```bash
   git checkout main
   git pull origin main
   ```
