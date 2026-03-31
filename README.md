# Panduan Lengkap Clone & Jalankan Proyek Perpustakaan UKK (XAMPP)

Proyek ini dibuat menggunakan **Laravel 10** dan dapat dijalankan di komputer lokal dengan **XAMPP**.

---

## Langkah-langkah

```bash
# 1. Clone repository
git clone https://github.com/silvicaffza/perpustakaan-ukk01.git
cd perpustakaan-ukk01

# 2. Install backend dependency
composer install

# 3. Install frontend dependency (Tailwind / Vite)
npm install
npm run dev

# 4. Copy file .env dan generate key Laravel
cp .env.example .env
php artisan key:generate

# 5. Edit file .env untuk sesuaikan koneksi database XAMPP
# Contoh:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=pika_perpus
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Migrasi database & seed data
php artisan migrate --seed

# 7. Jalankan server Laravel
php artisan serve