<?php
/**
 * File: detail_destinasi.php
 * Deskripsi: Menampilkan SEMUA data destinasi wisata Madiun (grid lengkap + pencarian)
 */
session_start();

// 1. DATA DESTINASI WISATA (Statis)
$wisata_madiun = [
    ["nama" => "Pahlawan Street Center (PSC)", "lokasi" => "Kartoharjo", "img" => "https://assets-a1.kompasiana.com/items/album/2024/12/12/img-0113-675a6be334777c25d2352533.jpeg", "desc" => "Malioboro-nya Kota Madiun yang dihiasi replika ikon dunia ikonik seperti Patung Merlion dan Menara Eiffel."],
    ["nama" => "Taman Sumber Umis", "lokasi" => "Manguharjo", "img" => "https://lh3.googleusercontent.com/gps-cs-s/APNQkAH8uUwWANvaY_KcCc_DOCFanpBPe5Sn2-35TARv1y8vM2jR3gkRkGiqO3fMKHXbccYp-6BUTWPF5vIggnb5Ami70_Cp3RGjqIXl3AGoR0kRWbG6oKpkYc4NGZXu3vlgmQLXR_4U=s680-w680-h510-rw", "desc" => "Taman kota indah di pusat Madiun yang memiliki replika Ka'bah dengan suasana malam yang megah."],
    ["nama" => "Alun-Alun Kota Madiun", "lokasi" => "Manguharjo", "img" => "https://i.pinimg.com/736x/38/0e/4e/380e4ee1282c408ecc7ea699bbfed5f7.jpg", "desc" => "Pusat aktivitas warga dengan ruang terbuka hijau luas, Masjid Agung, dan dikelilingi jajaran kuliner lokal."],
    ["nama" => "Taman Bantaran Kali Madiun", "lokasi" => "Manguharjo", "img" => "https://i.pinimg.com/736x/48/d3/1c/48d31cfe40c5fbbf57aae4657076c328.jpg", "desc" => "Spot santai di pinggir sungai dengan fasilitas olahraga, gazebo, jembatan gantung, dan pemandangan asri."],
    ["nama" => "Monumen Kresek", "lokasi" => "Wungu", "img" => "https://i.pinimg.com/736x/e1/7f/3d/e17f3d23eb9e1ebaf93a0a110e042856.jpg", "desc" => "Monumen bersejarah yang penuh dengan nilai edukasi perjuangan bangsa, dikelilingi taman rindang yang tenang."],
    ["nama" => "Madiun Umbul Square", "lokasi" => "Dolopo", "img" => "https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=800", "desc" => "Taman hiburan keluarga terpadu yang menyediakan wahana permainan air, kincir ria, dan mini zoo satwa."],
    ["nama" => "Taman Trembesi", "lokasi" => "Kartoharjo", "img" => "https://static.promediateknologi.id/crop/0x0:0x0/1200x0/webp/photo/p1/867/2024/01/27/Picsart_24-01-27_20-24-31-261-729900772.jpg", "desc" => "Kawasan hutan kota mini dengan jajaran pohon trembesi raksasa yang sejuk, rindang, dan alami."],
    ["nama" => "Waduk Bening Widas", "lokasi" => "Saradan", "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQPN1tWAOQZVv-zr1HOZUONGea7I93Af8RVg&s", "desc" => "Wisata air waduk yang menawarkan panorama alam pegunungan, spot memancing, dan bumi perkemahan."],
    ["nama" => "Desa Wisata Brumbun", "lokasi" => "Wungu", "img" => "https://images.unsplash.com/photo-1530866495561-507c9faab2ed?q=80&w=800", "desc" => "Destinasi wisata alam pedesaan lereng Wilis yang menawarkan aktivitas river tubing menantang."],
    ["nama" => "Ngrowo Bening Edupark", "lokasi" => "Taman", "img" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRV1kaTQ4BcEAhSbmwe6UaDPV17HGbXQ5MUKw&s", "desc" => "Taman edukasi agrowisata perkotaan, tempat belajar menanam sayur hidroponik, peternakan, dan bersantai."],
    ["nama" => "Hutan Pinus NONGKO IJO", "lokasi" => "Kare", "img" => "https://indonesiatraveler.id/wp-content/uploads/2020/10/Madiun-Nongko-Ijo3-e1602582835404.jpg", "desc" => "Pesona air terjun tersembunyi di lereng Gunung Wilis yang menyuguhkan udara sejuk dan air super jernih."]
];

// 2. FILTER PENCARIAN (opsional, lewat ?cari=...)
$cari = strtolower(trim($_GET['cari'] ?? ''));
$hasilWisata = $wisata_madiun;
if ($cari !== '') {
    $hasilWisata = array_filter($wisata_madiun, function ($item) use ($cari) {
        return strpos(strtolower($item['nama']), $cari) !== false
            || strpos(strtolower($item['lokasi']), $cari) !== false
            || strpos(strtolower($item['desc']), $cari) !== false;
    });
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Semua Destinasi - MadiunTrack</title>
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
    <a href="index.php" class="flex items-center gap-2">
      <i class="fa-solid fa-arrow-left text-gray-400 text-sm"></i>
      <span class="font-extrabold text-[18px] text-gray-900">Madiun<span class="text-orange">Track</span></span>
    </a>
    <span class="text-sm font-semibold text-gray-500">Semua Destinasi</span>
  </div>
</header>

<main class="max-w-7xl mx-auto px-5 py-10">

  <div class="mb-8">
    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900">Semua Destinasi Wisata</h1>
    <p class="text-sm text-gray-400 mt-1">Jelajahi <?= count($wisata_madiun) ?> destinasi terbaik di Madiun & sekitarnya</p>
  </div>

  <!-- Form Pencarian -->
  <form method="GET" action="" class="bg-white p-2 rounded-xl shadow-sm border border-gray-100 flex gap-2 max-w-md mb-10">
    <div class="flex items-center gap-2 px-3 flex-1">
      <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
      <input type="text" name="cari" value="<?= htmlspecialchars($_GET['cari'] ?? '') ?>" placeholder="Cari nama atau lokasi destinasi..." class="w-full text-sm outline-none text-gray-700 py-2">
    </div>
    <button type="submit" class="bg-orange hover:bg-orange-d text-white px-5 py-2 rounded-lg text-sm font-bold transition">Cari</button>
  </form>

  <!-- Grid Semua Destinasi -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
    <?php foreach ($hasilWisata as $d): ?>
      <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all group">
        <div class="relative h-40">
          <img src="<?= htmlspecialchars($d['img']) ?>" alt="<?= htmlspecialchars($d['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        </div>
        <div class="p-4">
          <h3 class="font-bold text-gray-800 text-sm mb-1"><?= htmlspecialchars($d['nama']) ?></h3>
          <p class="text-gray-400 text-xs flex items-center gap-1 mb-2">
            <i class="fa-solid fa-location-dot text-orange text-[10px]"></i>
            <?= htmlspecialchars($d['lokasi']) ?>
          </p>
          <p class="text-gray-500 text-xs leading-relaxed mb-4 line-clamp-2">
            <?= htmlspecialchars($d['desc']) ?>
          </p>
          <div class="flex gap-2">
            <a href="informasi_destinasi.php?item=<?= urlencode($d['nama']) ?>" class="flex-1 text-center border border-gray-200 hover:border-teal hover:text-teal text-gray-500 text-xs font-semibold py-2 rounded-lg transition">Detail</a>
            <a href="beli_tiket.php?item=<?= urlencode($d['nama']) ?>" class="flex-1 text-center bg-orange hover:bg-orange-d text-white text-xs font-bold py-2 rounded-lg transition">Tiket</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (count($hasilWisata) === 0): ?>
      <p class="text-gray-400 text-sm col-span-full text-center py-16">Destinasi tidak ditemukan untuk pencarian "<?= htmlspecialchars($cari) ?>".</p>
    <?php endif; ?>
  </div>

</main>

</body>
</html>