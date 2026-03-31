<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/silvicaffza/perpustakaan-ukk01/main/public/logo.png" width="300" alt="Perpustakaan Logo">
  </a>
</p>

<h1 align="center">Sistem Perpustakaan UKK</h1>

<p align="center">
  <a href="https://github.com/silvicaffza/perpustakaan-ukk01/actions">
    <img src="https://github.com/silvicaffza/perpustakaan-ukk01/workflows/tests/badge.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Laravel Version">
  </a>
  <a href="https://opensource.org/licenses/MIT">
    <img src="https://img.shields.io/badge/license-MIT-green" alt="License">
  </a>
</p>



## ⚡ Fitur Utama

### Role & Akses
|   Role  | Fitur                                                             |
|---------|-------------------------------------------------------------------|
| Admin   | CRUD Buku, Kelola Peminjaman, Laporan Peminjaman & Penolakan      |
| Petugas | Lihat Buku, Proses Peminjaman & Pengembalian, Laporan Sederhana   |
| User    | Lihat Buku, Peminjaman & Pengembalian                             |

### Manajemen Buku
- Tambah, edit, hapus buku  
- Lihat daftar buku tersedia  

### Peminjaman & Pengembalian
- Ajukan peminjaman buku  
- Admin bisa setujui atau tolak peminjaman  
- Catatan batas pengambilan & peminjaman  
- Notifikasi keterlambatan pengembalian  

### Laporan
- Riwayat peminjaman buku  
- Riwayat penolakan peminjaman  
- Filter berdasarkan user, buku, atau tanggal  

## 💻 Cara Clone & Jalankan Proyek

```bash
git clone https://github.com/silvicaffza/perpustakaan-ukk01.git
cd perpustakaan-ukk01
composer install
npm install
npm run dev
php artisan key:generate
php artisan migrate --seed
php artisan serve