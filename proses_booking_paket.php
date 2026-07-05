<?php
require_once 'koneksi.php';
// Cek apakah data dikirim dari form menggunakan metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Menangkap data dari form
    $id_paket = $_POST['id_paket'];
    $total_bayar = $_POST['total_bayar'];
    $nama_pembeli = mysqli_real_escape_string($koneksi, $_POST['nama_pembeli']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $tanggal_kunjungan = $_POST['tanggal_kunjungan'];

    // Query untuk menyimpan ke tabel transaksi
    // Perhatikan: id_destinasi diisi NULL karena ini adalah pembelian paket bundling
    $query = "INSERT INTO transaksi (nama_pembeli, no_hp, tanggal_kunjungan, id_paket, id_destinasi, total_bayar, status) 
              VALUES ('$nama_pembeli', '$no_hp', '$tanggal_kunjungan', '$id_paket', NULL, '$total_bayar', 'Pending')";

    $eksekusi = mysqli_query($koneksi, $query);

    if ($eksekusi) {
        // Jika berhasil disimpan
        echo "<script>
                alert('Berhasil! Booking paket wisata Anda telah disimpan. Silakan lakukan pembayaran.');
                window.location.href = 'paket.php'; // Atau arahkan ke halaman sukses/invoice
              </script>";
    } else {
        // Jika gagal disimpan
        echo "<script>
                alert('Gagal melakukan booking. Silakan coba lagi. Error: " . mysqli_error($koneksi) . "');
                window.history.back();
              </script>";
    }

} else {
    // Jika file ini diakses langsung tanpa lewat form
    echo "<script>window.location.href = 'paket.php';</script>";
}
?>