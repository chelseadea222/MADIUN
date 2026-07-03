<?php
session_start();
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    
    // 1. Proses Upload File
    $target_dir = "../uploads/bukti/"; // Pastikan folder ini ada dan bisa ditulisi
    if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
    
    $file_name = time() . '_' . basename($_FILES["bukti"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["bukti"]["tmp_name"], $target_file)) {
        
        // 2. Update Database
        $stmt = mysqli_prepare($koneksi, "UPDATE pemesanan_tiket SET bukti_pembayaran = ?, status = 'Diproses' WHERE id_transaksi = ?");
        mysqli_stmt_bind_param($stmt, 'ss', $file_name, $order_id);
        
        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Bukti pembayaran berhasil diunggah!'); window.location.href='riwayat_pesanan.php';</script>";
        } else {
            echo "Error database: " . mysqli_error($koneksi);
        }
    } else {
        echo "Gagal mengunggah file.";
    }
} else {
    header('Location: riwayat_pesanan.php');
}
?>