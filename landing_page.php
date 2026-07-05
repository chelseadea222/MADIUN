<?php
require_once 'koneksi.php';
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

?>

<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MadiunTrack - Jelajahi Madiun Lebih Mudah</title>
    
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        jakarta: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            DEFAULT: '#F59E0B', /* Orange utama */
                            light: '#FEF3C7',
                            dark: '#D97706'
                        },
                        navy: '#0F172A',
                        bglight: '#FCF9F5' /* Warna background cream pucat */
                    },
                    boxShadow: {
                        'soft': '0 10px 40px rgba(0,0,0,0.04)',
                        'float': '0 10px 25px rgba(245,158,11,0.3)',
                    }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Hilangkan scrollbar bawaan untuk slider */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Pola titik (Dot Pattern) untuk ornamen background */
        .pattern-dots {
            background-image: radial-gradient(#f59e0b 1.5px, transparent 1.5px);
            background-size: 16px 16px;
            opacity: 0.15;
        }
    </style>
</head>
<body class="bg-bglight text-slate-800 overflow-x-hidden relative">

    <!-- Ornamen Latar Belakang Blur (Sesuai Desain) -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[-15%] left-[-10%] w-[500px] h-[500px] bg-amber-200/40 rounded-full mix-blend-multiply filter blur-[100px]"></div>
        <div class="absolute top-[20%] right-[-10%] w-[600px] h-[600px] bg-amber-200/30 rounded-full mix-blend-multiply filter blur-[120px]"></div>
    </div>

    <!-- NAVBAR FLOATING -->
    <nav class="fixed top-5 left-0 right-0 z-50 mx-auto w-[92%] max-w-6xl bg-white rounded-full px-4 py-3 shadow-soft flex justify-between items-center transition-all">
        <!-- Logo -->
        <a href="#" class="flex items-center gap-3 pl-2">
            <div class="w-9 h-9 bg-brand rounded-xl flex items-center justify-center text-white shadow-md shadow-brand/30">
                <i class="bi bi-geo-alt-fill text-base"></i>
            </div>
            <h1 class="text-xl font-black text-navy tracking-tight">
                Madiun<span class="text-brand">Track</span>
            </h1>
        </a>

        <!-- Links & Sign In (Desktop & Mobile responsif) -->
        <div class="flex items-center gap-6 pr-1">
            <div class="hidden md:flex items-center gap-6 mr-4">
                <a href="#" class="text-sm font-bold text-slate-500 hover:text-navy transition">Beranda</a>
                <a href="#destinasi" class="text-sm font-bold text-slate-500 hover:text-navy transition">Destinasi</a>
            </div>
            <!-- Tombol Sign In -->
            <a href="login.php" class="bg-navy hover:bg-slate-800 text-white text-xs md:text-sm font-bold px-6 py-2.5 rounded-full transition-all shadow-md flex items-center gap-2">
                Sign In <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <main class="relative z-10 w-full min-h-screen flex items-center pt-32 pb-16">
        
        <!-- Ornamen Pola Titik & Siluet -->
        <div class="absolute left-16 top-40 w-24 h-24 pattern-dots hidden lg:block"></div>
        
        <div class="w-full max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-8 items-center relative">
            
            <!-- BAGIAN KIRI: Teks Utama -->
            <div class="flex flex-col items-center lg:items-start text-center lg:text-left z-20 mt-8 lg:mt-0">
                
                <!-- Badge Pesona -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-orange-50 border border-orange-100 mb-6 shadow-sm">
                    <i class="bi bi-geo-fill text-brand text-xs"></i>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-amber-800">Pesona Kota Pendekar</span>
                </div>
                
                <!-- Judul -->
                <h1 class="text-5xl lg:text-[4.5rem] font-black tracking-tighter leading-[1.1] text-navy mb-6">
                    Jelajahi <span class="text-brand">Madiun</span><br />
                    Lebih Mudah.
                </h1>
                
                <!-- Deskripsi -->
                <p class="text-slate-500 text-sm md:text-base font-medium leading-relaxed max-w-md mb-8">
                    Jelajahi banyaknya pesona wisata Madiun dengan lebih praktis. Akses e-tiket, booking penginapan, serta panduan rute cerdas kini bisa kamu nikmati cukup dari satu layar.
                </p>
                
                <!-- Tombol -->
                <a href="#destinasi" class="bg-brand hover:bg-amber-600 text-white font-bold py-3.5 px-8 rounded-full text-sm transition-all shadow-float flex items-center gap-2">
                    Lihat Destinasi <i class="bi bi-arrow-down-short text-lg"></i>
                </a>
            </div>

            <!-- BAGIAN KANAN: Gambar Hero / Card -->
            <div class="relative w-full max-w-[550px] mx-auto z-20">
                <div class="relative w-full aspect-[4/3] lg:aspect-[1.3/1] rounded-[2rem] overflow-hidden shadow-2xl bg-navy">
                    <!-- Gambar Neon Madiun Sesuai Referensi -->
                    <img src="https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=1000&q=80" alt="Kota Madiun Malam" class="w-full h-full object-cover">
                    
                    <!-- Overlay Gradient -->
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/95 via-navy/30 to-transparent"></div>
                    
                    <!-- Teks di dalam gambar -->
                    <div class="absolute bottom-8 left-8 right-8">
                        <h3 class="font-black text-2xl lg:text-3xl text-white flex items-center gap-2">
                            <i class="bi bi-geo-alt-fill text-brand"></i> Kota Madiun
                        </h3>
                        <p class="text-xs text-white/70 font-medium mt-2">Madiun Pesona Kota Gadis, Ketangguhan Kota Pendekar</p>
                    </div>

                    <!-- Indikator Slider (Titik) -->
                    <div class="absolute bottom-8 right-8 flex gap-2">
                        <div class="w-2.5 h-2.5 rounded-full bg-brand"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-white/40"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-white/40"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-white/40"></div>
                    </div>
                </div>
            </div>

        </div>
    </main>

<!-- 2. SECTION DESTINASI POPULER (DENGAN DATA ANDA) -->
<section id="destinasi" class="relative z-10 w-full bg-white py-20">
    <div class="max-w-[1400px] mx-auto px-6 lg:px-12">
        
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-12 text-center md:text-left gap-6">
            <div>
                <p class="text-[10px] font-black text-brand uppercase tracking-[0.2em] mb-2">Destinasi Populer</p>
                <h2 class="text-3xl lg:text-4xl font-black text-navy mb-3">Temukan Destinasi Terbaik di <span class="text-brand">Madiun</span></h2>
                <p class="text-slate-500 text-sm md:text-base font-medium">Jelajahi keindahan, budaya, dan pengalaman tak terlupakan di setiap sudut Madiun.</p>
            </div>
        </div>

        <!-- Slider Wrapper -->
        <div class="relative group">
            <!-- Scroll Container -->
            <div class="flex overflow-x-auto gap-6 pb-8 pt-2 snap-x snap-mandatory no-scrollbar px-2" id="slider-destinasi">
                
                <?php foreach ($wisata_madiun as $wisata): ?>
                <!-- Card -->
                <div class="min-w-[280px] lg:min-w-[300px] h-[350px] relative rounded-[2rem] overflow-hidden snap-start shadow-sm border border-slate-100 group cursor-pointer flex flex-col">
                    <img src="<?= htmlspecialchars($wisata['img']) ?>" 
                         alt="<?= htmlspecialchars($wisata['nama']) ?>" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    
                    <!-- Gradient Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/90 via-navy/20 to-transparent"></div>
                    
                    <!-- Badge -->
                    <div class="absolute top-5 left-5 bg-white/95 px-3 py-1 rounded-full flex items-center gap-1.5 shadow-sm">
                        <i class="bi bi-geo-alt-fill text-brand text-[10px]"></i>
                        <span class="text-[9px] font-black text-navy uppercase tracking-wider"><?= htmlspecialchars($wisata['lokasi']) ?></span>
                    </div>

                    <!-- Content -->
                    <div class="absolute bottom-6 left-6 right-6 text-white">
                        <h4 class="font-black text-lg mb-2 leading-tight"><?= htmlspecialchars($wisata['nama']) ?></h4>
                        <p class="text-xs text-white/70 font-medium line-clamp-2 mb-4"><?= htmlspecialchars($wisata['desc']) ?></p>
                        <a href="beli_tiket.php" class="inline-block bg-brand text-white text-[10px] font-bold px-5 py-2 rounded-xl hover:bg-brandDark transition">
                            Pesan Tiket
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>

            <!-- Tombol Navigasi Kiri (Baru) -->
<button onclick="document.getElementById('slider-destinasi').scrollBy({left: -320, behavior: 'smooth'})" 
        class="hidden md:flex absolute -left-5 top-[40%] w-12 h-12 bg-white rounded-full shadow-lg border border-slate-100 items-center justify-center text-brand hover:bg-brand hover:text-white transition-all z-20 opacity-0 group-hover:opacity-100 -translate-x-2 group-hover:translate-x-0">
    <i class="bi bi-chevron-left text-lg"></i>
</button>

            <!-- Tombol Navigasi Kanan (Muncul di Desktop) -->
            <button onclick="document.getElementById('slider-destinasi').scrollBy({left: 320, behavior: 'smooth'})" 
                    class="hidden md:flex absolute -right-5 top-[40%] w-12 h-12 bg-white rounded-full shadow-lg border border-slate-100 items-center justify-center text-brand hover:bg-brand hover:text-white transition-all z-20">
                <i class="bi bi-chevron-right text-lg"></i>
            </button>
        </div>

        <!-- Pagination Dots -->
        <div class="flex justify-center items-center gap-2 mt-8">
            <div class="w-3 h-3 rounded-full bg-brand"></div>
            <div class="w-2 h-2 rounded-full bg-slate-200"></div>
            <div class="w-2 h-2 rounded-full bg-slate-200"></div>
        </div>
    </div>
</section>