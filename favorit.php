<?php
/**
 * MadiunTrack - Favorit
 * Diakses dari menu "Favorit" di sidebar dashboard_user.php
 *
 * CATATAN: Halaman ini butuh tabel `favorit` untuk berfungsi penuh. Kalau
 * belum ada, jalankan dulu SQL ini di database:
 *
 * CREATE TABLE favorit (
 *   id INT AUTO_INCREMENT PRIMARY KEY,
 *   user_id INT NOT NULL,
 *   nama_destinasi VARCHAR(150) NOT NULL,
 *   gambar VARCHAR(255) NULL,
 *   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *   UNIQUE KEY unik_favorit (user_id, nama_destinasi)
 * );
 *
 * Selama tabel belum ada, halaman tetap tampil (dengan status kosong) tanpa error.
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

$tabelFavoritAda = mysqli_num_rows(mysqli_query($koneksi, "SHOW TABLES LIKE 'favorit'")) > 0;

// Hapus dari favorit (form POST dari tombol di kartu)
if ($tabelFavoritAda && isset($_POST['hapus_favorit_id'])) {
    $hapusId = (int)$_POST['hapus_favorit_id'];
    $stmtHapus = mysqli_prepare($koneksi, "DELETE FROM favorit WHERE id = ? AND user_id = ?");
    mysqli_stmt_bind_param($stmtHapus, 'ii', $hapusId, $id_user_login);
    mysqli_stmt_execute($stmtHapus);
    header('Location: favorit.php');
    exit;
}

$daftar_favorit = [];
if ($tabelFavoritAda) {
    $stmtFav = mysqli_prepare($koneksi, "SELECT id, nama_destinasi, gambar FROM favorit WHERE user_id = ? ORDER BY created_at DESC");
    mysqli_stmt_bind_param($stmtFav, 'i', $id_user_login);
    mysqli_stmt_execute($stmtFav);
    $hasilFav = mysqli_stmt_get_result($stmtFav);
    while ($row = mysqli_fetch_assoc($hasilFav)) {
        $daftar_favorit[] = $row;
    }
}

$menu = [
    ['icon' => 'home', 'label' => 'Beranda', 'link' => 'dashboard_user.php'],
    ['icon' => 'map-pin', 'label' => 'Destinasi', 'link' => 'destinasi.php'],
    ['icon' => 'ticket', 'label' => 'Tiket Saya', 'link' => 'beli_tiket.php'],
    ['icon' => 'building', 'label' => 'Homestay Saya', 'link' => 'booking.php'],
    ['icon' => 'map', 'label' => 'Peta & Rute', 'link' => 'peta_rute.php'],
    ['icon' => 'heart', 'label' => 'Favorit', 'active' => true, 'link' => 'favorit.php'],
    ['icon' => 'user', 'label' => 'Profil Saya', 'link' => 'profil.php'],
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
        'heart-fill' => '<path d="M12 21s-7.5-4.6-10-9.3C.4 8 2 4.5 5.6 4c2.2-.3 4 .9 6.4 3.4C14.4 4.9 16.2 3.7 18.4 4 22 4.5 23.6 8 22 11.7 19.5 16.4 12 21 12 21Z" fill="currentColor" stroke="none"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4.5-6 8-6s7 2 8 6"/>',
        'settings' => '<circle cx="12" cy="12" r="3"/><path d="M19.4 13a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.9 2.9l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V19a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.9-2.9l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1H4a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.9 2.9l.1.1a1.7 1.7 0 0 0 1.9.3H10a1.7 1.7 0 0 0 1-1.6V4a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.9 2.9l-.1.1a1.7 1.7 0 0 0-.3 1.9V10a1.7 1.7 0 0 0 1.6 1H20a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.6 1Z"/>',
        'logout' => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'bell' => '<path d="M6 8a6 6 0 0 1 12 0c0 5 2 6 2 6H4s2-1 2-6"/><path d="M10 21a2 2 0 0 0 4 0"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'trash' => '<path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6h16Z"/>',
    ];
    $path = $icons[$name] ?? '';
    return "<svg width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"{$color}\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">{$path}</svg>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>MadiunTrack - Favorit</title>
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
            <h1 class="text-2xl font-semibold m-0 mb-1 text-slate-900">Destinasi Favorit</h1>
            <p class="text-slate-500 text-sm m-0 mb-6">Destinasi yang sudah kamu tandai untuk dikunjungi nanti.</p>

            <?php if (!$tabelFavoritAda): ?>
            <div class="bg-amber-50 border border-amber-200 text-amber-800 text-[13px] rounded-xl p-4 mb-6">
                Fitur favorit belum aktif sepenuhnya karena tabel <code>favorit</code> belum ada di database. Jalankan skrip SQL yang ada di komentar bagian atas berkas <code>favorit.php</code> untuk mengaktifkannya.
            </div>
            <?php endif; ?>

            <?php if (empty($daftar_favorit)): ?>
                <div class="bg-white border border-slate-200 rounded-2xl p-10 text-center">
                    <div class="w-14 h-14 rounded-full bg-rose-50 flex items-center justify-center mx-auto mb-4">
                        <?= icon('heart', 26, '#e11d48') ?>
                    </div>
                    <h3 class="font-bold text-slate-900 mb-1">Belum ada destinasi favorit</h3>
                    <p class="text-slate-500 text-sm mb-5">Jelajahi destinasi wisata Madiun dan tandai yang paling kamu suka.</p>
                    <a href="destinasi.php" class="inline-block bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">Jelajahi Destinasi</a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    <?php foreach ($daftar_favorit as $f): ?>
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                        <img src="<?= htmlspecialchars($f['gambar'] ?: 'https://images.unsplash.com/photo-1518998053901-5348d3961a04?w=600') ?>" alt="<?= htmlspecialchars($f['nama_destinasi']) ?>" class="w-full h-36 object-cover">
                        <div class="p-4 flex items-center justify-between gap-3">
                            <h3 class="font-bold text-slate-900 text-[14px] m-0"><?= htmlspecialchars($f['nama_destinasi']) ?></h3>
                            <form method="POST" onsubmit="return confirm('Hapus dari favorit?');">
                                <input type="hidden" name="hapus_favorit_id" value="<?= (int)$f['id'] ?>">
                                <button type="submit" class="text-rose-500 hover:text-rose-700 bg-transparent border-none cursor-pointer p-1" title="Hapus dari favorit">
                                    <?= icon('trash', 17) ?>
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
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