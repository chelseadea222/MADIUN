<?php
// upload_bukti.php
// Menerima submit form dari konfirmasi_pembayaran.php: file bukti transfer + order_id.
// Tugasnya: validasi file, simpan ke folder uploads/bukti/, lalu UPDATE
// baris di pemesanan_tiket (bukti_pembayaran + status jadi 'Diproses').

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
$stmt = mysqli_prepare($koneksi, "SELECT id_transaksi, bukti_pembayaran FROM pemesanan_tiket WHERE id_transaksi = ?");
mysqli_stmt_bind_param($stmt, 's', $order_id);
mysqli_stmt_execute($stmt);
$order = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$order) {
    die('Pesanan tidak ditemukan. <a href="beli_tiket.php">Kembali</a>');
}

if ($order['bukti_pembayaran']) {
    header('Location: riwayat_pesanan.php');
    exit;
}

// --- SIMPAN FILE KE FOLDER uploads/bukti/ ---
// Sesuaikan path ini dengan struktur folder project Anda.
// Asumsi: file ini ada di folder yang sejajar dengan folder "uploads" di root project.
$uploadDir = '../uploads/bukti/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$filename = $order_id . '_' . time() . '.' . $ext;
$targetPath = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
    die('Gagal menyimpan file di server. <a href="konfirmasi_pembayaran.php?order_id=' . urlencode($order_id) . '">Coba lagi</a>');
}

// Path relatif yang disimpan ke DB, dipakai juga untuk <img src="..."> di halaman lain
$relativePath = 'uploads/bukti/' . $filename;

// --- UPDATE STATUS PESANAN ---
$update = mysqli_prepare(
    $koneksi,
    "UPDATE pemesanan_tiket SET bukti_pembayaran = ?, status = 'Diproses' WHERE id_transaksi = ?"
);
mysqli_stmt_bind_param($update, 'ss', $relativePath, $order_id);
mysqli_stmt_execute($update);

// Selesai — arahkan ke riwayat pemesanan, tempat status "Diproses" akan terlihat
header('Location: riwayat_pesanan.php');
exit;