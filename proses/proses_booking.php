<?php
require_once '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memproses Booking...</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        /* Kustomisasi font SweetAlert agar senada dengan desain kita */
        div:where(.swal2-container) { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body>

<?php
if (isset($_POST['submit_booking'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $tipe = mysqli_real_escape_string($koneksi, $_POST['tipe_penginapan']);
    $tgl_in = mysqli_real_escape_string($koneksi, $_POST['tgl_checkin']);
    $durasi = intval($_POST['durasi']);
    $total = intval($_POST['total_bayar']);

    $query = "INSERT INTO booking_penginapan (nama_lengkap, no_hp, tipe_penginapan, tgl_checkin, durasi, total_bayar) 
              VALUES ('$nama', '$no_hp', '$tipe', '$tgl_in', '$durasi', '$total')";

    if (mysqli_query($koneksi, $query)) {
        // Tampilkan Pop-up Sukses yang Cantik
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Booking Berhasil!',
                text: 'Reservasi penginapan Anda telah masuk ke sistem kami.',
                confirmButtonColor: '#f59e0b',
                confirmButtonText: 'Lihat Riwayat Pesanan',
                allowOutsideClick: false,
                customClass: {
                    popup: 'rounded-3xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'riwayat_booking.php';
                }
            });
        </script>";
    } else {
        // Tampilkan Pop-up Error jika gagal masuk database
        $error = mysqli_error($koneksi);
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Oops... Gagal!',
                text: 'Terjadi kesalahan pada sistem: $error',
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Kembali',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.back();
                }
            });
        </script>";
    }
} else {
    // Jika ada yang mencoba akses halaman ini langsung tanpa lewat form
    header("Location: booking.php");
    exit;
}
?>

</body>
</html>