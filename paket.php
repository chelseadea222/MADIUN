<?php 
// Sertakan file koneksi database
require_once 'koneksi.php';?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Paket Wisata</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        .grid-container { display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px; }
        .card { background: white; border: 1px solid #ddd; padding: 20px; border-radius: 8px; width: 300px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .card h3 { margin-top: 0; color: #333; }
        .harga { color: #e74c3c; font-weight: bold; font-size: 1.2em; }
        .btn-detail { display: inline-block; padding: 10px 15px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-top: 15px; }
        .btn-detail:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <h2>Pilihan Paket Wisata Madiun</h2>
    <p>Pilih paket liburan terbaik untuk Anda!</p>

    <div class="grid-container">
        <?php
        // Mengambil semua data dari tabel paket_wisata
        $query = mysqli_query($koneksi, "SELECT * FROM paket_wisata ORDER BY id_paket DESC");
        
        while ($data = mysqli_fetch_array($query)) {
        ?>
            <div class="card">
                <h3><?= $data['nama_paket']; ?></h3>
                <p><?= substr($data['deskripsi'], 0, 50); ?>...</p> <p class="harga">Rp <?= number_format($data['harga_bundling'], 0, ',', '.'); ?></p>
                
                <a href="detail_paket.php?id=<?= $data['id_paket']; ?>" class="btn-detail">Lihat Detail</a>
            </div>
        <?php 
        } 
        ?>
    </div>

</body>
</html>