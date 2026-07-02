<?php
// proses_checkout.php
// Dipanggil oleh beli_tiket.php (via fetch/AJAX) saat tombol "Bayar Sekarang" diklik.
// Tugasnya: simpan pesanan ke database, lalu balikin id_transaksi dalam bentuk JSON,
// supaya beli_tiket.php bisa redirect ke konfirmasi_pembayaran.php?order_id=...

require_once '../config/koneksi.php'; 
header('Content-Type: application/json');

$nama    = trim($_POST['nama'] ?? '');
$metode  = trim($_POST['metode'] ?? '');
$items   = json_decode($_POST['items'] ?? '[]', true);

// Validasi dasar di sisi server (jangan cuma percaya validasi JS di frontend)
if ($nama === '' || $metode === '' || !is_array($items) || count($items) === 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Data pesanan tidak lengkap.']);
    exit;
}

// Hitung ulang total di server (jangan percaya total kiriman dari client)
$total = 0;
foreach ($items as $it) {
    $total += (int) $it['harga'] * (int) $it['jumlah'];
}

// Generate ID transaksi unik, format: MTX + timestamp + random
$id_transaksi = 'MTX' . date('YmdHis') . rand(100, 999);

mysqli_begin_transaction($koneksi);

try {
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
    echo json_encode(['error' => 'Gagal menyimpan pesanan ke database.']);
}