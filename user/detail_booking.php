<?php
/**
 * File: homestay_madiun.php
 * Deskripsi: Menampilkan SEMUA data homestay Madiun (grid lengkap + pencarian)
 */
session_start();

// Ambil data dari sumber tunggal
require_once __DIR__ . '../homestay_madiun.php';

// FILTER PENCARIAN (opsional, lewat ?cari=...)
$cari = strtolower(trim($_GET['cari'] ?? ''));
$hasilHomestay = $homestay_madiun;
if ($cari !== '') {
    $hasilHomestay = array_filter($homestay_madiun, function ($item) use ($cari) {
        return strpos(strtolower($item['nama']), $cari) !== false
            || strpos(strtolower($item['jarak']), $cari) !== false
            || strpos(strtolower($item['desc']), $cari) !== false;
    });
}

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Semua Homestay - MadiunTrack</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config={theme:{extend:{colors:{teal:'#0e7490','teal-d':'#0c6374',orange:'#f97316','orange-d':'#ea6a0a'},fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}
</script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:'Plus Jakarta Sans',sans-serif;}
</style>
</head>
<body class="bg-gray-50 font-sans text-gray-800">

<header class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
    <a href="landing_user.php" class="flex items-center gap-2">
      <i class="fa-solid fa-arrow-left text-gray-400 text-sm"></i>
      <span class="font-extrabold text-[18px] text-gray-900">Madiun<span class="text-orange">Track</span></span>
    </a>
    <span class="text-sm font-semibold text-gray-500">Semua Homestay</span>
  </div>
</header>

<main class="max-w-7xl mx-auto px-5 py-10">

  <div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Semua Homestay</h1>
    <p class="text-sm text-gray-400 mt-1">Temukan <?= count($homestay_madiun) ?> penginapan nyaman & terbaik di Madiun</p>
  </div>

  <!-- Form Pencarian -->
  <form method="GET" action="" class="bg-white p-2 rounded-xl shadow-sm border border-gray-100 flex gap-2 max-w-md mb-10">
    <div class="flex items-center gap-2 px-3 flex-1">
      <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
      <input type="text" name="cari" value="<?= htmlspecialchars($_GET['cari'] ?? '') ?>" placeholder="Cari nama atau lokasi homestay..." class="w-full text-sm outline-none text-gray-700 py-2">
    </div>
    <button type="submit" class="bg-orange hover:bg-orange-d text-white px-5 py-2 rounded-lg text-sm font-bold transition">Cari</button>
  </form>

  <!-- Grid Semua Homestay -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    <?php foreach ($hasilHomestay as $h): ?>
      <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all group">
        <div class="relative h-40">
          <img src="<?= htmlspecialchars($h['img']) ?>" alt="<?= htmlspecialchars($h['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          <span class="absolute top-2.5 right-2.5 bg-amber-400 text-white text-[11px] font-bold px-2 py-0.5 rounded-full flex items-center gap-0.5 shadow">
            <i class="fa-solid fa-star text-[9px]"></i> <?= htmlspecialchars($h['rating']) ?>
          </span>
        </div>
        <div class="p-4">
          <h3 class="font-bold text-gray-800 text-sm mb-1"><?= htmlspecialchars($h['nama']) ?></h3>
          <p class="text-gray-400 text-xs flex items-center gap-1 mb-2">
            <i class="fa-solid fa-location-dot text-orange text-[10px]"></i>
            <?= htmlspecialchars($h['jarak']) ?>
          </p>
          <p class="text-gray-500 text-xs leading-relaxed mb-3 line-clamp-2">
            <?= htmlspecialchars($h['desc']) ?>
          </p>
          <p class="font-bold text-sm mb-3 text-teal">
            <?= formatRupiah($h['harga']) ?> <span class="text-gray-400 font-normal text-[11px]">/malam</span>
          </p>
          <a href="booking_homestay.php?id=<?= urlencode($h['id']) ?>" class="block w-full text-center bg-orange hover:bg-orange-d text-white text-xs font-bold py-2 rounded-lg transition">
            Booking Sekarang
          </a>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (count($hasilHomestay) === 0): ?>
      <p class="text-gray-400 text-sm col-span-full text-center py-16">Homestay tidak ditemukan untuk pencarian "<?= htmlspecialchars($cari) ?>".</p>
    <?php endif; ?>
  </div>

</main>

</body>
</html>