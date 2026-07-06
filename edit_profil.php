<?php
/**
 * MadiunTrack - Edit Profil
 * Diakses dari tombol "Edit Profil" / "Ganti Password" di pengaturan.php
 */

session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit;
}

$id_user_login = $_SESSION['user_id'];
require_once 'koneksi.php';

$pesan       = '';
$pesanTipe   = ''; // 'sukses' atau 'error'
$pesanPass   = '';
$pesanPassTipe = '';

// ===== Simpan perubahan data profil =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'update_profil') {
    $nama          = trim($_POST['nama'] ?? '');
    $email         = trim($_POST['email'] ?? '');
    $no_hp         = trim($_POST['no_hp'] ?? '');
    $alamat        = trim($_POST['alamat'] ?? '');
    $tanggal_lahir = trim($_POST['tanggal_lahir'] ?? '');
    $foto          = trim($_POST['foto'] ?? '');

    if ($nama === '' || $email === '') {
        $pesan = 'Nama dan email wajib diisi.';
        $pesanTipe = 'error';
    } else {
        $stmtUpdate = mysqli_prepare(
            $koneksi,
            "UPDATE users SET nama = ?, email = ?, no_hp = ?, alamat = ?, tanggal_lahir = ?, foto = ? WHERE id = ?"
        );
        $tglLahirDb = $tanggal_lahir !== '' ? $tanggal_lahir : null;
        mysqli_stmt_bind_param(
            $stmtUpdate,
            'ssssssi',
            $nama, $email, $no_hp, $alamat, $tglLahirDb, $foto, $id_user_login
        );

        if (mysqli_stmt_execute($stmtUpdate)) {
            $_SESSION['nama'] = $nama;
            $pesan = 'Profil berhasil diperbarui.';
            $pesanTipe = 'sukses';
        } else {
            $pesan = 'Gagal menyimpan perubahan. Pastikan kolom no_hp, alamat, tanggal_lahir, dan foto sudah ada di tabel users.';
            $pesanTipe = 'error';
        }
    }
}

// ===== Ganti password =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['aksi']) && $_POST['aksi'] === 'ganti_password') {
    $passLama  = $_POST['password_lama'] ?? '';
    $passBaru  = $_POST['password_baru'] ?? '';
    $passUlang = $_POST['password_ulang'] ?? '';

    if ($passLama === '' || $passBaru === '' || $passUlang === '') {
        $pesanPass = 'Semua kolom password wajib diisi.';
        $pesanPassTipe = 'error';
    } elseif ($passBaru !== $passUlang) {
        $pesanPass = 'Konfirmasi password baru tidak cocok.';
        $pesanPassTipe = 'error';
    } elseif (strlen($passBaru) < 6) {
        $pesanPass = 'Password baru minimal 6 karakter.';
        $pesanPassTipe = 'error';
    } else {
        $stmtCek = mysqli_prepare($koneksi, "SELECT password FROM users WHERE id = ?");
        mysqli_stmt_bind_param($stmtCek, 'i', $id_user_login);
        mysqli_stmt_execute($stmtCek);
        $hasilCek = mysqli_stmt_get_result($stmtCek);
        $dataCek  = mysqli_fetch_assoc($hasilCek);

        if (!$dataCek || !password_verify($passLama, $dataCek['password'])) {
            $pesanPass = 'Password lama tidak sesuai.';
            $pesanPassTipe = 'error';
        } else {
            $hashBaru = password_hash($passBaru, PASSWORD_DEFAULT);
            $stmtGanti = mysqli_prepare($koneksi, "UPDATE users SET password = ? WHERE id = ?");
            mysqli_stmt_bind_param($stmtGanti, 'si', $hashBaru, $id_user_login);
            if (mysqli_stmt_execute($stmtGanti)) {
                $pesanPass = 'Password berhasil diganti.';
                $pesanPassTipe = 'sukses';
            } else {
                $pesanPass = 'Gagal mengganti password, coba lagi.';
                $pesanPassTipe = 'error';
            }
        }
    }
}

