<?php
/**
 * MadiunTrack - Destinasi Wisata
 * Diakses dari menu "Destinasi" di sidebar dashboard_user.php
 */

session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit;
}

$id_user_login = $_SESSION['user_id'];
require_once 'koneksi.php';

$user = ['nama' => $_SESSION['nama'], 'email' => '', 'foto' => 'https://i.pinimg.com/736x/86/09/13/8609138d3fad1494037c343364dadd53.jpg'];
$stmt_user = mysqli_prepare($koneksi, "SELECT nama, email FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt_user, 'i', $id_user_login);
mysqli_stmt_execute($stmt_user);
if ($data_user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_user))) {
    $user['nama']  = $data_user['nama'];
    $user['email'] = $data_user['email'];
}

// ===== DATA DESTINASI =====
// Coba ambil dari tabel `destinasi` kalau sudah ada. Kalau belum, pakai daftar
// destinasi yang sudah dipakai di beli_tiket.php sebagai fallback, supaya
// halaman ini tetap tampil dengan data yang konsisten dengan alur pembelian tiket.
$destinasi_list = [];
$cek_tabel = mysqli_query($koneksi, "SHOW TABLES LIKE 'destinasi'");
if ($cek_tabel && mysqli_num_rows($cek_tabel) > 0) {
    $q = mysqli_query($koneksi, "SELECT * FROM destinasi ORDER BY nama ASC");
    while ($row = mysqli_fetch_assoc($q)) {
        $destinasi_list[] = [
            'nama'   => $row['nama'],
            'lokasi' => $row['lokasi'] ?? '-',
            'harga'  => (int)($row['harga'] ?? 0),
            'gambar' => $row['gambar'] ?? 'https://images.unsplash.com/photo-1518998053901-5348d3961a04?w=600',
            'desc'   => $row['deskripsi'] ?? '',
        ];
    }
} else {
    // Fallback: sesuaikan/tambah di sini kalau tabel `destinasi` sudah dibuat nanti
    $destinasi_list = [
        ['nama' => 'Pahlawan Street Center (PSC)', 'lokasi' => 'Pusat Kota Madiun', 'harga' => 10000, 'gambar' => 'https://images.unsplash.com/photo-1518998053901-5348d3961a04?w=600', 'desc' => 'Kawasan ikonik dengan bangunan bersejarah di jantung Kota Madiun.'],
        ['nama' => 'Taman Bantaran Kali Madiun', 'lokasi' => 'Bantaran Sungai Madiun', 'harga' => 10000, 'gambar' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600', 'desc' => 'Taman tepi sungai yang asri, cocok untuk bersantai sore hari.'],
        ['nama' => 'Taman Sumber Umis', 'lokasi' => 'Kabupaten Madiun', 'harga' => 15000, 'gambar' => 'https://images.unsplash.com/photo-1470770903676-69b98201ea1c?w=600', 'desc' => 'Sumber mata air alami dikelilingi pepohonan rindang.'],
        ['nama' => 'Alun-Alun Kota Madiun', 'lokasi' => 'Pusat Kota Madiun', 'harga' => 5000, 'gambar' => 'https://images.unsplash.com/photo-1519074069444-1ba4fff66d16?w=600', 'desc' => 'Ruang publik utama kota, ramai di sore dan malam hari.'],
        ['nama' => 'Desa Wisata Brumbun', 'lokasi' => 'Kabupaten Madiun', 'harga' => 15000, 'gambar' => 'https://images.unsplash.com/photo-1500534623283-312aade485b7?w=600', 'desc' => 'Desa wisata dengan nuansa pedesaan dan budaya lokal.'],
        ['nama' => 'Ngrowo Bening Edupark', 'lokasi' => 'Kabupaten Madiun', 'harga' => 15000, 'gambar' => 'https://images.unsplash.com/photo-1500964757637-c85e8a162699?w=600', 'desc' => 'Taman edukasi dengan wahana keluarga dan area hijau.'],
        ['nama' => 'Taman Trembesi', 'lokasi' => 'Kabupaten Madiun', 'harga' => 10000, 'gambar' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600', 'desc' => 'Taman rindang dengan pohon trembesi besar yang teduh.'],
        ['nama' => 'Hutan Pinus Nongko Ijo', 'lokasi' => 'Lereng Wilis, Kabupaten Madiun', 'harga' => 10000, 'gambar' => 'https://images.unsplash.com/photo-1425913397330-cf8af2ff40a1?w=600', 'desc' => 'Hutan pinus sejuk dengan spot foto populer di kaki Gunung Wilis.'],
        ['nama' => 'Waduk Bening', 'lokasi' => 'Kabupaten Madiun', 'harga' => 15000, 'gambar' => 'https://images.unsplash.com/photo-1439066615861-d1af74d74000?w=600', 'desc' => 'Waduk luas dengan pemandangan matahari terbenam yang indah.'],
    ];
}

$menu = [
    ['icon' => 'home', 'label' => 'Beranda', 'link' => 'dashboard_user.php'],
    ['icon' => 'map-pin', 'label' => 'Destinasi', 'active' => true, 'link' => 'destinasi_user.php'],
    ['icon' => 'ticket', 'label' => 'Tiket Saya', 'link' => 'beli_tiket.php'],
    ['icon' => 'building', 'label' => 'Homestay Saya', 'link' => 'booking.php'],
    ['icon' => 'map', 'label' => 'Peta & Rute', 'link' => 'peta_rute.php'],
    ['icon' => 'heart', 'label' => 'Favorit', 'link' => 'favorit.php'],
    ['icon' => 'settings', 'label' => 'Pengaturan', 'link' => 'pengaturan.php'],
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
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'heart-fill' => '<path d="M12 21s-7.5-4.6-10-9.3C.4 8 2 4.5 5.6 4c2.2-.3 4 .9 6.4 3.4C14.4 4.9 16.2 3.7 18.4 4 22 4.5 23.6 8 22 11.7 19.5 16.4 12 21 12 21Z" fill="currentColor" stroke="none"/>',
    ];
    $path = $icons[$name] ?? '';
    return "<svg width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"{$color}\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">{$path}</svg>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>MadiunTrack - Destinasi Wisata</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased m-0">

<div class="flex min-h-screen">

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

        <div class="p-4 md:p-7">
            <h1 class="text-2xl font-semibold m-0 mb-1 text-slate-900">Destinasi Wisata</h1>
            <p class="text-slate-500 text-sm m-0 mb-6">Jelajahi destinasi wisata terbaik di Madiun dan pesan tiketnya langsung.</p>

            <form class="flex items-center gap-2.5 bg-white border border-slate-200 rounded-xl px-4 py-3 mb-7 shadow-sm max-w-md" onsubmit="return false;">
                <?= icon('search', 18, '#94a3b8') ?>
                <input type="text" id="cariDestinasi" placeholder="Cari nama destinasi..." class="border-none outline-none flex-1 text-sm bg-transparent">
            </form>

            <div id="gridDestinasi" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php foreach ($destinasi_list as $d): ?>
                <div class="destinasi-card bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow" data-nama="<?= htmlspecialchars(strtolower($d['nama'])) ?>">
                    <img src="<?= htmlspecialchars($d['gambar']) ?>" alt="<?= htmlspecialchars($d['nama']) ?>" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <h3 class="font-bold text-slate-900 text-[15px] mb-1 mt-0"><?= htmlspecialchars($d['nama']) ?></h3>
                        <p class="text-slate-500 text-[12px] flex items-center gap-1.5 mb-2 mt-0"><?= icon('map-pin', 13, '#94a3b8') ?> <?= htmlspecialchars($d['lokasi']) ?></p>
                        <p class="text-slate-500 text-[12.5px] mb-3 mt-0 leading-relaxed line-clamp-2"><?= htmlspecialchars($d['desc']) ?></p>
                        <div class="flex items-center justify-between">
                            <span class="font-extrabold text-blue-700 text-[15px]">Rp <?= number_format($d['harga'], 0, ',', '.') ?></span>
                            <a href="beli_tiket.php" class="bg-blue-700 hover:bg-blue-800 text-white text-[12.5px] font-semibold px-3.5 py-2 rounded-xl transition-colors">Beli Tiket</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <p id="emptyState" class="hidden text-center text-slate-400 text-sm py-10">Destinasi tidak ditemukan.</p>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var input = document.getElementById('cariDestinasi');
    var cards = document.querySelectorAll('.destinasi-card');
    var empty = document.getElementById('emptyState');

    input.addEventListener('input', function () {
        var q = this.value.trim().toLowerCase();
        var visible = 0;
        cards.forEach(function (c) {
            var match = c.dataset.nama.includes(q);
            c.style.display = match ? '' : 'none';
            if (match) visible++;
        });
        empty.classList.toggle('hidden', visible !== 0);
    });

    var sidebar = document.getElementById('sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var openBtn = document.getElementById('hamburgerBtn');
    var closeBtn = document.getElementById('sidebarClose');
    function openSidebar() { sidebar.classList.remove('-translate-x-full'); overlay.classList.remove('hidden'); }
    function closeSidebar() { sidebar.classList.add('-translate-x-full'); overlay.classList.add('hidden'); }
    if (openBtn) openBtn.addEventListener('click', openSidebar);
    if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);
});
</script>
</body>
</html>