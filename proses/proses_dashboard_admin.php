<?php
require_once '../config/koneksi.php';

// 1. Ambil data dari tabel pemesanan_tiket (bukan tiket_harian)
$stmt = $pdo->query("SELECT * FROM pemesanan_tiket ORDER BY tanggal_pesan DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 2. Inisialisasi Variabel Statistik
$pengunjungHariIni = 0;
$totalTiket        = 0;
$totalPembayaran   = 0;
$today             = date("Y-m-d");

foreach ($data as $item) {
    // Menghitung total orang yang memesan
    $totalTiket += (int)$item['jumlah_orang'];
    
    // Menghitung total uang yang masuk
    $totalPembayaran += (float)$item['total_bayar'];
    
    // Menghitung pesanan yang masuk hari ini
    if (date('Y-m-d', strtotime($item['tanggal_pesan'])) === $today) {
        $pengunjungHariIni++;
    }
}

// 3. Logika untuk Grafik Bulanan (Grafik Lokal/Internal)
$monthlyStats = [];
foreach ($data as $item) {
    // Ambil Format Tahun-Bulan (Contoh: 2024-05)
    $bulan = date('Y-m', strtotime($item['tanggal_pesan']));
    
    if (!isset($monthlyStats[$bulan])) {
        $monthlyStats[$bulan] = 0;
    }
    // Tambahkan jumlah orang ke bulan tersebut
    $monthlyStats[$bulan] += (int)$item['jumlah_orang'];
}

// Urutkan statistik bulanan agar grafik tampil berurutan dari bulan lama ke baru
ksort($monthlyStats);
?>