<?php
/**
 * proses_booking.php
 * Menerima data dari form di booking.php (fetch POST JSON), menyimpan ke
 * database, lalu mengembalikan JSON berisi ke mana pengguna harus diarahkan:
 *   - metode "online"   -> bayar.php?id=...
 *   - metode "ditempat" -> riwayat_booking.php (status: bayar di tempat)
 *
 * ------------------------------------------------------------------
 * GANTI DI SINI kalau nama tabel/kolom database kamu berbeda:
 * ------------------------------------------------------------------
 */
$TABEL = 'booking';
$KOLOM = [
    'id'              => 'id',
    'kode_booking'    => 'kode_booking',
    'nama_lengkap'    => 'nama_lengkap',
    'whatsapp'        => 'whatsapp',
    'email'           => 'email',
    'homestay_id'     => 'homestay_id',
    'homestay_nama'   => 'homestay_nama',
    'tanggal_checkin' => 'tanggal_checkin',
    'durasi_malam'    => 'durasi_malam',
    'total_bayar'     => 'total_bayar',
    'metode_bayar'    => 'metode_bayar',
    'status'          => 'status',
    'created_at'      => 'created_at',
];
// ------------------------------------------------------------------

session_start();
header('Content-Type: application/json');

function jsonResponse($ok, $data = [], $message = '') {
    echo json_encode(array_merge(['ok' => $ok, 'message' => $message], $data));
    exit;
}

// Tangkap error fatal (misal salah path require) supaya tetap balas JSON,
// bukan halaman error PHP mentah yang bikin fetch() di browser gagal parse.
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
    jsonResponse(false, [], "PHP error: $errstr (di $errfile baris $errline)");
});

if (!file_exists('../config/koneksi.php')) {
    jsonResponse(false, [], 'File ../config/koneksi.php tidak ditemukan. Cek lagi struktur folder / path require.');
}
require_once '../config/koneksi.php';

if (!file_exists('homestay_madiun.php')) {
    jsonResponse(false, [], 'File homestay_madiun.php tidak ditemukan di folder yang sama dengan proses_booking.php.');
}
require_once 'homestay_madiun.php'; // isi $homestay_madiun, untuk validasi harga di server

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    jsonResponse(false, [], 'Metode request tidak valid.');
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    jsonResponse(false, [], 'Data tidak valid.');
}

// ------------------------------------------------------------------
// 1. VALIDASI INPUT
// ------------------------------------------------------------------
$nama       = trim($input['nama_lengkap'] ?? '');
$wa         = trim($input['whatsapp'] ?? '');
$email      = trim($input['email'] ?? '');
$tanggal    = trim($input['tanggal_checkin'] ?? '');
$homestayId = trim($input['homestay_id'] ?? '');
$durasi     = max(1, (int)($input['durasi_malam'] ?? 1));
$metode     = ($input['metode_bayar'] ?? 'online') === 'ditempat' ? 'ditempat' : 'online';

if ($nama === '' || $wa === '' || $tanggal === '' || $homestayId === '') {
    jsonResponse(false, [], 'Mohon lengkapi semua data yang wajib diisi.');
}

// Cari homestay yang dipilih (harga dihitung ulang di server, JANGAN percaya angka dari client)
$homestay = null;
foreach ($homestay_madiun as $h) {
    if ($h['id'] === $homestayId) { $homestay = $h; break; }
}
if (!$homestay) {
    jsonResponse(false, [], 'Homestay tidak ditemukan.');
}

$totalBayar = (int)$homestay['harga'] * $durasi;
$kodeBooking = 'MTK-' . date('ymd') . '-' . strtoupper(substr(uniqid(), -5));
$statusAwal = $metode === 'ditempat' ? 'bayar_ditempat' : 'menunggu_pembayaran';

// ------------------------------------------------------------------
// 2. SIMPAN KE DATABASE
// ------------------------------------------------------------------
$sql = "INSERT INTO `{$TABEL}`
    (`{$KOLOM['kode_booking']}`, `{$KOLOM['nama_lengkap']}`, `{$KOLOM['whatsapp']}`, `{$KOLOM['email']}`,
     `{$KOLOM['homestay_id']}`, `{$KOLOM['homestay_nama']}`, `{$KOLOM['tanggal_checkin']}`,
     `{$KOLOM['durasi_malam']}`, `{$KOLOM['total_bayar']}`, `{$KOLOM['metode_bayar']}`, `{$KOLOM['status']}`)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = mysqli_prepare($koneksi, $sql);
if (!$stmt) {
    // Kalau gagal di sini, kemungkinan besar nama tabel/kolom di atas belum
    // cocok dengan database kamu. Cek pesan error dan sesuaikan $TABEL/$KOLOM.
    jsonResponse(false, [], 'Gagal menyiapkan query: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param(
    $stmt,
    'ssssssssiss',
    $kodeBooking,
    $nama,
    $wa,
    $email,
    $homestayId,
    $homestay['nama'],
    $tanggal,
    $durasi,
    $totalBayar,
    $metode,
    $statusAwal
);

if (!mysqli_stmt_execute($stmt)) {
    jsonResponse(false, [], 'Gagal menyimpan booking: ' . mysqli_stmt_error($stmt));
}

$bookingId = mysqli_insert_id($koneksi);
mysqli_stmt_close($stmt);

// ------------------------------------------------------------------
// 3. RESPON: kemana harus redirect
// ------------------------------------------------------------------
if ($metode === 'online') {
    jsonResponse(true, [
        'booking_id'   => $bookingId,
        'kode_booking' => $kodeBooking,
        'redirect'     => 'bayar.php?id=' . $bookingId,
    ], 'Booking dibuat, lanjut ke pembayaran.');
} else {
    jsonResponse(true, [
        'booking_id'   => $bookingId,
        'kode_booking' => $kodeBooking,
        'redirect'     => 'riwayat_booking.php?sukses=ditempat&kode=' . urlencode($kodeBooking),
    ], 'Booking dibuat, bayar di tempat saat check-in.');
}