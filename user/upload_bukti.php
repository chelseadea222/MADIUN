<?php
// upload_bukti.php
// Menerima submit form dari konfirmasi_pembayaran.php: file bukti transfer + order_id.
// Tugasnya: validasi file, simpan ke folder uploads/bukti/, lalu UPDATE
// baris di pemesanan_tiket (bukti_transfer + status jadi 'Diproses').

require_once '../config/koneksi.php';

$order_id = $_POST['order_id'] ?? '';

if ($order_id === '' || !isset($_FILES['bukti']) || $_FILES['bukti']['error'] !== UPLOAD_ERR_OK) {
    die('Data tidak lengkap atau upload gagal. <a href="beli_tiket.php">Kembali</a>');
}

$file = $_FILES['bukti'];

// Validasi tipe & ukuran file di sisi server (jangan cuma andalkan validasi JS)
$allowedTypes = ['image/jpeg', 'image/png'];
if (!in_array($file['type'], $allowedTypes)) {
    die('Format file tidak didukung. Gunakan JPG atau PNG. <a href="konfirmasi_pembayaran.php?order_id=' . urlencode($order_id) . '">Kembali</a>');
}
if ($file['size'] > 5 * 1024 * 1024) {
    die('Ukuran file terlalu besar (maksimal 5MB). <a href="konfirmasi_pembayaran.php?order_id=' . urlencode($order_id) . '">Kembali</a>');
}

// Pastikan order_id-nya memang ada dan belum pernah upload bukti sebelumnya
$stmt = mysqli_prepare($koneksi, "SELECT id_transaksi, bukti_transfer FROM pemesanan_tiket WHERE id_transaksi = ?");
mysqli_stmt_bind_param($stmt, 's', $order_id);
mysqli_stmt_execute($stmt);
$order = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$order) {
    die('Pesanan tidak ditemukan.');
}
if ($order['bukti_transfer']) {
    header('Location: riwayat_pesanan.php');
    exit;
}

// Simpan file ke folder uploads/bukti/ dengan nama unik berbasis order_id
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$filename = $order_id . '_' . time() . '.' . $ext;
$targetDir = __DIR__ . '/uploads/bukti/';
$targetPath = $targetDir . $filename;

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0755, true);
}

if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    die('Gagal menyimpan file ke server.');
}

// Path relatif yang disimpan di database (untuk ditampilkan lagi nanti kalau perlu)
$relativePath = 'uploads/bukti/' . $filename;

$update = mysqli_prepare(
    $koneksi,
    "UPDATE pemesanan_tiket SET bukti_transfer = ?, status = 'Diproses' WHERE id_transaksi = ?"
);
mysqli_stmt_bind_param($update, 'ss', $relativePath, $order_id);
mysqli_stmt_execute($update);

// Selesai — arahkan ke riwayat pemesanan, tempat status "Diproses" akan terlihat
header('Location: riwayat_pesanan.php');
exit;