<?php
/**
 * MadiunTrack - Pengaturan
 * Diakses dari menu "Pengaturan" di sidebar dashboard_user.php
 */

session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit;
}

$id_user_login = $_SESSION['user_id'];
require_once 'koneksi.php';

$pesan = '';

// Hapus akun
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'hapus_akun') {
    $stmtHapus = mysqli_prepare($koneksi, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmtHapus, 'i', $id_user_login);
    mysqli_stmt_execute($stmtHapus);
    session_destroy();
    header('Location: login.php?akun_dihapus=1');
    exit;
}

$user = [
    'nama'            => $_SESSION['nama'],
    'email'           => '',
    'foto'            => 'https://i.pinimg.com/736x/86/09/13/8609138d3fad1494037c343364dadd53.jpg',
    'no_hp'           => '',
    'alamat'          => '',
    'tanggal_lahir'   => '',
    'bergabung'       => '',
    'role'            => 'Pengguna',
    'terakhir_login'  => '',
];
// SELECT * dipakai supaya halaman tetap jalan walau kolom tambahan (no_hp, alamat, dst)
// belum ada di tabel users kamu. Kalau kolomnya sudah ada, nilainya otomatis muncul.
$stmt_user = mysqli_prepare($koneksi, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt_user, 'i', $id_user_login);
mysqli_stmt_execute($stmt_user);
if ($data_user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_user))) {
    $user['nama']  = $data_user['nama'] ?? $user['nama'];
    $user['email'] = $data_user['email'] ?? '';
    if (!empty($data_user['foto'])) {
        $user['foto'] = $data_user['foto'];
    }
    $user['no_hp']  = $data_user['no_hp'] ?? ($data_user['nomor_hp'] ?? ($data_user['telepon'] ?? ''));
    $user['alamat'] = $data_user['alamat'] ?? '';
    $user['tanggal_lahir'] = !empty($data_user['tanggal_lahir'])
        ? date('d F Y', strtotime($data_user['tanggal_lahir']))
        : '';
    $tglGabung = $data_user['created_at'] ?? ($data_user['tanggal_daftar'] ?? null);
    $user['bergabung'] = !empty($tglGabung) ? date('d F Y', strtotime($tglGabung)) : '';
    $user['role'] = !empty($data_user['role']) ? ucfirst($data_user['role']) : 'Pengguna';
    $user['terakhir_login'] = !empty($data_user['last_login'])
        ? date('d F Y, H:i', strtotime($data_user['last_login'])) . ' WIB'
        : '';
}

// Helper untuk menampilkan nilai profil, dengan fallback jika datanya belum diisi
function tampil($nilai)
{
    if ($nilai === null || $nilai === '') {
        return '<span class="text-slate-400">Belum diisi</span>';
    }
    return htmlspecialchars($nilai);
}

