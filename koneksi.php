<?php
// Konfigurasi Database Lokal (Laragon / XAMPP)
$host = "localhost";
$user = "root";       // Username bawaan untuk server lokal
$pass = "";           // Password bawaan server lokal biasanya kosong
$db   = "bromo_tracking"; // Sesuaikan jika Anda mengubah nama databasenya

// 1. KONEKSI UNTUK MYSQLI 
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi MySQLi gagal: " . mysqli_connect_error());
}

// 2. KONEKSI UNTUK PDO (Hanya jika ada bagian sistem yang menggunakan PDO)
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log("Koneksi PDO gagal: " . $e->getMessage());
}
?>