<?php
require_once '../config/koneksi.php';

if (isset($_POST['submit_tiket'])) {
    $nama     = $_POST['nama'];
    $whatsapp = $_POST['whatsapp'];
    $kota     = $_POST['kota_asal'];
    $wisata   = isset($_POST['wisata']) ? implode(", ", $_POST['wisata']) : "Tidak memilih";
    $tanggal  = date('Y-m-d H:i:s');

    try {
        // Query untuk menyimpan data rencana trip kustom
        $sql = "INSERT INTO tiket_harian (nama, whatsapp, titik_kumpul, paket, tanggal, status) 
                VALUES (:nama, :whatsapp, :kota, :paket, :tanggal, 'Pending')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nama' => $nama,
            ':whatsapp' => $whatsapp,
            ':kota' => $kota,
            ':paket' => $wisata,
            ':tanggal' => $tanggal
        ]);

        echo "<script>alert('Rencana Trip Berhasil Disimpan!'); window.location='../pesan_tiket.php';</script>";
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>