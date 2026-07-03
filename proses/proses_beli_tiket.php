<?php
// proses_beli_tiket.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/koneksi.php';

// Atur agar server merespons dengan format JSON yang dikenali JavaScript Fetch
header('Content-Type: application/json');

// Memaksa mysqli melempar exception jika ada error database agar masuk ke blok catch
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Pastikan member sudah login
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Sesi login tidak ditemukan. Silakan login ulang.']);
    exit;
}

try {
    // Ambil data kiriman dari JavaScript Fetch FormData
    $nama_pembeli = trim($_POST['nama'] ?? '');
    $metode       = trim($_POST['metode'] ?? '');
    $items        = json_decode($_POST['items'] ?? '[]', true);

    // Validasi data input
    if ($nama_pembeli === '' || !is_array($items) || count($items) === 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Data pemesanan tidak lengkap atau tidak valid.']);
        exit;
    }

    $total_bayar  = 0;
    $jumlah_orang = 0;
    $nama_dipilih = [];

    // Lakukan perulangan untuk menghitung total harga & jumlah tiket berdasarkan data dari kartu terpilih
    foreach ($items as $it) {
        $harga = (int)$it['harga'];
        $qty   = (int)$it['jumlah'];
        
        $total_bayar  += $harga * $qty;
        $jumlah_orang += $qty; // Menghitung akumulasi jumlah tiket masuk
        $nama_dipilih[] = $it['destinasi'];
    }

    // Menggabungkan destinasi pilihan menjadi satu baris kalimat (misal: "Kawah Bromo, Pasir Berbisik")
    $destinasi_final = implode(", ", $nama_dipilih); 
    
    // Siapkan data pendukung transaksi sesuai struktur tabel database Anda
    $id_transaksi = 'MTX' . date('YmdHis') . rand(100, 999);
    $tanggal      = date('Y-m-d H:i:s');
    $status       = 'Menunggu Pembayaran';

    // Query INSERT menggunakan Prepared Statement agar aman dan sesuai dengan nama kolom di image_8975c8.png
// Perbaikan bagian query SQL INSERT
// Pastikan variabel sudah terisi sebelum di-bind
$nama = trim($_POST['nama'] ?? ''); // Pastikan 'nama' sesuai dengan name di form HTML
$destinasi_string = implode(', ', array_column($items, 'destinasi')); 

$stmt = mysqli_prepare(
    $koneksi,
    "INSERT INTO pemesanan_tiket (id_transaksi, nama_pembeli, destinasi, total_bayar, status, tanggal_pesan) 
     VALUES (?, ?, ?, ?, 'Menunggu Pembayaran', NOW())"
);

// Pastikan urutan dan variabel di bawah ini sudah benar dan tidak kosong
mysqli_stmt_bind_param($stmt, 'sssi', $id_transaksi, $nama, $destinasi_string, $total_bayar);

    if (mysqli_stmt_execute($stmt)) {
        // Mengembalikan order_id sukses dalam bentuk JSON
        echo json_encode(['order_id' => $id_transaksi]);
    } else {
        throw new Exception("Gagal menyimpan data pesanan ke dalam database.");
    }

} catch (Exception $e) {
    // Jika ada error jaringan atau kolom database, tangkap di sini dan kirim balik pesan errornya ke modal alert
    http_response_code(500);
    echo json_encode([
        'error' => 'Database Error: ' . $e->getMessage()
    ]);
}
?>