<?php
// proses_beli_tiket.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/koneksi.php';
header('Content-Type: application/json');

// 1. TAMBAHKAN BARIS INI: Memaksa mysqli melempar error agar masuk ke blok catch
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Hanya member yang login yang boleh melakukan pemesanan
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Sesi login tidak ditemukan. Silakan login ulang.']);
    exit;
}

$id_user = (int) $_SESSION['user_id'];
$nama    = trim($_POST['nama'] ?? '');
$metode  = trim($_POST['metode'] ?? '');
$items   = json_decode($_POST['items'] ?? '[]', true);

// Validasi dasar
if ($nama === '' || $metode === '' || !is_array($items) || count($items) === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Data pesanan tidak lengkap.']);
    exit;
}

// Hitung ulang total di server
$total = 0;
foreach ($items as $it) {
    $total += (int) $it['harga'] * (int) $it['jumlah'];
}

// Generate ID transaksi unik
$id_transaksi = 'MTX' . date('YmdHis') . rand(100, 999);

mysqli_begin_transaction($koneksi);

try {
    // Catatan: jika tabel pemesanan_tiket punya kolom id_user, tambahkan kolom
    // itu di query berikut lalu bind $id_user agar pesanan tertaut ke akun member.
    $stmt = mysqli_prepare(
        $koneksi,
        "INSERT INTO pemesanan_tiket (id_transaksi, nama_pemesan, metode_pembayaran, total, status)
         VALUES (?, ?, ?, ?, 'Menunggu Pembayaran')"
    );
    mysqli_stmt_bind_param($stmt, 'sssi', $id_transaksi, $nama, $metode, $total);
    mysqli_stmt_execute($stmt);

    $stmtDetail = mysqli_prepare(
        $koneksi,
        "INSERT INTO pemesanan_detail (id_transaksi, nama_destinasi, harga, jumlah, subtotal)
         VALUES (?, ?, ?, ?, ?)"
    );
    foreach ($items as $it) {
        $nama_destinasi = $it['destinasi'];
        $harga          = (int) $it['harga'];
        $jumlah         = (int) $it['jumlah'];
        $subtotal       = $harga * $jumlah;
        mysqli_stmt_bind_param($stmtDetail, 'ssiii', $id_transaksi, $nama_destinasi, $harga, $jumlah, $subtotal);
        mysqli_stmt_execute($stmtDetail);
    }

    mysqli_commit($koneksi);
    echo json_encode(['order_id' => $id_transaksi]);

} catch (Exception $e) {
    mysqli_rollback($koneksi);
    http_response_code(500);
    
    // 2. UBAH BARIS INI: Tampilkan error asli dari database MySQL
    echo json_encode([
        'error' => 'Database Error: ' . $e->getMessage()
    ]);
}
?>