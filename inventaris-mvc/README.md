# Sistem Inventaris MVC

Aplikasi inventaris barang berbasis PHP 8.x, MySQL/MariaDB, PDO, dan pola MVC sederhana.

## Persyaratan

- PHP 8.x dengan ekstensi `pdo_mysql`
- MySQL atau MariaDB
- Apache dengan `mod_rewrite` (XAMPP), atau PHP built-in server

## Instalasi

1. Buat salinan `.env.example` bernama `.env`, lalu sesuaikan koneksi database dan `BASE_URL`.
   - PHP built-in server: `BASE_URL=http://localhost:8000`
   - XAMPP untuk folder proyek `inventaris-mvc`: `BASE_URL=http://localhost/inventaris-mvc/public`
2. Impor `database/inventory.sql` melalui phpMyAdmin atau MySQL CLI. **Impor ulang akan menghapus dan membuat ulang tabel beserta datanya.**
3. Jalankan aplikasi:
   - PHP built-in server dari folder proyek: `php -S localhost:8000 -t public public/index.php`
   - XAMPP: jalankan Apache dan MySQL, lalu buka URL yang sesuai dengan `BASE_URL`.
4. Login dengan akun demo:
   - Username: `admin`
   - Password: `123456`

Akun `staff` dan `manager` juga memakai password demo `123456`.

## Pengujian akhir

- Membuka dashboard tanpa login mengarahkan ke halaman login.
- Login dengan password salah menampilkan pesan gagal; login `admin / 123456` membuka dashboard.
- Tambah, ubah, dan hapus kategori serta barang; pastikan pesan status dan data benar.
- Catat barang masuk dan pastikan stok serta riwayat bertambah.
- Coba barang keluar melebihi stok; operasi harus ditolak dan stok/riwayat tidak berubah.
- Uji pencarian barang, filter kategori, dan paginasi dengan `limit=5`.
- Buka URL yang tidak tersedia; halaman 404 harus memakai layout aplikasi.
- Logout; sesi login harus berakhir dan pengguna kembali ke halaman login.

Error database dan transaksi dicatat pada `logs/errors/`.
