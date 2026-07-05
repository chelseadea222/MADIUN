<?php
/**
 * File: landingpage.php
 * Deskripsi: Landing Page Terpadu MadiunTrack 
 * Fitur: Navbar Custom, Quick Menu, Destinasi Kotak Panjang, Estimasi & Kuliner Scroll, Paket Bundling
 */
session_start();

// 1. KONEKSI DATABASE (WAJIB AKTIF UNTUK MEMUNCULKAN PAKET BUNDLING)
require_once 'koneksi.php';
// 2. DATA DESTINASI WISATA (Statis)
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

// 4. DATA HOMESTAY
$homestay_madiun = [
    // --- Data yang sudah ada ---
    ["nama" => "Homestay Wilis Indah",   "jarak" => "2 km dari PSC",         "rating" => "4.8", "harga" => "Rp 150.000", "img" => "https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=800"],
    ["nama" => "Villa Lereng Wilis",     "jarak" => "15 km dari pusat kota", "rating" => "4.9", "harga" => "Rp 300.000", "img" => "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=800"],
    ["nama" => "Penginapan Madiun Raya", "jarak" => "0.5 km dari Alun-Alun", "rating" => "4.6", "harga" => "Rp 200.000", "img" => "https://images.unsplash.com/photo-1578683010236-d716f9a3f461?q=80&w=800"],
    
    // --- Data tambahan hotel/penginapan di Madiun ---
    ["nama" => "Aston Madiun Hotel",     "jarak" => "3 km dari PSC",         "rating" => "4.7", "harga" => "Rp 650.000", "img" => "https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=800"],
    ["nama" => "The Sun Hotel Madiun",   "jarak" => "1 km dari Stasiun",     "rating" => "4.5", "harga" => "Rp 450.000", "img" => "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=800"],
    ["nama" => "Favehotel Madiun",       "jarak" => "1.5 km dari PSC",       "rating" => "4.4", "harga" => "Rp 400.000", "img" => "https://images.unsplash.com/photo-1590490360177-40292795e14d?q=80&w=800"],
    ["nama" => "Hotel Merdeka Madiun",   "jarak" => "0.8 km dari PSC",       "rating" => "4.3", "harga" => "Rp 350.000", "img" => "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=800"],
    ["nama" => "Amaris Hotel Madiun",    "jarak" => "1.2 km dari PSC",       "rating" => "4.5", "harga" => "Rp 380.000", "img" => "https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=800"],
    ["nama" => "Hotel Setia Budi",       "jarak" => "0.5 km dari Stasiun",   "rating" => "4.2", "harga" => "Rp 250.000", "img" => "https://images.unsplash.com/photo-1551882547-ff40c63fe56b?q=80&w=800"]
];

$cari = strtolower(trim($_GET['cari'] ?? ''));

// Filter Wisata
$hasilWisata = $wisata_madiun;
if($cari != ''){
    $hasilWisata = array_filter($wisata_madiun, function($item) use ($cari){
        return strpos(strtolower($item['nama']), $cari) !== false
            || strpos(strtolower($item['lokasi']), $cari) !== false
            || strpos(strtolower($item['desc']), $cari) !== false;
    });
}

// Filter Homestay
$hasilHomestay = $homestay_madiun;
if($cari != ''){
    $hasilHomestay = array_filter($homestay_madiun, function($item) use ($cari){
        return strpos(strtolower($item['nama']), $cari) !== false
            || strpos(strtolower($item['jarak']), $cari) !== false;
    });
}