// ===== Data user (untuk prefill form & header/sidebar) =====
$user = [
    'nama'          => $_SESSION['nama'],
    'email'         => '',
    'foto'          => 'https://i.pinimg.com/736x/86/09/13/8609138d3fad1494037c343364dadd53.jpg',
    'no_hp'         => '',
    'alamat'        => '',
    'tanggal_lahir' => '',
];
$stmt_user = mysqli_prepare($koneksi, "SELECT * FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt_user, 'i', $id_user_login);
mysqli_stmt_execute($stmt_user);
if ($data_user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_user))) {
    $user['nama']  = $data_user['nama'] ?? $user['nama'];
    $user['email'] = $data_user['email'] ?? '';
    if (!empty($data_user['foto'])) {
        $user['foto'] = $data_user['foto'];
    }
    $user['no_hp']         = $data_user['no_hp'] ?? ($data_user['nomor_hp'] ?? ($data_user['telepon'] ?? ''));
    $user['alamat']        = $data_user['alamat'] ?? '';
    $user['tanggal_lahir'] = $data_user['tanggal_lahir'] ?? '';
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
        'chevron-left' => '<path d="m15 18-6-6 6-6"/>',
        'shield' => '<path d="M12 2l8 3v6c0 5-3.5 8.5-8 11-4.5-2.5-8-6-8-11V5z"/>',
        'camera' => '<path d="M14.5 4h-5L7 7H4a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2h-3l-2.5-3Z"/><circle cx="12" cy="13" r="3.2"/>',
        'phone' => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/>',
        'calendar' => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
        'mail' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
        'lock' => '<rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'check' => '<path d="M20 6 9 17l-5-5"/>',
        'alert' => '<circle cx="12" cy="12" r="10"/><path d="M12 8v5"/><path d="M12 16h.01"/>',
        'save' => '<path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2Z"/><path d="M17 21v-8H7v8"/><path d="M7 3v5h8"/>',
    ];
    $path = $icons[$name] ?? '';
    return "<svg width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"{$color}\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">{$path}</svg>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>MadiunTrack - Edit Profil</title>
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

        <div class="p-4 md:p-7 w-full">

            <a href="pengaturan.php" class="inline-flex items-center gap-1.5 text-sm text-slate-500 hover:text-slate-800 mb-4">
                <?= icon('chevron-left', 16) ?> Kembali ke Pengaturan
            </a>

            <h1 class="text-2xl font-semibold m-0 mb-1 text-slate-900">Edit Profil</h1>
            <p class="text-slate-500 text-sm m-0 mb-6">Perbarui informasi pribadi dan keamanan akun kamu.</p>

            <div class="grid grid-cols-1 lg:grid-cols-[300px_1fr] gap-5 items-start">

                <!-- KARTU FOTO PROFIL -->
                <div class="bg-white border border-slate-200 rounded-2xl p-6 flex flex-col items-center text-center">
                    <div class="relative">
                        <img src="<?= htmlspecialchars($user['foto']) ?>" alt="Foto profil" class="w-28 h-28 rounded-full object-cover border border-slate-200">
                        <button type="button" title="Ganti foto profil" class="absolute bottom-0 right-0 w-8 h-8 bg-blue-700 rounded-full flex items-center justify-center border-2 border-white cursor-pointer">
                            <?= icon('camera', 14, '#fff') ?>
                        </button>
                    </div>
                    <div class="font-bold text-slate-900 mt-3"><?= htmlspecialchars($user['nama']) ?></div>
                    <div class="text-slate-500 text-sm mb-1"><?= $user['email'] !== '' ? htmlspecialchars($user['email']) : '-' ?></div>
                    <p class="text-[12px] text-slate-400 mt-2 mb-0">Tempel URL foto baru pada form di samping lalu klik Simpan Perubahan untuk memperbarui foto profil.</p>
                </div>

                <!-- KOLOM KANAN: FORM -->
                <div class="flex flex-col gap-5">

                    <!-- FORM DATA DIRI -->
                    <div class="bg-white border border-slate-200 rounded-2xl p-6">
                        <h3 class="font-bold text-slate-900 mb-1 mt-0 flex items-center gap-2"><?= icon('user', 18, '#1d4ed8') ?> Data Diri</h3>
                        <p class="text-slate-500 text-[13px] mt-0 mb-4">Informasi ini akan digunakan pada tiket, booking, dan komunikasi lainnya.</p>

                        <?php if ($pesan !== ''): ?>
                            <div class="flex items-center gap-2 text-sm px-4 py-2.5 rounded-xl mb-4 <?= $pesanTipe === 'sukses' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' ?>">
                                <?= icon($pesanTipe === 'sukses' ? 'check' : 'alert', 16) ?>
                                <span><?= htmlspecialchars($pesan) ?></span>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <input type="hidden" name="aksi" value="update_profil">

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mb-5">
                                <div>
                                    <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Nama Lengkap</label>
                                    <div class="flex items-center gap-2.5 border border-slate-200 rounded-xl px-4 py-3">
                                        <?= icon('user', 16, '#94a3b8') ?>
                                        <input type="text" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" placeholder="Sesuai KTP" class="w-full text-[13.5px] outline-none border-none bg-transparent">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Email</label>
                                    <div class="flex items-center gap-2.5 border border-slate-200 rounded-xl px-4 py-3">
                                        <?= icon('mail', 16, '#94a3b8') ?>
                                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" placeholder="nama@email.com" class="w-full text-[13.5px] outline-none border-none bg-transparent">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Nomor WhatsApp</label>
                                    <div class="flex items-center gap-2.5 border border-slate-200 rounded-xl px-4 py-3">
                                        <?= icon('phone', 16, '#94a3b8') ?>
                                        <input type="tel" name="no_hp" value="<?= htmlspecialchars($user['no_hp']) ?>" placeholder="08xxxxxxxxxx" class="w-full text-[13.5px] outline-none border-none bg-transparent">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Tanggal Lahir</label>
                                    <div class="flex items-center gap-2.5 border border-slate-200 rounded-xl px-4 py-3">
                                        <?= icon('calendar', 16, '#94a3b8') ?>
                                        <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($user['tanggal_lahir']) ?>" class="w-full text-[13.5px] outline-none border-none bg-transparent">
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Alamat</label>
                                    <div class="flex items-start gap-2.5 border border-slate-200 rounded-xl px-4 py-3">
                                        <span class="mt-0.5"><?= icon('map-pin', 16, '#94a3b8') ?></span>
                                        <textarea name="alamat" rows="2" placeholder="Alamat lengkap" class="w-full text-[13.5px] outline-none border-none bg-transparent resize-none"><?= htmlspecialchars($user['alamat']) ?></textarea>
                                    </div>
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">URL Foto Profil</label>
                                    <div class="flex items-center gap-2.5 border border-slate-200 rounded-xl px-4 py-3">
                                        <?= icon('camera', 16, '#94a3b8') ?>
                                        <input type="url" name="foto" value="<?= htmlspecialchars($user['foto']) ?>" placeholder="https://..." class="w-full text-[13.5px] outline-none border-none bg-transparent">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-blue-700 hover:bg-blue-800 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                                <?= icon('save', 15, '#fff') ?> Simpan Perubahan
                            </button>
                        </form>
                    </div>

                    <!-- FORM GANTI PASSWORD -->
                    <div id="keamanan" class="bg-white border border-slate-200 rounded-2xl p-6">
                        <h3 class="font-bold text-slate-900 mb-1 mt-0 flex items-center gap-2"><?= icon('shield', 18, '#1d4ed8') ?> Ganti Password</h3>
                        <p class="text-slate-500 text-[13px] mt-0 mb-4">Gunakan password baru yang kuat dan belum pernah dipakai sebelumnya.</p>

                        <?php if ($pesanPass !== ''): ?>
                            <div class="flex items-center gap-2 text-sm px-4 py-2.5 rounded-xl mb-4 <?= $pesanPassTipe === 'sukses' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' ?>">
                                <?= icon($pesanPassTipe === 'sukses' ? 'check' : 'alert', 16) ?>
                                <span><?= htmlspecialchars($pesanPass) ?></span>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <input type="hidden" name="aksi" value="ganti_password">

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-4 mb-5">
                                <div>
                                    <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Password Lama</label>
                                    <div class="flex items-center gap-2.5 border border-slate-200 rounded-xl px-4 py-3">
                                        <?= icon('lock', 16, '#94a3b8') ?>
                                        <input type="password" name="password_lama" placeholder="••••••••" class="w-full text-[13.5px] outline-none border-none bg-transparent">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Password Baru</label>
                                    <div class="flex items-center gap-2.5 border border-slate-200 rounded-xl px-4 py-3">
                                        <?= icon('lock', 16, '#94a3b8') ?>
                                        <input type="password" name="password_baru" placeholder="Minimal 6 karakter" class="w-full text-[13.5px] outline-none border-none bg-transparent">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[12.5px] font-semibold text-slate-700 mb-1.5">Ulangi Password Baru</label>
                                    <div class="flex items-center gap-2.5 border border-slate-200 rounded-xl px-4 py-3">
                                        <?= icon('lock', 16, '#94a3b8') ?>
                                        <input type="password" name="password_ulang" placeholder="••••••••" class="w-full text-[13.5px] outline-none border-none bg-transparent">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold px-5 py-2.5 rounded-xl transition-colors">
                                <?= icon('shield', 15, '#fff') ?> Ganti Password
                            </button>
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