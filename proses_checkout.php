<?php
// proses_checkout.php
require_once 'koneksi.php';
header('Content-Type: application/json');

// Tangkap data dari JS FormData
$nama = $_POST['nama'] ?? '';
$metode = $_POST['metode'] ?? '';
$items_json = $_POST['items'] ?? '[]';
$items = json_decode($items_json, true);

if (empty($nama) || empty($metode) || empty($items)) {
    echo json_encode(['error' => 'Data tidak lengkap']);
    exit;
}

// Buat ID Transaksi Unik
$order_id = 'TRX-' . strtoupper(substr(md5(time() . rand()), 0, 6));
$total_semua = 0;

foreach ($items as $item) {
    $total_semua += $item['subtotal'];
}

// 1. Simpan ke tabel pemesanan_tiket
$stmt = mysqli_prepare($koneksi, "INSERT INTO pemesanan_tiket (id_transaksi, nama_pemesan, metode_pembayaran, total, status) VALUES (?, ?, ?, ?, 'Menunggu Pembayaran')");
mysqli_stmt_bind_param($stmt, 'sssi', $order_id, $nama, $metode, $total_semua);

if (mysqli_stmt_execute($stmt)) {
    // 2. Simpan setiap destinasi ke tabel pemesanan_detail
    $stmtDetail = mysqli_prepare($koneksi, "INSERT INTO pemesanan_detail (id_transaksi, nama_destinasi, harga_satuan, jumlah, subtotal) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($items as $item) {
        mysqli_stmt_bind_param($stmtDetail, 'ssiii', $order_id, $item['destinasi'], $item['harga'], $item['jumlah'], $item['subtotal']);
        mysqli_stmt_execute($stmtDetail);
    }
    
    echo json_encode(['success' => true, 'order_id' => $order_id]);
} else {
    echo json_encode(['error' => 'Gagal menyimpan ke database']);
}
?>