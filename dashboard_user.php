<?php
/**
 * MadiunTrack - Dashboard User (Setelah Login)
 * PHP Native dengan Tailwind CSS
 */

session_start();

// ===== Dummy data (nantinya bisa diganti dengan query database) =====
$user = [
    'nama' => 'Raka',
    'foto' => 'https://i.pravatar.cc/100?img=12',
];

$menu = [
    ['icon' => 'home', 'label' => 'Beranda', 'active' => true, 'link' => '#'],
    ['icon' => 'map-pin', 'label' => 'Destinasi', 'link' => '#'],
    ['icon' => 'ticket', 'label' => 'Tiket Saya', 'link' => '#'],
    ['icon' => 'building', 'label' => 'Homestay Saya', 'link' => '#'],
    ['icon' => 'map', 'label' => 'Peta & Rute', 'link' => '#'],
    ['icon' => 'heart', 'label' => 'Favorit', 'link' => '#'], // Ganti jika ada file favorit
    ['icon' => 'user', 'label' => 'Profil Saya', 'link' => '#'], 
    ['icon' => 'settings', 'label' => 'Pengaturan', 'link' => '#'],
];

$layanan = [
    [
        'icon' => 'map-pin',
        'warna' => '#1d4ed8',
        'judul' => 'Destinasi Wisata',
        'desc'  => 'Temukan tempat wisata terbaik di Madiun',
        'aksi'  => 'Jelajahi',
        'link'  => '#', // Arahkan ke file destinasi
    ],
    [
        'icon' => 'tag',
        'warna' => '#ea580c',
        'judul' => 'Beli Tiket',
        'desc'  => 'Pesan tiket wisata dengan mudah',
        'aksi'  => 'Pesan Sekarang',
        'link'  => '#', // Arahkan ke file beli tiket
    ],
    [
        'icon' => 'home',
        'warna' => '#7c3aed',
        'judul' => 'Booking Homestay',
        'desc'  => 'Temukan penginapan nyaman & terbaik',
        'aksi'  => 'Cari Homestay',
        'link'  => '#', // Arahkan ke file homestay
    ],
    [
        'icon' => 'book-open',
        'warna' => '#16a34a',
        'judul' => 'Peta & Rute',
        'desc'  => 'Lihat peta wisata dan rencanakan rute',
        'aksi'  => 'Lihat Peta',
        'link'  => '#', // Arahkan ke file peta
    ],
];

// DATA PAKET BUNDLING BARU
$paket_bundling = [
    [
        'icon' => 'package',
        'warna_bg' => 'from-orange-50 to-white',
        'warna_border' => 'border-orange-200',
        'warna_icon' => 'text-orange-600',
        'warna_icon_bg' => 'bg-orange-100',
        'judul' => 'Paket Liburan Keluarga',
        'desc'  => 'Homestay Wilis Indah + 3 Destinasi Populer (Termasuk Sarapan)',
        'harga' => 'Rp 350.000',
        'link'  => '#',
    ],
    [
        'icon' => 'camera',
        'warna_bg' => 'from-blue-50 to-white',
        'warna_border' => 'border-blue-200',
        'warna_icon' => 'text-blue-600',
        'warna_icon_bg' => 'bg-blue-100',
        'judul' => 'Paket Backpacker',
        'desc'  => 'Homestay Murah + Sewa Motor 24 Jam + Tiket Pahlawan Street Center',
        'harga' => 'Rp 210.000',
        'link'  => '#',
    ],
    [
        'icon' => 'heart',
        'warna_bg' => 'from-rose-50 to-white',
        'warna_border' => 'border-rose-200',
        'warna_icon' => 'text-rose-600',
        'warna_icon_bg' => 'bg-rose-100',
        'judul' => 'Paket Honeymoon',
        'desc'  => 'Hotel Aston Madiun + Romantic Dinner + Private Tour Guide',
        'harga' => 'Rp 850.000',
        'link'  => '#',
    ]
];