$menu = [
    ['icon' => 'home', 'label' => 'Beranda', 'link' => 'dashboard_user.php'],
    ['icon' => 'map-pin', 'label' => 'Destinasi', 'link' => 'destinasi.php'],
    ['icon' => 'ticket', 'label' => 'Tiket Saya', 'link' => 'beli_tiket.php'],
    ['icon' => 'building', 'label' => 'Homestay Saya', 'link' => 'booking.php'],
    ['icon' => 'map', 'label' => 'Peta & Rute', 'link' => 'peta_rute.php'],
    ['icon' => 'heart', 'label' => 'Favorit', 'link' => 'favorit.php'],
    ['icon' => 'settings', 'label' => 'Pengaturan', 'active' => true, 'link' => 'pengaturan.php'],
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
        'bell' => '<path d="M6 8a6 6 0 0 1 12 0c0 5 2 6 2 6H4s2-1 2-6"/><path d="M10 21a2 2 0 0 0 4 0"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a15 15 0 0 1 0 18M12 3a15 15 0 0 0 0 18"/>',
        'shield' => '<path d="M12 2l8 3v6c0 5-3.5 8.5-8 11-4.5-2.5-8-6-8-11V5z"/>',
        'trash' => '<path d="M3 6h18M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2m3 0-1 14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2L4 6h16Z"/>',
        'camera' => '<path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3Z"/><circle cx="12" cy="13" r="3.2"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        'calendar-check' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/><path d="m8.5 15 1.8 1.8L15 13"/>',
        'badge' => '<rect x="2" y="5" width="20" height="14" rx="2"/><circle cx="9" cy="12" r="2"/><path d="M15 10h4M15 14h4"/>',
        'clock' => '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>',
        'edit' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/>',
    ];
    $path = $icons[$name] ?? '';
    return "<svg width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"{$color}\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">{$path}</svg>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>MadiunTrack - Pengaturan</title>
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

        <div class="p-4 md:p-7 max-w-6xl w-full">
            <h1 class="text-2xl font-semibold m-0 mb-1 text-slate-900">Pengaturan</h1>
            <p class="text-slate-500 text-sm m-0 mb-6">Kelola profil, preferensi, dan keamanan akun kamu.</p>

            <div class="grid grid-cols-1 lg:grid-cols-[340px_1fr] gap-5 items-start">

                <!-- PROFIL SAYA -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6">
                    <h3 class="font-bold text-slate-900 mb-5 mt-0 flex items-center gap-2"><?= icon('user', 18, '#1d4ed8') ?> Profil Saya</h3>

                    <div class="flex flex-col items-center text-center mb-5">
                        <div class="relative">
                            <img src="<?= htmlspecialchars($user['foto']) ?>" alt="Foto profil" class="w-24 h-24 rounded-full object-cover border border-slate-200">
                            <button type="button" title="Ganti foto profil" class="absolute bottom-0 right-0 w-7 h-7 bg-blue-700 rounded-full flex items-center justify-center border-2 border-white cursor-pointer">
                                <?= icon('camera', 13, '#fff') ?>
                            </button>
                        </div>
                        <div class="font-bold text-slate-900 mt-3"><?= htmlspecialchars($user['nama']) ?></div>
                        <div class="text-slate-500 text-sm"><?= $user['email'] !== '' ? htmlspecialchars($user['email']) : '-' ?></div>
                    </div>

                    <div class="border-t border-slate-100 pt-4 flex flex-col gap-3.5">
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="flex items-center gap-2 text-slate-500 shrink-0"><?= icon('user', 15, '#94a3b8') ?> Nama Lengkap</span>
                            <span class="font-medium text-slate-800 text-right"><?= tampil($user['nama']) ?></span>
                        </div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="flex items-center gap-2 text-slate-500 shrink-0"><?= icon('phone', 15, '#94a3b8') ?> Nomor HP</span>
                            <span class="font-medium text-slate-800 text-right"><?= tampil($user['no_hp']) ?></span>
                        </div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="flex items-center gap-2 text-slate-500 shrink-0"><?= icon('map-pin', 15, '#94a3b8') ?> Alamat</span>
                            <span class="font-medium text-slate-800 text-right"><?= tampil($user['alamat']) ?></span>
                        </div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="flex items-center gap-2 text-slate-500 shrink-0"><?= icon('calendar', 15, '#94a3b8') ?> Tanggal Lahir</span>
                            <span class="font-medium text-slate-800 text-right"><?= tampil($user['tanggal_lahir']) ?></span>
                        </div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="flex items-center gap-2 text-slate-500 shrink-0"><?= icon('calendar-check', 15, '#94a3b8') ?> Bergabung Sejak</span>
                            <span class="font-medium text-slate-800 text-right"><?= tampil($user['bergabung']) ?></span>
                        </div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="flex items-center gap-2 text-slate-500 shrink-0"><?= icon('badge', 15, '#94a3b8') ?> Role Akun</span>
                            <span class="font-medium text-slate-800 text-right"><?= tampil($user['role']) ?></span>
                        </div>
                        <div class="flex items-center justify-between gap-3 text-sm">
                            <span class="flex items-center gap-2 text-slate-500 shrink-0"><?= icon('clock', 15, '#94a3b8') ?> Terakhir Login</span>
                            <span class="font-medium text-slate-800 text-right"><?= tampil($user['terakhir_login']) ?></span>
                        </div>
                    </div>

                    <a href="edit_profil.php" class="mt-5 w-full inline-flex items-center justify-center gap-2 border border-blue-200 text-blue-700 hover:bg-blue-50 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                        <?= icon('edit', 15) ?> Edit Profil
                    </a>
                </div>

                <!-- KOLOM KANAN -->
                <div class="flex flex-col gap-5">

                    <!-- NOTIFIKASI -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6">
                        <h3 class="font-bold text-slate-900 mb-1 mt-0 flex items-center gap-2"><?= icon('bell', 18, '#1d4ed8') ?> Notifikasi</h3>
                        <p class="text-slate-500 text-[13px] mt-0 mb-4">Atur preferensi notifikasi yang kamu terima.</p>
                        <div class="flex flex-col gap-4">
                            <label class="flex items-center justify-between cursor-pointer">
                                <div>
                                    <div class="text-sm font-semibold text-slate-800">Update Status Pesanan</div>
                                    <div class="text-[12.5px] text-slate-500">Dapatkan notifikasi saat status tiket/booking berubah</div>
                                </div>
                                <input type="checkbox" checked class="w-5 h-5 accent-blue-700">
                            </label>
                            <label class="flex items-center justify-between cursor-pointer">
                                <div>
                                    <div class="text-sm font-semibold text-slate-800">Promo & Penawaran</div>
                                    <div class="text-[12.5px] text-slate-500">Info diskon dan paket wisata terbaru</div>
                                </div>
                                <input type="checkbox" class="w-5 h-5 accent-blue-700">
                            </label>
                            <label class="flex items-center justify-between cursor-pointer">
                                <div>
                                    <div class="text-sm font-semibold text-slate-800">Notifikasi via Email</div>
                                    <div class="text-[12.5px] text-slate-500">Kirim salinan notifikasi ke email terdaftar</div>
                                </div>
                                <input type="checkbox" checked class="w-5 h-5 accent-blue-700">
                            </label>
                        </div>
                        <p class="text-[11.5px] text-slate-400 mt-4 mb-0">Catatan: preferensi ini masih tampilan (UI) saja — perlu tabel <code>preferensi_notifikasi</code> untuk benar-benar disimpan per pengguna.</p>
                    </div>

                    <!-- BAHASA / REGIONAL -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6">
                        <h3 class="font-bold text-slate-900 mb-1 mt-0 flex items-center gap-2"><?= icon('globe', 18, '#1d4ed8') ?> Bahasa & Wilayah</h3>
                        <p class="text-slate-500 text-[13px] mt-0 mb-4">Atur bahasa dan wilayah tampilan aplikasi.</p>
                        <div class="flex items-center gap-2.5 border border-slate-200 rounded-xl px-4 py-2.5 max-w-xs">
                            <select class="w-full text-sm outline-none border-none bg-transparent">
                                <option>Bahasa Indonesia</option>
                                <option>English</option>
                            </select>
                        </div>
                    </div>

                    <!-- KEAMANAN -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6">
                        <h3 class="font-bold text-slate-900 mb-1 mt-0 flex items-center gap-2"><?= icon('shield', 18, '#1d4ed8') ?> Keamanan Akun</h3>
                        <p class="text-slate-500 text-[13px] mt-0 mb-4">Kelola keamanan akun kamu.</p>
                        <a href="profil.php" class="inline-flex items-center justify-between gap-8 bg-slate-100 hover:bg-slate-200 text-slate-800 text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors">
                            <span class="flex items-center gap-2"><?= icon('shield', 15, '#475569') ?> Ganti Password</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 6 6 6-6 6"/></svg>
                        </a>
                    </div>

                    <!-- ZONA BAHAYA -->
                    <div class="bg-red-50 border border-red-200 rounded-2xl p-6">
                        <h3 class="font-bold text-red-700 mb-1 mt-0 flex items-center gap-2"><?= icon('trash', 18, '#dc2626') ?> Hapus Akun</h3>
                        <p class="text-red-600 text-[13px] mb-4">Tindakan ini permanen. Semua data akun kamu akan dihapus dan tidak bisa dikembalikan.</p>
                        <form method="POST" onsubmit="return confirm('Yakin ingin menghapus akun secara permanen? Tindakan ini tidak bisa dibatalkan.');">
                            <input type="hidden" name="aksi" value="hapus_akun">
                            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">Hapus Akun Saya</button>
                        </form>
                    </div>
                </div>
            </div>
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