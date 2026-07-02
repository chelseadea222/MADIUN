<?php
// config/koneksi.php
// File koneksi database bersama, dipakai oleh semua file backend
// (proses_checkout.php, upload_bukti.php, verifikasi_tiket.php, riwayat_pesanan.php).
// Sesuaikan kredensial di bawah ini dengan setup MySQL/XAMPP kamu.

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'bromo_tracking';

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');