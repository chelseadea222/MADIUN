<?php
require_once '../config/koneksi.php';

// PERBAIKAN: Mengganti id_booking menjadi id
$sql = "SELECT * FROM booking_penginapan ORDER BY id DESC";
$result = mysqli_query($koneksi, $sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Booking - MadiunTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 min-h-screen p-4 lg:p-10">

<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8 bg-white p-4 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-amber-100 text-amber-500 rounded-xl flex items-center justify-center text-xl">
                <i class="bi bi-house-door-fill"></i>
            </div>
            <h2 class="text-xl font-black text-slate-900">Riwayat Penginapan</h2>
        </div>
        <a href="booking.php" class="text-slate-500 hover:text-amber-500 transition font-bold text-sm bg-slate-50 px-4 py-2 rounded-xl">
            <i class="bi bi-arrow-left me-1"></i> Beranda
        </a>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex flex-col justify-between hover:shadow-lg transition-all duration-300">
                    
                    <div>
                        <div class="flex justify-between items-start mb-4">
                            <span class="bg-slate-100 text-[10px] font-bold text-slate-500 px-3 py-1.5 rounded-lg uppercase tracking-wider">
                                #BKG-<?= str_pad($row['id'], 4, '0', STR_PAD_LEFT) ?>
                            </span>
                            <span class="text-[10px] font-bold px-3 py-1.5 rounded-lg uppercase tracking-wider 
                                <?= ($row['status'] == 'Menunggu Pembayaran') ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600' ?>">
                                <?= htmlspecialchars($row['status']) ?>
                            </span>
                        </div>

                        <h3 class="font-bold text-slate-900 text-xl mb-1"><?= htmlspecialchars($row['nama_lengkap']) ?></h3>
                        <p class="text-sm text-slate-500 mb-4"><i class="bi bi-whatsapp me-2 text-green-500"></i><?= htmlspecialchars($row['no_hp']) ?></p>
                        
                        <div class="flex items-center gap-4 bg-slate-50 p-3 rounded-xl mb-4 border border-slate-100">
                            <div class="text-center px-3 border-r border-slate-200">
                                <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Tipe</p>
                                <p class="text-sm font-black text-slate-800"><?= htmlspecialchars($row['tipe_penginapan']) ?></p>
                            </div>
                            <div class="text-center px-3 border-r border-slate-200">
                                <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Malam</p>
                                <p class="text-sm font-black text-slate-800"><?= $row['durasi'] ?></p>
                            </div>
                            <div class="text-center px-3">
                                <p class="text-[10px] text-slate-400 uppercase font-bold mb-1">Check-in</p>
                                <p class="text-sm font-black text-amber-500"><?= date('d M Y', strtotime($row['tgl_checkin'])) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex justify-between items-end">
                        <div>
                            <p class="text-[10px] text-slate-400 mb-1">Dipesan pada <?= date('d M, H:i', strtotime($row['tanggal_pesan'])) ?></p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase">Total Bayar</p>
                        </div>
                        <span class="font-black text-xl text-slate-900">Rp <?= number_format($row['total_bayar'], 0, ',', '.') ?></span>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center py-24 bg-white rounded-[2.5rem] border border-slate-100 shadow-sm">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="bi bi-house-x text-3xl text-slate-300"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-2">Belum Ada Reservasi</h3>
            <p class="text-sm text-slate-500 mb-6">Anda belum pernah melakukan pemesanan penginapan.</p>
            <a href="booking.php" class="inline-block bg-amber-500 text-white font-bold py-3 px-6 rounded-xl hover:bg-amber-600 transition">Pesan Sekarang</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>