$aktivitas = [
    [
        'gambar' => 'https://images.unsplash.com/photo-1518998053901-5348d3961a04?w=200',
        'judul'  => 'Tiket Masuk Pahlawan Street Center',
        'tipe'   => 'Tiket',
        'label1' => 'Tanggal Kunjungan',
        'nilai1' => '20 Mei 2024',
        'label2' => 'Jumlah',
        'nilai2' => '2 Tiket',
        'status' => 'Selesai',
    ],
    [
        'gambar' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=200',
        'judul'  => 'Homestay Omah Kartini',
        'tipe'   => 'Homestay',
        'label1' => 'Check-in',
        'nilai1' => '18 Mei 2024',
        'label2' => 'Check-out',
        'nilai2' => '20 Mei 2024',
        'status' => 'Selesai',
    ],
    [
        'gambar' => 'https://images.unsplash.com/photo-1502920917128-1aa500764cbd?w=200',
        'judul'  => 'Tiket Masuk Taman Sumber Umis',
        'tipe'   => 'Tiket',
        'label1' => 'Tanggal Kunjungan',
        'nilai1' => '15 Mei 2024',
        'label2' => 'Jumlah',
        'nilai2' => '1 Tiket',
        'status' => 'Selesai',
    ],
];

$rekomendasi = [
    'gambar' => 'https://images.unsplash.com/photo-1500534623283-312aade485b7?w=400',
    'rating' => 4.7,
    'judul'  => 'Alun-Alun Kota Madiun',
    'lokasi' => 'Manguharjo',
    'harga'  => 'Gratis',
];

$favorit = [
    [
        'gambar' => 'https://images.unsplash.com/photo-1431274172761-fca41d930114?w=100',
        'judul'  => 'Pahlawan Street Center',
        'lokasi' => 'Kartoharjo',
    ],
    [
        'gambar' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?w=100',
        'judul'  => 'Taman Bantaran Kali',
        'lokasi' => 'Manguharjo',
    ],
];

