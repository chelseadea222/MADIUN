<?php
require_once '../config/koneksi.php';

// Cek apakah ada parameter 'id' di URL
if (!isset($_GET['id'])) {
    echo "<script>alert('Pilih paket terlebih dahulu!'); window.location='paket.php';</script>";
    exit;
}

$id_paket = $_GET['id'];

// Ambil data paket utama
$query_paket = mysqli_query($koneksi, "SELECT * FROM paket_wisata WHERE id_paket = '$id_paket'");
$paket = mysqli_fetch_array($query_paket);

// Jika paket tidak ditemukan
if (!$paket) {
    echo "<script>alert('Data paket tidak ditemukan!'); window.location='paket.php';</script>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Paket: <?= $paket['nama_paket']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        .detail-box { background: white; padding: 30px; border-radius: 8px; max-width: 600px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .harga { font-size: 1.5em; color: #e74c3c; font-weight: bold; margin: 15px 0; }
        .destinasi-list { background: #f1f1f1; padding: 15px; border-radius: 5px; }
        .btn-booking { display: inline-block; padding: 12px 20px; background-color: #28a745; color: white; text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 1.1em; width: 100%; text-align: center; box-sizing: border-box; margin-top: 20px;}
        .btn-booking:hover { background-color: #218838; }
        .btn-kembali { color: #666; text-decoration: none; display: inline-block; margin-bottom: 20px; }
    </style>
</head>
<body>

    <a href="paket.php" class="btn-kembali">&larr; Kembali ke Daftar Paket</a>

    <div class="detail-box">
        <h2><?= $paket['nama_paket']; ?></h2>
        <p><?= $paket['deskripsi']; ?></p>
        
        <div class="destinasi-list">
            <strong>Destinasi yang dikunjungi:</strong>
            <ul>
                <?php
                // Ambil daftar destinasi yang berelasi dengan paket ini
                // Asumsi: tabel destinasi bernama 'destinasi' dan kolom namanya 'nama_destinasi'
                $query_destinasi = mysqli_query($koneksi, "
                    SELECT d.nama_destinasi 
                    FROM detail_paket dp 
                    JOIN destinasi d ON dp.id_destinasi = d.id_destinasi 
                    WHERE dp.id_paket = '$id_paket'
                ");

                if (mysqli_num_rows($query_destinasi) > 0) {
                    while ($dest = mysqli_fetch_array($query_destinasi)) {
                        echo "<li>" . $dest['nama_destinasi'] . "</li>";
                    }
                } else {
                    echo "<li><i>Belum ada destinasi yang ditambahkan ke paket ini.</i></li>";
                }
                ?>
            </ul>
        </div>

        <div class="harga">Rp <?= number_format($paket['harga_bundling'], 0, ',', '.'); ?></div>

        <a href="booking_paket.php?id_paket=<?= $paket['id_paket']; ?>" class="btn-booking">Pesan Paket Ini Sekarang</a>
    </div>

</body>
</html>