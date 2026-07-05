<?php
// verifikasi_tiket.php
// Dipanggil dari dashboard admin, misalnya lewat tombol/link:
//   <a href="verifikasi_tiket.php?id=<?= $row['id_transaksi'] ?>">Verifikasi</a>
// Tugasnya: tandai transaksi sebagai LUNAS setelah admin cek manual
// bukti transfer yang di-upload user (lihat kolom bukti_transfer di tabel
// pemesanan_tiket, hasil dari upload_bukti.php).

require_once 'koneksi.php';
$id = $_GET['id'] ?? '';

if ($id === '') {
    header('Location: dashboard_admin.php?pesan=id_tidak_valid');
    exit;
}

// Prepared statement supaya aman dari SQL Injection
// (query lama langsung menyisipkan $_GET['id'] ke SQL string — rawan disuntik)
$stmt = mysqli_prepare($koneksi, "UPDATE pemesanan_tiket SET status = 'Lunas' WHERE id_transaksi = ?");
mysqli_stmt_bind_param($stmt, 's', $id);

if (mysqli_stmt_execute($stmt) && mysqli_stmt_affected_rows($stmt) > 0) {
    header('Location: dashboard_admin.php?pesan=berhasil');
} else {
    header('Location: dashboard_admin.php?pesan=gagal');
}
exit;