function icon($name, $size = 20, $color = 'currentColor')
{
    $icons = [
        'home' => '<path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1Z"/>',
        'map-pin' => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'ticket' => '<path d="M3 9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v1.5a1.5 1.5 0 0 0 0 3V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1.5a1.5 1.5 0 0 0 0-3V9Z"/><path d="M9 7v10" stroke-dasharray="3 3"/>',
        'building' => '<rect x="4" y="3" width="16" height="18" rx="1"/><path d="M9 8h.01M15 8h.01M9 12h.01M15 12h.01M9 16h.01M15 16h.01"/>',
        'map' => '<path d="M9 19 3 17V5l6 2 6-2 6 2v12l-6-2-6 2-6-2Z"/><path d="M9 5v14M15 7v14"/>',
        'heart' => '<path d="M12 21s-7.5-4.6-10-9.3C.4 8 2 4.5 5.6 4c2.2-.3 4 .9 6.4 3.4C14.4 4.9 16.2 3.7 18.4 4 22 4.5 23.6 8 22 11.7 19.5 16.4 12 21 12 21Z"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4.5-6 8-6s7 2 8 6"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 13a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.9 2.9l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V19a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.9-2.9l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1H4a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.9 2.9l.1.1a1.7 1.7 0 0 0 1.9.3H10a1.7 1.7 0 0 0 1-1.6V4a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.9 2.9l-.1.1a1.7 1.7 0 0 0-.3 1.9V10a1.7 1.7 0 0 0 1.6 1H20a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.6 1Z"/>',
        'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
        'bell' => '<path d="M6 8a6 6 0 0 1 12 0c0 5 2 6 2 6H4s2-1 2-6"/><path d="M10 21a2 2 0 0 0 4 0"/>',
        'tag' => '<path d="m12 2 8.5 8.5a2 2 0 0 1 0 2.8l-7 7a2 2 0 0 1-2.8 0L2 11.8V3a1 1 0 0 1 1-1h9Z"/><circle cx="7" cy="7" r="1.2"/>',
        'book-open' => '<path d="M12 7c-2-2-5-2-9-1v13c4-1 7-1 9 1 2-2 5-2 9-1V6c-4-1-7-1-9 1Z"/><path d="M12 7v13"/>',
        'star' => '<path d="m12 2 2.9 6.4 7 .7-5.3 4.7 1.6 6.9L12 17.3 5.8 20.7l1.6-6.9L2.1 9.1l7-.7Z"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
        'arrow-right' => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
        'help-circle' => '<circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 0 1 5.8 1c0 2-3 2-3 4"/><path d="M12 17h.01"/>',
        'package' => '<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
        'camera' => '<path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3z"/><circle cx="12" cy="13" r="3"/>'
    ];
    $path = $icons[$name] ?? '';
    return "<svg width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"{$color}\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">{$path}</svg>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MadiunTrack - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer components {
            .tab {
                @apply bg-transparent px-1 pt-2 pb-3 text-sm text-slate-500 border-b-2 border-transparent hover:text-slate-700 transition-colors;
            }
            .tab.active {
                @apply text-blue-700 border-blue-700 font-semibold;
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased m-0">

<div class="flex min-h-screen">

    <!-- Overlay gelap saat sidebar terbuka di mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden"></div>

    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-60 bg-white border-r border-slate-200 flex flex-col p-5 shrink-0 transform -translate-x-full transition-transform duration-300 ease-in-out md:static md:translate-x-0 md:flex">
        <div class="flex items-center justify-between pb-6">
            <div class="flex items-center gap-2.5 px-2 text-lg font-bold">
                <span class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center"><?= icon('map-pin', 18, '#fff') ?></span>
                <span>Madiun<span class="text-blue-700">Track</span></span>
            </div>
            <button id="sidebarClose" class="md:hidden text-slate-400 hover:text-slate-700 bg-transparent border-none cursor-pointer p-1">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
            </button>
        </div>

        <nav class="flex flex-col gap-1 flex-1">
            <?php foreach ($menu as $item): ?>
                <?php
                $baseStyle = "flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors";
                $activeStyle = !empty($item['active']) 
                    ? "$baseStyle bg-blue-700 text-white shadow-sm" 
                    : "$baseStyle text-slate-500 hover:bg-slate-50 hover:text-slate-900";
                ?>
                <a href="<?= htmlspecialchars($item['link']) ?>" class="<?= $activeStyle ?>">
                    <?= icon($item['icon'], 18) ?>
                    <span><?= htmlspecialchars($item['label']) ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="border-t border-slate-200 pt-3 mt-auto">
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 text-sm font-medium transition-colors hover:bg-red-50 hover:text-red-600">
                <?= icon('logout', 18) ?>
                <span>Keluar</span>
            </a>
        </div>
    </aside>

    <main class="flex-1 min-w-0 flex flex-col">

        <header class="flex justify-between items-center px-7 py-4 border-b border-slate-200 bg-white sticky top-0 z-20">
            <button id="hamburgerBtn" class="md:hidden text-slate-500 hover:text-slate-700 bg-transparent border-none cursor-pointer p-1">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="hidden md:block"></div>
            <div class="flex items-center gap-4">
                <button class="text-slate-500 hover:text-slate-700 bg-transparent border-none cursor-pointer"><?= icon('bell', 19) ?></button>
                <div class="flex items-center gap-2 text-sm text-slate-500 cursor-pointer">
                    <img src="<?= htmlspecialchars($user['foto']) ?>" alt="Foto profil" class="w-8 h-8 rounded-full object-cover border border-slate-200">
                    <span>Halo, <strong class="text-slate-900"><?= htmlspecialchars($user['nama']) ?></strong></span>
                    <?= icon('chevron-down', 16) ?>
                </div>
            </div>
        </header>

        <div class="p-4 md:p-7 grid grid-cols-1 xl:grid-cols-[1fr_320px] gap-6 items-start">

            <div class="flex flex-col min-w-0">

                <h1 class="text-2xl font-semibold m-0 mb-1 text-slate-900">Selamat datang kembali, <?= htmlspecialchars($user['nama']) ?>! <span class="inline-block">👋</span></h1>
                <p class="text-slate-500 text-sm m-0 mb-6">Yuk, rencanakan perjalanan seru kamu di Madiun.</p>

                <form class="flex items-center gap-2.5 bg-white border border-slate-200 rounded-xl px-4 py-3 mb-7 shadow-sm" action="#" method="get">
                    <?= icon('search', 18, '#94a3b8') ?>
                    <input type="text" name="q" placeholder="Cari destinasi, tiket, homestay..." class="border-none outline-none flex-1 text-sm bg-transparent">
                </form>

                <section class="relative bg-gradient-to-br from-blue-900 to-blue-700 rounded-2xl overflow-hidden min-h-[180px] flex items-center mb-8 shadow-sm">
                    <div class="relative z-10 text-white p-7 md:max-w-[60%]">
                        <h2 class="text-2xl font-bold mb-1 mt-0">Jelajahi Madiun</h2>
                        <p class="text-sm text-white/90 mb-3.5 mt-0">Lebih Mudah dengan MadiunTrack</p>
                        <ul class="list-none p-0 m-0 text-[13px] flex flex-col gap-1.5 text-white/95">
                            <li class="flex items-center gap-2"><?= icon('ticket', 14) ?> Pesan tiket wisata</li>
                            <li class="flex items-center gap-2"><?= icon('home', 14) ?> Booking homestay terbaik</li>
                            <li class="flex items-center gap-2"><?= icon('map', 14) ?> Rute perjalanan lengkap</li>
                        </ul>
                    </div>
                    <img class="absolute right-0 top-0 h-full w-[55%] object-cover opacity-90 hidden md:block" src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=500" alt="Wisatawan menjelajahi Madiun" style="mask-image: linear-gradient(to right, transparent, black 25%); -webkit-mask-image: linear-gradient(to right, transparent, black 25%);">
                </section>

                <h3 class="text-base font-semibold mb-3.5 mt-0">Layanan Utama</h3>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-9">
                    <?php foreach ($layanan as $l): ?>
                        <a href="<?= htmlspecialchars($l['link']) ?>" class="bg-white border border-slate-200 rounded-2xl p-4 flex flex-col gap-1.5 transition-all hover:shadow-md hover:-translate-y-0.5 block">
                            <span class="w-10 h-10 rounded-xl flex items-center justify-center mb-1.5 text-white shadow-sm" style="background-color: <?= $l['warna'] ?>">
                                <?= icon($l['icon'], 20, '#fff') ?>
                            </span>
                            <strong class="text-[14px] text-slate-900"><?= htmlspecialchars($l['judul']) ?></strong>
                            <p class="m-0 text-[12px] text-slate-500 leading-snug line-clamp-2"><?= htmlspecialchars($l['desc']) ?></p>
                            <span class="text-[12px] font-semibold flex items-center gap-1 mt-1" style="color: <?= $l['warna'] ?>">
                                <?= htmlspecialchars($l['aksi']) ?> <?= icon('arrow-right', 12) ?>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="flex items-center justify-between mb-3.5">
                    <div>
                        <h3 class="text-base font-semibold m-0">Paket Wisata Bundling</h3>
                        <p class="text-[12px] text-slate-500 mt-0.5 m-0">Lebih hemat dan praktis</p>
                    </div>
                    <a href="#" class="text-blue-700 text-[13px] font-semibold hover:underline hidden sm:block">Lihat Semua &rarr;</a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-9">
                    <?php foreach ($paket_bundling as $pb): ?>
                        <div class="bg-gradient-to-br <?= $pb['warna_bg'] ?> border <?= $pb['warna_border'] ?> p-5 rounded-2xl shadow-sm hover:shadow-md transition-shadow flex flex-col">
                            <div class="<?= $pb['warna_icon_bg'] ?> w-11 h-11 rounded-xl flex items-center justify-center mb-4 shrink-0">
                                <span class="<?= $pb['warna_icon'] ?>"><?= icon($pb['icon'], 22) ?></span>
                            </div>
                            <h4 class="font-bold text-slate-800 text-sm mb-1.5 mt-0"><?= htmlspecialchars($pb['judul']) ?></h4>
                            <p class="text-slate-500 text-[12px] mb-4 flex-1 m-0 leading-relaxed"><?= htmlspecialchars($pb['desc']) ?></p>
                            <div class="mt-auto">
                                <p class="<?= $pb['warna_icon'] ?> font-extrabold text-base mb-3 m-0"><?= htmlspecialchars($pb['harga']) ?></p>
                                <a href="<?= htmlspecialchars($pb['link']) ?>" class="block w-full text-center border <?= $pb['warna_border'] ?> text-slate-700 font-bold text-[12.5px] py-2 rounded-xl hover:bg-slate-50 transition-colors bg-white">
                                    Lihat Detail Paket
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="mb-2 flex items-center justify-between">
                    <h3 class="text-base font-semibold m-0">Aktivitas Terbaru</h3>
                    <a href="#" 
                    class="text-blue-700 text-[13px] font-semibold hover:underline hidden sm:block">Lihat Semua</a>
                </div>

                <div class="flex gap-5 border-b border-slate-200 mb-4 overflow-x-auto">
                    <button class="tab active whitespace-nowrap" data-tab="semua">Semua</button>
                    <button class="tab whitespace-nowrap" data-tab="tiket">Tiket</button>
                    <button class="tab whitespace-nowrap" data-tab="homestay">Homestay</button>
                </div>

                <div class="flex flex-col gap-3 mb-8">
                    <?php foreach ($aktivitas as $a): ?>
                        <div class="activity-card flex items-center gap-3.5 bg-white border border-slate-200 rounded-2xl p-3 px-4 shadow-sm" data-type="<?= strtolower($a['tipe']) ?>">
                            <img src="<?= htmlspecialchars($a['gambar']) ?>" alt="<?= htmlspecialchars($a['judul']) ?>" class="w-14 h-14 rounded-xl object-cover shrink-0">
                            <div class="flex-1 min-w-0">
                                <strong class="text-sm block mb-1.5 text-slate-900 truncate"><?= htmlspecialchars($a['judul']) ?></strong>
                                <div class="flex flex-col sm:flex-row gap-1 sm:gap-8 text-[11px] sm:text-xs">
                                    <div>
                                        <span class="block text-slate-500 mb-0.5"><?= htmlspecialchars($a['label1']) ?></span>
                                        <span class="block font-semibold text-slate-900"><?= htmlspecialchars($a['nilai1']) ?></span>
                                    </div>
                                    <div>
                                        <span class="block text-slate-500 mb-0.5"><?= htmlspecialchars($a['label2']) ?></span>
                                        <span class="block font-semibold text-slate-900"><?= htmlspecialchars($a['nilai2']) ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-2 shrink-0">
                                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-full bg-green-100 text-green-700"><?= htmlspecialchars($a['status']) ?></span>
                                <button class="border border-slate-200 bg-white text-slate-700 text-[12px] font-semibold px-3 py-1.5 rounded-lg hover:bg-slate-50 transition-colors hidden sm:block">Lihat Detail</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-between bg-blue-50 border border-blue-100 rounded-2xl p-4 px-5 gap-4">
                    <div class="flex items-center gap-3">
                        <?= icon('help-circle', 24, '#1d4ed8') ?>
                        <div>
                            <strong class="block text-sm text-slate-900">Butuh bantuan?</strong>
                            <p class="m-0 mt-0.5 text-[12.5px] text-slate-500">Tim kami siap membantu perjalanan kamu di Madiun.</p>
                        </div>
                    </div>
                    <button class="bg-blue-700 text-white border-none text-[13px] font-semibold px-4.5 py-2.5 rounded-xl hover:bg-blue-800 transition-colors whitespace-nowrap w-full sm:w-auto shadow-sm">Hubungi CS</button>
                </div>

            </div>

            <div class="flex flex-col">

                <section class="bg-white border border-slate-200 rounded-2xl p-5 mb-5 shadow-sm">
                    <h3 class="m-0 mb-4 text-[15px] font-semibold text-slate-900">Rekomendasi Untukmu</h3>
                    <div>
                        <div class="relative mb-3">
                            <img src="<?= htmlspecialchars($rekomendasi['gambar']) ?>" alt="<?= htmlspecialchars($rekomendasi['judul']) ?>" class="w-full h-[140px] object-cover rounded-xl block">
                            <span class="absolute top-2 right-2 bg-amber-500 text-white text-[11px] font-bold px-2 py-1 rounded-full flex items-center gap-1 shadow-sm">
                                <?= icon('star', 12, '#fff') ?> <?= $rekomendasi['rating'] ?>
                            </span>
                        </div>
                        <strong class="text-sm font-semibold block text-slate-900"><?= htmlspecialchars($rekomendasi['judul']) ?></strong>
                        <p class="flex items-center gap-1 text-xs text-slate-500 my-1.5">
                            <?= icon('map-pin', 12, '#94a3b8') ?> <?= htmlspecialchars($rekomendasi['lokasi']) ?>
                        </p>
                        <p class="text-green-600 font-bold text-[14px] m-0 mb-4"><?= htmlspecialchars($rekomendasi['harga']) ?></p>
                        <button class="w-full border border-slate-200 bg-white text-slate-700 text-[12.5px] font-semibold px-3.5 py-2 rounded-xl hover:bg-slate-50 transition-colors">Lihat Detail</button>
                    </div>
                </section>

                <section class="bg-white border border-slate-200 rounded-2xl p-5 mb-5 shadow-sm">
                    <h3 class="m-0 mb-4 text-[15px] font-semibold text-slate-900">Favorit Anda</h3>
                    <div class="flex flex-col gap-3.5 mb-5">
                        <?php foreach ($favorit as $f): ?>
                            <div class="flex items-center gap-3">
                                <img src="<?= htmlspecialchars($f['gambar']) ?>" alt="<?= htmlspecialchars($f['judul']) ?>" class="w-12 h-12 rounded-xl object-cover shrink-0">
                                <div>
                                    <strong class="text-[13px] block font-semibold text-slate-900 leading-tight mb-1"><?= htmlspecialchars($f['judul']) ?></strong>
                                    <p class="m-0 text-[11.5px] text-slate-500 flex items-center gap-1">
                                        <?= icon('map-pin', 11, '#94a3b8') ?> <?= htmlspecialchars($f['lokasi']) ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="w-full border border-slate-200 bg-white text-slate-700 text-[12.5px] font-semibold px-3.5 py-2 rounded-xl hover:bg-slate-50 transition-colors">Lihat Semua Favorit</button>
                </section>

            </div>

        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var tabs = document.querySelectorAll('.tab');
    var cards = document.querySelectorAll('.activity-card');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('active'); });
            tab.classList.add('active');

            var type = tab.dataset.tab;
            cards.forEach(function (card) {
                if (type === 'semua' || card.dataset.type === type) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });

    // ===== Toggle Sidebar Mobile =====
    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var openBtn = document.getElementById('hamburgerBtn');
    var closeBtn = document.getElementById('sidebarClose');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    if (openBtn) openBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
});
</script>
</body>
</html>