// 5. DATA FOOTER
$nav_footer  = ["Beranda", "Destinasi Wisata", "Booking Tiket", "Homestay", "Peta Wisata"];
$info_footer = ["Tentang Kami", "Syarat & Ketentuan", "Kebijakan Privasi", "FAQ", "Blog Wisata"];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>MadiunTrack – Jelajahi Keindahan Madiun</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config={theme:{extend:{colors:{teal:'#0e7490','teal-d':'#0c6374',orange:'#f97316','orange-d':'#ea6a0a'},fontFamily:{sans:['"Plus Jakarta Sans"','sans-serif']}}}}
</script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
body{font-family:'Plus Jakarta Sans',sans-serif;}
.hero-grad{background:linear-gradient(90deg,rgba(0,0,0,.80) 0%,rgba(0,0,0,.55) 50%,rgba(0,0,0,.10) 100%);}
.active-nav{color:#f97316;border-bottom:2.5px solid #f97316;padding-bottom:2px;}
.icon-blue{background:linear-gradient(135deg,#1d4ed8,#3b82f6);}
.icon-orange{background:linear-gradient(135deg,#ea580c,#f97316);}
.icon-purple{background:linear-gradient(135deg,#7c3aed,#a78bfa);}
.icon-green{background:linear-gradient(135deg,#15803d,#22c55e);}
.stat-bg{background:linear-gradient(135deg,#1e3a8a,#2563eb);}
.scrollbar-hide{-ms-overflow-style:none;scrollbar-width:none;}
.scrollbar-hide::-webkit-scrollbar{display:none;}
</style>
</head>
<body class="bg-white font-sans text-gray-800">
 
<header class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm">
  <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
    <a href="#" class="flex items-center gap-2 flex-shrink-0">
      <i class="fa-solid fa-location-dot text-orange text-xl"></i>
      <div class="leading-none">
        <div><span class="font-extrabold text-[18px] text-gray-900">Madiun</span><span class="font-extrabold text-[18px] text-orange">Track</span></div>
        <p class="text-[10px] text-gray-400 font-medium -mt-0.5">Jelajahi Keindahan Madiun</p>
      </div>
    </a>
 
    <nav class="hidden md:flex items-center gap-5 ml-24">      
      <a href="#" class="active-nav text-sm font-semibold">Beranda</a>
      <a href="#destinasi" class="text-sm font-semibold text-gray-500 hover:text-orange transition">Destinasi</a>
      <a href="#bundling"  class="text-sm font-semibold text-gray-500 hover:text-orange transition">Paket Bundling</a>
      <a href="#homestay"  class="text-sm font-semibold text-gray-500 hover:text-orange transition">Homestay</a>
      <a href="#peta"      class="text-sm font-semibold text-gray-500 hover:text-orange transition">Peta Wisata</a>
    </nav>
 
    <div class="flex items-center gap-3 ml-auto">
      <button class="hidden md:block text-gray-300 hover:text-orange transition">
        <i class="fa-regular fa-heart text-lg"></i>
      </button>
      <a href="register.php" class="bg-teal hover:bg-teal-d text-white text-sm font-bold px-5 py-2 rounded-lg transition whitespace-nowrap">
        Masuk / Daftar
      </a>
      <button id="hbg" class="md:hidden text-gray-600 text-xl">
        <i class="fa-solid fa-bars"></i>
      </button>
    </div>
  </div>

  <div id="mob" class="hidden bg-white border-t border-gray-100 px-5 pb-4">
    <a href="#" class="block py-2 text-sm font-semibold text-orange">Beranda</a>
    <a href="#destinasi" class="block py-2 text-sm font-semibold text-gray-600 hover:text-orange">Destinasi</a>
    <a href="#bundling"  class="block py-2 text-sm font-semibold text-gray-600 hover:text-orange">Paket Bundling</a>
    <a href="#homestay"  class="block py-2 text-sm font-semibold text-gray-600 hover:text-orange">Homestay</a>
    <a href="#peta"      class="block py-2 text-sm font-semibold text-gray-600 hover:text-orange">Peta Wisata</a>
  </div>
</header>
 
<section class="relative overflow-hidden flex items-center" style="min-height:500px;">
  <!-- Gambar Background tetap memenuhi layar -->
  <img src="https://images.unsplash.com/photo-1549880338-65ddcdfd017b?w=1600&h=620&fit=crop" alt="Madiun" class="absolute inset-0 w-full h-full object-cover">
  <div class="hero-grad absolute inset-0"></div>
 
  <!-- Container ini disamakan dengan container section lain: max-w-7xl mx-auto px-5 -->
  <div class="relative z-10 max-w-7xl mx-auto px-5 w-full py-12">
    
    <!-- Bagian teks di sini akan otomatis sejajar dengan elemen di bawahnya -->
    <div class="max-w-xl">
      <h1 class="font-extrabold text-white leading-[1.1] text-4xl md:text-5xl">Temukan</h1>
      <h1 class="font-extrabold text-orange italic leading-[1.1] text-4xl md:text-5xl">Keindahan</h1>
      <h1 class="font-extrabold text-white leading-[1.1] mb-5 text-4xl md:text-5xl">Wisata Madiun</h1>
 
      <p class="text-white/90 text-sm leading-relaxed mb-6 max-w-sm">
        Jelajahi destinasi terbaik, pesan tiket, temukan homestay nyaman dan rencanakan perjalananmu sekarang!
      </p>

      <!-- Form Pencarian -->
      <form method="GET" action="" class="bg-white p-2 rounded-xl shadow-lg flex flex-col sm:flex-row gap-2 max-w-md">
        <div class="flex items-center gap-2 px-3 flex-1">
            <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
            <input type="text" name="cari" value="<?= htmlspecialchars($_GET['cari'] ?? '') ?>" placeholder="Cari destinasi atau homestay..." class="w-full text-sm outline-none text-gray-700 py-2">
        </div>
        <div class="flex gap-1">
            <button type="submit" class="bg-orange hover:bg-orange-d text-white px-5 py-2 rounded-lg text-sm font-bold transition flex-1 sm:flex-initial">Cari</button>
        </div>
      </form>
    </div>
    
  </div>
</section>
 
<!-- Perbaikan Quick Menu menjadi 3 kolom agar "Beli Tiket" bisa masuk -->
<section class="bg-white py-12 border-b border-gray-100">
  <div class="max-w-7xl mx-auto px-5">
    <!-- Grid diubah menjadi 5 kolom agar semuanya lurus dalam satu baris -->
    <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-6">
    <!-- 1. Destinasi Wisata -->
      <a href="detail_destinasi.php" class="flex items-start gap-4 group cursor-pointer">
        <div class="icon-blue w-[54px] h-[54px] rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
          <i class="fa-solid fa-map-marked-alt text-white text-xl"></i>
        </div>
        <div>
          <p class="font-bold text-gray-800 text-sm">Destinasi Wisata</p>
          <p class="text-gray-400 text-xs mt-0.5 leading-snug">Jelajahi tempat terbaik di Madiun</p>
          <p class="text-teal text-xs font-semibold mt-2 group-hover:text-orange transition">Lihat Destinasi &rarr;</p>
        </div>
      </a>

      <!-- 2. Beli Tiket Wisata (BARU DITAMBAHKAN) -->
      <a href="#" class="flex items-start gap-4 group cursor-pointer">
        <div class="icon-orange w-[54px] h-[54px] rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
          <i class="fa-solid fa-ticket text-white text-xl"></i>
        </div>
        <div>
          <p class="font-bold text-gray-800 text-sm">Beli Tiket</p>
          <p class="text-gray-400 text-xs mt-0.5 leading-snug">Pesan tiket masuk satuan</p>
          <p class="text-orange text-xs font-semibold mt-2 group-hover:text-orange-d transition">Beli Sekarang &rarr;</p>
        </div>
      </a>
 
      <!-- 3. Paket Bundling -->
      <a href="#bundling" class="flex items-start gap-4 group cursor-pointer">
        <div class="icon-orange w-[54px] h-[54px] rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
          <i class="fa-solid fa-tags text-white text-xl"></i>
        </div>
        <div>
          <p class="font-bold text-gray-800 text-sm">Paket Bundling</p>
          <p class="text-gray-400 text-xs mt-0.5 leading-snug">Lebih hemat wisata paketan</p>
          <p class="text-orange text-xs font-semibold mt-2 group-hover:text-orange-d transition">Beli Paket &rarr;</p>
        </div>
      </a>
 
      <!-- 4. Homestay -->
      <a href="#" class="flex items-start gap-4 group cursor-pointer">
        <div class="icon-purple w-[54px] h-[54px] rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
          <i class="fa-solid fa-house text-white text-xl"></i>
        </div>
        <div>
          <p class="font-bold text-gray-800 text-sm">Homestay</p>
          <p class="text-gray-400 text-xs mt-0.5 leading-snug">Temukan penginapan nyaman</p>
          <p class="text-teal text-xs font-semibold mt-2 group-hover:text-orange transition">Cari Homestay &rarr;</p>
        </div>
      </a>
 
      <!-- 5. Peta Wisata -->
      <a href="#" class="flex items-start gap-4 group cursor-pointer">
        <div class="icon-green w-[54px] h-[54px] rounded-xl flex items-center justify-center flex-shrink-0 shadow-md">
          <i class="fa-solid fa-map text-white text-xl"></i>
        </div>
        <div>
          <p class="font-bold text-gray-800 text-sm">Peta Wisata</p>
          <p class="text-gray-400 text-xs mt-0.5 leading-snug">Lihat peta & rute terbaik</p>
          <p class="text-teal text-xs font-semibold mt-2 group-hover:text-orange transition">Lihat Peta &rarr;</p>
        </div>
      </a>
 
    </div>
  </div>
</section>
 
<section id="destinasi" class="py-12 bg-white">
  <div class="max-w-7xl mx-auto px-5">
    <div class="flex items-start justify-between mb-6">
      <div>
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-compass text-teal text-lg"></i>
          <h2 class="text-xl font-extrabold text-gray-800">Destinasi Populer</h2>
        </div>
        <p class="text-xs text-gray-400 mt-0.5">Temukan wisata favorit di Madiun & sekitarnya</p>
      </div>
      <a href="detail_destinasi.php" class="border border-gray-200 hover:border-teal text-gray-500 hover:text-teal text-xs font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
        Lihat Semua
      </a>
    </div>
 
    <div class="relative">
      <button id="dest-prev" class="absolute -left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-white border border-gray-200 rounded-full shadow-md flex items-center justify-center text-gray-400 hover:bg-teal hover:text-white transition-all">
        <i class="fa-solid fa-chevron-left text-xs"></i>
      </button>
 
      <div id="dest-track" class="flex gap-4 overflow-x-auto scrollbar-hide py-2" style="scroll-behavior:smooth;">
        <?php foreach ($hasilWisata as $d): ?>
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all flex-shrink-0 w-[260px] group">
          <div class="relative h-40">
            <img src="<?= htmlspecialchars($d['img']) ?>" alt="<?= htmlspecialchars($d['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            <span class="absolute top-2.5 right-2.5 bg-amber-400 text-white text-[11px] font-bold px-2 py-0.5 rounded-full flex items-center gap-0.5 shadow">
              <i class="fa-solid fa-star text-[9px]"></i> <?= htmlspecialchars($d['rating'] ?? '0') ?>
            </span>
          </div>
          <div class="p-4">
            <h3 class="font-bold text-gray-800 text-sm truncate mb-1"><?= htmlspecialchars($d['nama']) ?></h3>
            <p class="text-gray-400 text-xs flex items-center gap-1 mb-2">
              <i class="fa-solid fa-location-dot text-orange text-[10px]"></i>
              <?= htmlspecialchars($d['lokasi']) ?>
            </p>
            <p class="font-bold text-sm mb-3 text-teal">
              <?= htmlspecialchars($d['harga'] ?? 'Gratis') ?>
            </p>
            <div class="flex gap-2">
              <a href="#" class="flex-1 text-center border border-gray-200 hover:border-teal hover:text-teal text-gray-500 text-xs font-semibold py-2 rounded-lg transition">Detail</a>
              <a href="beli_tiket.php" class="flex-1 text-center bg-orange hover:bg-orange-d text-white text-xs font-bold py-2 rounded-lg transition">Tiket</a>
            </div>
          </div>
        </div>
        <?php endforeach; if(count($hasilWisata) == 0) echo "<p class='text-gray-400 text-sm pl-4'>Destinasi tidak ditemukan.</p>"; ?>
      </div>
 
      <button id="dest-next" class="absolute -right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-white border border-gray-200 rounded-full shadow-md flex items-center justify-center text-gray-400 hover:bg-teal hover:text-white transition-all">
        <i class="fa-solid fa-chevron-right text-xs"></i>
      </button>
    </div>
  </div>
</section>

<section id="bundling" class="py-12 bg-gray-50 border-t border-gray-100">
  <div class="max-w-7xl mx-auto px-5">
    <div class="flex items-start justify-between mb-6">
      <div>
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-tags text-teal text-lg"></i>
          <h2 class="text-xl font-extrabold text-gray-800">Paket Bundling Hemat</h2>
        </div>
        <p class="text-xs text-gray-400 mt-0.5">Nikmati liburan lebih murah dengan paket wisata pilihan</p>
      </div>
      <a href="paket.php" class="border border-gray-200 hover:border-teal text-gray-500 hover:text-teal text-xs font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
        Lihat Semua Paket
      </a>
    </div>

    <div class="relative">
      <button id="paket-prev" class="absolute -left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-white border border-gray-200 rounded-full shadow-md flex items-center justify-center text-gray-400 hover:bg-teal hover:text-white transition-all">
        <i class="fa-solid fa-chevron-left text-xs"></i>
      </button>

      <div id="paket-track" class="flex gap-4 overflow-x-auto scrollbar-hide py-2" style="scroll-behavior:smooth;">
        
        <?php 
        // Mengambil data paket bundling dari database jika $koneksi ada
        if (isset($koneksi)) {
            $query_paket = mysqli_query($koneksi, "SELECT * FROM paket_wisata ORDER BY id_paket DESC LIMIT 5");
            
            if ($query_paket && mysqli_num_rows($query_paket) > 0) {
                while ($paket = mysqli_fetch_array($query_paket)) {
        ?>
            <div class="bg-white border border-orange-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all flex-shrink-0 w-[260px] group relative">
              <div class="absolute top-0 right-0 bg-orange text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg z-10">
                PROMO
              </div>
              <div class="p-5 pt-6">
                <h3 class="font-bold text-gray-800 text-md mb-2 leading-tight"><?= htmlspecialchars($paket['nama_paket']); ?></h3>
                <p class="text-gray-500 text-[11px] mb-3 line-clamp-2"><?= htmlspecialchars($paket['deskripsi']); ?></p>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-[10px] text-gray-400">Harga Bundling</p>
                    <p class="font-extrabold text-lg mb-3 text-orange">
                      Rp <?= number_format($paket['harga_bundling'], 0, ',', '.'); ?>
                    </p>
                    <a href="detail_paket.php?id=<?= $paket['id_paket']; ?>" class="block w-full text-center bg-teal hover:bg-teal-d text-white text-xs font-bold py-2.5 rounded-lg transition">Lihat Detail & Pesan</a>
                </div>
              </div>
            </div>
        <?php 
                }
            } else {
                echo "<p class='text-gray-400 text-sm pl-4'>Belum ada paket bundling yang tersedia di database.</p>";
            }
        } else {
            echo "<p class='text-red-500 text-sm pl-4'>Koneksi database (koneksi.php) belum disertakan atau gagal.</p>";
        }
        ?>
        
      </div>

      <button id="paket-next" class="absolute -right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-white border border-gray-200 rounded-full shadow-md flex items-center justify-center text-gray-400 hover:bg-teal hover:text-white transition-all">
        <i class="fa-solid fa-chevron-right text-xs"></i>
      </button>
    </div>
  </div>

</section>
<section id="homestay" class="py-12 bg-white">
  <!-- Container utama dengan batasan lebar maksimum -->
  <div class="max-w-7xl mx-auto px-5">
 
    <!-- Header Section: Judul dan tombol navigasi -->
    <div class="flex items-start justify-between mb-6">
      <div>
        <div class="flex items-center gap-2">
          <i class="fa-solid fa-house text-teal text-lg"></i>
          <h2 class="text-xl font-extrabold text-gray-800">Rekomendasi Homestay</h2>
        </div>
        <p class="text-xs text-gray-400 mt-0.5">Penginapan nyaman pilihan terbaik di Madiun</p>
      </div>
      <a href="detail_destinasi.php" class="border border-gray-200 hover:border-teal text-gray-500 hover:text-teal text-xs font-semibold px-4 py-2 rounded-lg transition whitespace-nowrap">
        Lihat Semua
      </a>
    </div>
 
    <!-- Container untuk daftar kartu yang bisa di-scroll ke samping -->
    <div class="relative">
      <!-- Tombol Navigasi Kiri -->
      <button id="home-prev" class="absolute -left-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-white border border-gray-200 rounded-full shadow-md flex items-center justify-center text-gray-400 hover:bg-teal hover:text-white transition-all">
        <i class="fa-solid fa-chevron-left text-xs"></i>
      </button>
 
      <!-- Track Scroll Horizontal -->
      <div id="home-track" class="flex gap-4 overflow-x-auto scrollbar-hide py-2" style="scroll-behavior:smooth;">
        
        <?php foreach ($hasilHomestay as $h): ?>
        <!-- Kartu Penginapan -->
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all flex-shrink-0 w-[240px] group">
            <!-- Gambar Kartu -->
            <div class="relative h-36">
                <img src="<?= htmlspecialchars($h['img']) ?>" alt="<?= htmlspecialchars($h['nama']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                <span class="absolute top-2 right-2 bg-amber-400 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full flex items-center gap-0.5">
                    <i class="fa-solid fa-star text-[8px]"></i> <?= htmlspecialchars($h['rating'] ?? '0') ?>
                </span>
            </div>
            
            <!-- Detail Informasi Penginapan -->
            <div class="p-4">
                <h3 class="font-bold text-gray-800 text-sm truncate mb-1"><?= htmlspecialchars($h['nama']) ?></h3>
                <p class="text-gray-400 text-xs flex items-center gap-1 mb-1.5">
                    <i class="fa-solid fa-location-dot text-orange text-[9px]"></i> <?= htmlspecialchars($h['jarak']) ?>
                </p>
                <p class="text-teal font-bold text-sm mb-3">
                    <?= htmlspecialchars($h['harga'] ?? 'Gratis') ?><span class="text-gray-400 font-normal text-xs">/malam</span>
                </p>
                
                <!-- Action Buttons: Detail & Booking -->
                <div class="flex gap-2">
                    <a href="#" class="flex-1 text-center border border-teal text-teal hover:bg-teal hover:text-white text-xs font-bold py-2 rounded-lg transition">Detail</a>
                    <a href="booking.php?id=<?= $h['id'] ?? 0; ?>" class="flex-1 text-center bg-orange hover:bg-orange-d text-white text-[11px] font-bold py-2 rounded-lg transition">
                        Booking
                    </a>
                </div>
            </div>
        </div> 
        <?php endforeach; 
        
        // Pesan jika data homestay kosong
        if(count($hasilHomestay) == 0) {
            echo "<p class='text-gray-400 text-sm pl-4'>Homestay tidak ditemukan.</p>"; 
        }
        ?>
      </div>
 
      <!-- Tombol Navigasi Kanan -->
      <button id="home-next" class="absolute -right-4 top-1/2 -translate-y-1/2 z-10 w-9 h-9 bg-white border border-gray-200 rounded-full shadow-md flex items-center justify-center text-gray-400 hover:bg-teal hover:text-white transition-all">
        <i class="fa-solid fa-chevron-right text-xs"></i>
      </button>
    </div>
 
  </div>
</section>
 
<!-- Section Peta & Rute -->
<section id="peta" class="py-12 bg-gray-50">
  <div class="max-w-7xl mx-auto px-5">
 
    <div class="flex items-center gap-3 mb-8">
      <div class="w-12 h-12 bg-orange/10 rounded-xl flex items-center justify-center shadow-sm">
        <i class="fa-solid fa-map-location-dot text-orange text-xl"></i>
      </div>
      <div>
        <h2 class="text-xl font-extrabold text-gray-800">Peta Wisata & Rute Perjalanan</h2>
        <p class="text-sm text-gray-500 mt-0.5">Cari lokasi wisata dan dapatkan rute terbaik menuju ke sana</p>
      </div>
    </div>
 
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
      
      <div class="lg:col-span-3 rounded-2xl overflow-hidden border border-gray-200 shadow-sm flex flex-col bg-white">
        <div class="relative flex-1" style="min-height: 400px;">
          <iframe id="iframePeta" src="https://maps.google.com/maps?q=Madiun&t=&z=13&ie=UTF8&iwloc=&output=embed" style="width:100%;height:100%;border:0;display:block;" allowfullscreen loading="lazy"></iframe>
        </div>
      </div>
 
      <div class="lg:col-span-2 bg-white border border-gray-100 rounded-2xl shadow-md p-6 sm:p-8 flex flex-col justify-center">
        
        <div class="mb-6">
            <h3 class="text-lg font-extrabold text-gray-800">Cari Rute Perjalanan</h3>
            <p class="text-[11px] text-gray-400 mt-1">Temukan rute tercepat ke destinasi impianmu.</p>
        </div>

        <div class="mb-5">
            <label class="block text-xs font-bold text-gray-600 mb-2">Titik Keberangkatan</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center cursor-pointer" onclick="ambilLokasiSaya()" title="Gunakan lokasi saya">
                    <i class="fa-solid fa-location-crosshairs text-teal hover:text-teal-d transition text-sm"></i>
                </div>
                <input type="text" id="lokasiAsal" placeholder="Ketik lokasi / klik ikon GPS..." class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-3.5 text-sm text-gray-700 focus:ring-2 focus:ring-teal/20 focus:border-teal outline-none transition bg-gray-50/50 hover:bg-white">
            </div>
            <p class="text-[10px] text-gray-400 mt-1.5 ml-1">*Contoh: Mejayan, Madiun (Kecamatan, Kabupaten)</p>
        </div>

        <div class="mb-6">
            <label class="block text-xs font-bold text-gray-600 mb-2">Tujuan Wisata</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <i class="fa-solid fa-location-dot text-orange text-sm"></i>
                </div>
                <input type="text" id="tujuanWisata" placeholder="Contoh: Monumen Kresek" class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-3.5 text-sm text-gray-900 font-bold focus:ring-2 focus:ring-orange/20 focus:border-orange outline-none transition bg-gray-50/50 hover:bg-white">
            </div>
        </div>

        <div class="flex flex-row gap-3 mt-2">
            <button onclick="tampilkanDiPeta()" class="flex-1 bg-teal hover:bg-teal-d text-white text-xs font-bold py-3.5 rounded-xl transition shadow-sm hover:shadow flex items-center justify-center gap-2">
                <i class="fa-solid fa-map"></i> Peta Bawah
            </button>
            
            <button onclick="bukaGoogleMaps()" class="flex-1 bg-orange hover:bg-orange-d text-white text-xs font-bold py-3.5 rounded-xl transition shadow-sm hover:shadow flex items-center justify-center gap-2">
                <i class="fa-solid fa-route"></i> Rute Maps
            </button>
        </div>
        
      </div>
    </div>
  </div>
</section>

<script>
function ambilLokasiSaya() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('lokasiAsal').value = position.coords.latitude + "," + position.coords.longitude;
        }, function() {
            alert("Gagal mengakses lokasi. Mohon izinkan akses lokasi di browser Anda.");
        });
    } else {
        alert("Browser Anda tidak mendukung fitur lokasi.");
    }
}

function bukaGoogleMaps() {
    let asal = document.getElementById('lokasiAsal').value || "Lokasi Saya";
    let tujuan = document.getElementById('tujuanWisata').value;
    if (tujuan === "") { alert("Mohon isi tujuan wisata!"); return; }
    let url = "https://www.google.com/maps/dir/?api=1&origin=" + encodeURIComponent(asal) + "&destination=" + encodeURIComponent(tujuan);
    window.open(url, '_blank');
}

function tampilkanDiPeta() {
    let asal = document.getElementById('lokasiAsal').value;
    let tujuan = document.getElementById('tujuanWisata').value;
    if (tujuan === "") { alert("Mohon isi tujuan wisata!"); return; }
    
    // Mengubah src iframe agar memuat peta dengan rute baru
    let iframe = document.getElementById('iframePeta');
    iframe.src = "https://maps.google.com/maps?q=" + encodeURIComponent(tujuan) + "&output=embed";
}
</script>

<footer class="bg-slate-900 text-gray-400 text-sm py-12">
  <div class="max-w-7xl mx-auto px-5 grid grid-cols-1 md:grid-cols-3 gap-8">
    <div>
        <span class="font-extrabold text-lg text-white">Madiun<span class="text-orange">Track</span></span>
        <p class="text-xs mt-2 text-gray-400">Platform digital andalan untuk eksplorasi pariwisata, akomodasi homestay, dan peta rute terintegrasi di karesidenan Madiun.</p>
    </div>
    <div>
        <h4 class="text-white font-semibold mb-3">Navigasi</h4>
        <ul class="space-y-2 text-xs">
            <?php foreach($nav_footer as $nf): ?>
                <li><a href="#" class="hover:text-white transition"><?= $nf ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div>
        <h4 class="text-white font-semibold mb-3">Informasi</h4>
        <ul class="space-y-2 text-xs">
            <?php foreach($info_footer as $if): ?>
                <li><a href="#" class="hover:text-white transition"><?= $if ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
  </div>
  <div class="max-w-7xl mx-auto px-5 border-t border-gray-800 mt-8 pt-6 text-center text-xs text-gray-500">
     © <?= date('Y') ?> MadiunTrack. All Rights Reserved.
  </div>
</footer>

<script>
// Hamburger Menu Logic
const hbg = document.getElementById('hbg');
const mob = document.getElementById('mob');
hbg.addEventListener('click', () => {
    mob.classList.toggle('hidden');
});

// Horizontal Scrolling Helpers
const setupScroll = (trackId, prevId, nextId) => {
    const track = document.getElementById(trackId);
    const prev = document.getElementById(prevId);
    const next = document.getElementById(nextId);
    if(track && prev && next) {
        prev.addEventListener('click', () => track.scrollBy({ left: -240, behavior: 'smooth' }));
        next.addEventListener('click', () => track.scrollBy({ left: 240, behavior: 'smooth' }));
    }
}
setupScroll('dest-track', 'dest-prev', 'dest-next');
setupScroll('home-track', 'home-prev', 'home-next');

// Script baru untuk scrolling Paket Bundling
setupScroll('paket-track', 'paket-prev', 'paket-next');
</script>
</body>
</html>