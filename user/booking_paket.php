<?php require_once '../config/koneksi.php'; $id = $_GET['id']; ?>

if (!isset($_GET['id_paket'])) {
    echo "<script>alert('Pilih paket yang ingin dibooking!'); window.location='paket.php';</script>";
    exit;
}

$id_paket = $_GET['id_paket'];
$query = mysqli_query($koneksi, "SELECT * FROM paket_wisata WHERE id_paket = '$id_paket'");
$paket = mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Booking Paket: <?= $paket['nama_paket']; ?></title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; }
        .form-container { background: white; padding: 30px; border-radius: 8px; max-width: 500px; margin: auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .info-paket { background: #e9ecef; padding: 15px; border-radius: 5px; margin-bottom: 20px; text-align: center; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        .btn-submit { width: 100%; padding: 12px; background-color: #007bff; color: white; border: none; border-radius: 5px; font-size: 1.1em; cursor: pointer; }
        .btn-submit:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2 style="text-align: center; margin-top:0;">Form Pemesanan</h2>
        
        <div class="info-paket">
            <strong>Paket:</strong> <?= $paket['nama_paket']; ?><br>
            <strong style="color: #e74c3c; font-size: 1.2em;">Total: Rp <?= number_format($paket['harga_bundling'], 0, ',', '.'); ?></strong>
        </div>

        <form action="proses_booking_paket.php" method="POST">
            <input type="hidden" name="id_paket" value="<?= $paket['id_paket']; ?>">
            <input type="hidden" name="total_bayar" value="<?= $paket['harga_bundling']; ?>">

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_pembeli" placeholder="Masukkan nama Anda" required>
            </div>

            <div class="form-group">
                <label>Nomor HP/WhatsApp</label>
                <input type="number" name="no_hp" placeholder="Contoh: 08123456789" required>
            </div>

            <div class="form-group">
                <label>Tanggal Kunjungan</label>
                <input type="date" name="tanggal_kunjungan" required>
            </div>

            <button type="submit" class="btn-submit">Selesaikan Pemesanan</button>
        </form>
    </div>

</body>
</html>