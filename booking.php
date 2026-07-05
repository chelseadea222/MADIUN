<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Halaman ini hanya boleh diakses oleh member yang sudah login (sama seperti beli_tiket.php)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit;
}

$id_user_login = $_SESSION['user_id'];

require_once 'koneksi.php';
require_once 'homestay_madiun.php'; // isi $homestay_madiun

// ===== Data user (sinkron dengan tabel `users`, dipakai untuk sidebar & header) =====
$user = [
    'nama'  => $_SESSION['nama'],
    'email' => '',
    'foto'  => 'https://i.pinimg.com/736x/86/09/13/8609138d3fad1494037c343364dadd53.jpg',
];

if (isset($koneksi)) {
    $stmt_user = mysqli_prepare($koneksi, "SELECT id, nama, email FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt_user, 'i', $id_user_login);
    mysqli_stmt_execute($stmt_user);
    $hasil_user = mysqli_stmt_get_result($stmt_user);
    if ($data_user = mysqli_fetch_assoc($hasil_user)) {
        $user['nama']  = $data_user['nama'];
        $user['email'] = $data_user['email'];
    }
}

// ===== Menu navigasi (identik dengan dashboard_user.php, "Homestay Saya" aktif) =====
$menu = [
    ['icon' => 'home', 'label' => 'Beranda', 'link' => 'dashboard_user.php'],
    ['icon' => 'map-pin', 'label' => 'Destinasi', 'link' => 'destinasi_user.php'],
    ['icon' => 'ticket', 'label' => 'Tiket Saya', 'link' => 'beli_tiket.php'],
    ['icon' => 'building', 'label' => 'Homestay Saya', 'active' => true, 'link' => 'booking.php'],
    ['icon' => 'map', 'label' => 'Peta & Rute', 'link' => 'peta_rute.php'],
    ['icon' => 'heart', 'label' => 'Favorit', 'link' => 'favorit.php'],
    ['icon' => 'settings', 'label' => 'Pengaturan', 'link' => 'pengaturan.php'],
];

// Kalau datang dari tombol "Booking" di homestay_madiun.php (?id=...),
// homestay itu otomatis ke-pilih di dropdown.
$selectedId = $_GET['id'] ?? '';

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
    <title>MadiunTrack - Booking Homestay</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              orange: { DEFAULT: '#f7941d', light: '#fff1e0' },
              navy:   '#0f1f45',
              mutedc: '#8b93a7',
              bordc:  '#e6e8f0',
            }
          }
        }
      }
    </script>
    <style>
      input:focus, select:focus{ outline:none; border-color:#f7941d; box-shadow:0 0 0 3px rgba(247,148,29,0.12); }
      .dashed{ border-top:1.5px dashed #e2e4ee; }
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

        <div class="p-4 md:p-7">

            <h1 class="text-2xl font-semibold m-0 mb-1 text-slate-900">Booking Homestay</h1>
            <p class="text-slate-500 text-sm m-0 mb-6">Pilih homestay terbaik untuk kenangan liburan tak terlupakan di Madiun.</p>

<div class="w-full max-w-[1320px] bg-white rounded-[32px] shadow-[0_25px_70px_-25px_rgba(15,31,69,0.35)] overflow-hidden grid grid-cols-1 lg:grid-cols-[460px_1fr]">

  <!-- LEFT: HERO -->
  <div class="relative min-h-[420px] lg:min-h-full flex flex-col p-8 lg:p-10 text-white overflow-hidden">
    <img src="https://images.unsplash.com/photo-1518998053901-5348d3961a04?w=900&q=70" alt="Madiun" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-navy/80 via-navy/50 to-navy/90"></div>

    <div class="relative z-10 mb-auto">
      <h1 class="text-[34px] leading-[1.1] font-extrabold mb-1">Mulai</h1>
      <h1 class="text-[34px] leading-[1.1] font-extrabold text-orange mb-4">Petualanganmu</h1>
      <div class="w-10 h-1 bg-orange rounded-full mb-4"></div>
      <p class="text-white/75 text-[14px] leading-relaxed max-w-[280px]">
        Pilih homestay terbaik untuk kenangan liburan tak terlupakan di Madiun.
      </p>
    </div>

    <div class="relative z-10 bg-black/25 backdrop-blur-sm rounded-2xl p-5 flex flex-col gap-4 mt-10">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center shrink-0">
          <svg viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2" class="w-5 h-5"><path d="M12 2l8 3v6c0 5-3.5 8.5-8 11-4.5-2.5-8-6-8-11V5z"/><path d="M9 12l2 2 4-4"/></svg>
        </div>
        <div>
          <div class="font-bold text-[13.5px]">Harga Terjamin</div>
          <div class="text-white/60 text-[12px]">Harga terbaik tanpa biaya tersembunyi</div>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center shrink-0">
          <svg viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2" class="w-5 h-5"><path d="M3 8.5c0-1 .5-1.7 1.3-2.2M21 8.5c0-1-.5-1.7-1.3-2.2M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/><circle cx="12" cy="8" r="4"/></svg>
        </div>
        <div>
          <div class="font-bold text-[13.5px]">Dukungan 24/7</div>
          <div class="text-white/60 text-[12px]">Tim kami siap membantu kapan saja</div>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center shrink-0">
          <svg viewBox="0 0 24 24" fill="none" stroke="#4ade80" stroke-width="2" class="w-5 h-5"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/></svg>
        </div>
        <div>
          <div class="font-bold text-[13.5px]">Pembayaran Aman</div>
          <div class="text-white/60 text-[12px]">Transaksi aman dan terlindungi 100%</div>
        </div>
      </div>
    </div>
  </div>

  <!-- RIGHT: FORM -->
  <div class="p-8 lg:p-12">

    <div class="flex items-center gap-3.5 mb-8">
      <div class="w-12 h-12 rounded-2xl bg-orange-light flex items-center justify-center shrink-0">
        <svg viewBox="0 0 24 24" fill="none" stroke="#f7941d" stroke-width="2" class="w-6 h-6"><path d="M3 10l9-7 9 7M4 10v10h5v-6h6v6h5V10"/></svg>
      </div>
      <h2 class="font-extrabold text-[26px] text-navy">Booking Homestay</h2>
    </div>

    <form id="formReservasi">

      <!-- INFORMASI PEMESAN -->
      <div class="flex items-center gap-2 mb-4">
        <span class="w-1 h-4 bg-orange rounded-full"></span>
        <span class="font-bold text-[14px] text-navy">Informasi Pemesan</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mb-6">
        <div>
          <label class="block text-[12.5px] font-semibold text-navy mb-1.5">Nama Lengkap</label>
          <div class="flex items-center gap-2.5 border border-bordc rounded-xl px-4 py-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2" class="w-4 h-4 shrink-0"><circle cx="12" cy="8" r="4"/><path d="M4 21v-1a6 6 0 016-6h4a6 6 0 016 6v1"/></svg>
            <input type="text" name="nama_lengkap" placeholder="Sesuai KTP" class="w-full text-[13.5px] outline-none placeholder:text-mutedc">
          </div>
        </div>
        <div>
          <label class="block text-[12.5px] font-semibold text-navy mb-1.5">Nomor WhatsApp</label>
          <div class="flex items-center gap-2.5 border border-bordc rounded-xl px-4 py-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2" class="w-4 h-4 shrink-0"><path d="M3 21l1.65-4.95A9 9 0 1112 21a8.96 8.96 0 01-4.95-1.5z"/></svg>
            <input type="tel" name="whatsapp" placeholder="08xxxxxxxxxx" class="w-full text-[13.5px] outline-none placeholder:text-mutedc">
          </div>
        </div>
        <div>
          <label class="block text-[12.5px] font-semibold text-navy mb-1.5">Email (Opsional)</label>
          <div class="flex items-center gap-2.5 border border-bordc rounded-xl px-4 py-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2" class="w-4 h-4 shrink-0"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
            <input type="email" name="email" placeholder="nama@email.com" class="w-full text-[13.5px] outline-none placeholder:text-mutedc">
          </div>
        </div>
        <div>
          <label class="block text-[12.5px] font-semibold text-navy mb-1.5">Tanggal Check-in</label>
          <div class="flex items-center gap-2.5 border border-bordc rounded-xl px-4 py-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2" class="w-4 h-4 shrink-0"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>
            <input type="date" id="checkinDate" name="tanggal_checkin" class="w-full text-[13.5px] outline-none text-navy">
          </div>
        </div>
      </div>

      <div class="dashed mb-6"></div>

      <!-- DETAIL PERJALANAN -->
      <div class="flex items-center gap-2 mb-4">
        <span class="w-1 h-4 bg-orange rounded-full"></span>
        <span class="font-bold text-[14px] text-navy">Detail Perjalanan</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 mb-6">
        <div>
          <label class="block text-[12.5px] font-semibold text-navy mb-1.5">Tipe Penginapan</label>
          <div class="flex items-center gap-2.5 border border-bordc rounded-xl px-4 py-3">
            <svg viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2" class="w-4 h-4 shrink-0"><path d="M3 18v-7a2 2 0 012-2h14a2 2 0 012 2v7M3 18h18M6 9V6a2 2 0 012-2h8a2 2 0 012 2v3"/></svg>
            <!-- Daftar diambil langsung dari data_homestay.php, otomatis sinkron
                 dengan homestay_madiun.php. Kalau ?id=... dikirim dari tombol
                 "Booking" di halaman list, opsinya otomatis ke-pilih. -->
            <select id="tipePenginapan" name="tipe_penginapan" class="w-full text-[13.5px] outline-none text-navy bg-white appearance-none">
              <option value="">Pilih homestay</option>
              <?php foreach ($homestay_madiun as $home): ?>
              <option
                value="<?= htmlspecialchars($home['id']) ?>"
                data-price="<?= (int)$home['harga'] ?>"
                data-jarak="<?= htmlspecialchars($home['jarak']) ?>"
                data-img="<?= htmlspecialchars($home['img']) ?>"
                <?= $selectedId === $home['id'] ? 'selected' : '' ?>
              >
                <?= htmlspecialchars($home['nama']) ?> &mdash; Rp <?= number_format($home['harga'], 0, ',', '.') ?>/malam
              </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>
        <div>
          <label class="block text-[12.5px] font-semibold text-navy mb-1.5">Durasi (Malam)</label>
          <div class="flex items-center gap-2 border border-bordc rounded-xl px-2 py-1.5">
            <button type="button" id="btnDurasiMin" class="w-9 h-9 rounded-lg bg-[#f2f3f8] flex items-center justify-center text-navy font-bold shrink-0">&#8722;</button>
            <span id="durasiValue" class="flex-1 text-center font-bold text-[14px] text-navy">1</span>
            <button type="button" id="btnDurasiPlus" class="w-9 h-9 rounded-lg bg-[#f2f3f8] flex items-center justify-center text-navy font-bold shrink-0">+</button>
          </div>
        </div>
      </div>

      <!-- RINGKASAN PEMESANAN -->
      <div class="bg-[#f6f7fb] rounded-2xl p-5 mb-6">
        <div class="flex items-center gap-2.5 font-extrabold text-[14px] text-navy mb-4">
          <svg viewBox="0 0 24 24" fill="none" stroke="#6d4de0" stroke-width="2" class="w-4 h-4"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/></svg>
          Ringkasan Pemesanan
        </div>

        <div class="flex items-start justify-between gap-4 mb-4">
          <div class="flex flex-col gap-2 text-[13px] text-navy">
            <div class="flex items-center gap-2">
              <svg viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2" class="w-4 h-4 shrink-0"><path d="M12 2C7.6 2 4 5.6 4 10c0 5.4 7 11.5 7.3 11.8.2.1.4.2.7.2s.5-.1.7-.2C13 21.5 20 15.4 20 10c0-4.4-3.6-8-8-8zm0 11c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/></svg>
              <span id="sumHomestay">Belum ada homestay dipilih</span>
            </div>
            <div class="flex items-center gap-2 text-mutedc" id="sumJarakWrap" style="display:none;">
              <svg viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2" class="w-4 h-4 shrink-0"><circle cx="12" cy="12" r="9"/></svg>
              <span id="sumJarak"></span>
            </div>
            <div class="flex items-center gap-2">
              <svg viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2" class="w-4 h-4 shrink-0"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>
              <span><span id="sumTanggal">Pilih tanggal</span> &ndash; <span id="sumDurasi">1</span> Malam</span>
            </div>
          </div>
          <img id="sumImg" src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=800" alt="Homestay" class="w-20 h-16 rounded-xl object-cover shrink-0">
        </div>

        <div class="dashed pt-4 flex items-center justify-between">
          <span class="font-bold text-[14px] text-navy">Total Pembayaran</span>
          <span id="totalBayar" class="font-extrabold text-[24px] text-orange">Rp 0</span>
        </div>
      </div>

      <!-- METODE PEMBAYARAN -->
      <div class="flex items-center gap-2 mb-4">
        <span class="w-1 h-4 bg-orange rounded-full"></span>
        <span class="font-bold text-[14px] text-navy">Metode Pembayaran</span>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-6">
        <label id="optOnline" class="metode-bayar-option flex items-center gap-3 border-2 border-orange bg-orange-light rounded-xl p-4 cursor-pointer">
          <input type="radio" name="metode_bayar" value="online" checked class="accent-orange">
          <div class="flex-1">
            <div class="font-semibold text-navy text-[13.5px]">Bayar Online Sekarang</div>
            <div class="text-[11.5px] text-mutedc">Transfer Bank / QRIS</div>
          </div>
          <span class="text-xl">💳</span>
        </label>
        <label id="optDitempat" class="metode-bayar-option flex items-center gap-3 border-2 border-bordc rounded-xl p-4 cursor-pointer">
          <input type="radio" name="metode_bayar" value="ditempat" class="accent-orange">
          <div class="flex-1">
            <div class="font-semibold text-navy text-[13.5px]">Bayar di Tempat</div>
            <div class="text-[11.5px] text-mutedc">Bayar saat check-in (cash)</div>
          </div>
          <span class="text-xl">🏠</span>
        </label>
      </div>

      <button type="submit" id="btnSubmit" class="w-full flex items-center justify-center gap-2.5 bg-gradient-to-r from-orange to-[#ff7a45] text-white font-bold py-4 rounded-2xl text-[15px] hover:brightness-105 active:scale-[0.99] transition disabled:opacity-60">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px]"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V7a4 4 0 018 0v4"/></svg>
        <span id="btnSubmitText">PESAN SEKARANG</span>
        <span class="text-white/80 font-normal text-[11.5px] hidden sm:inline">&nbsp;&middot; Aman, cepat, dan mudah</span>
      </button>
    </form>

  </div>
</div>

        </div>
    </main>
</div>

<script>
  const tipeSelect    = document.getElementById('tipePenginapan');
  const durasiValue   = document.getElementById('durasiValue');
  const btnMin        = document.getElementById('btnDurasiMin');
  const btnPlus       = document.getElementById('btnDurasiPlus');
  const totalBayarEl  = document.getElementById('totalBayar');
  const sumDurasiEl   = document.getElementById('sumDurasi');
  const sumTanggalEl  = document.getElementById('sumTanggal');
  const sumHomestayEl = document.getElementById('sumHomestay');
  const sumJarakEl    = document.getElementById('sumJarak');
  const sumJarakWrap  = document.getElementById('sumJarakWrap');
  const sumImgEl      = document.getElementById('sumImg');
  const checkinInput  = document.getElementById('checkinDate');

  let durasi = 1;

  function formatRp(n){
    return "Rp " + n.toLocaleString('id-ID');
  }

  function updateRingkasan(){
    const opt = tipeSelect.options[tipeSelect.selectedIndex];
    const hargaPerMalam = opt ? (parseInt(opt.dataset.price) || 0) : 0;

    if (opt && opt.value !== '') {
      sumHomestayEl.textContent = opt.textContent.split(' — ')[0].trim();
      sumJarakEl.textContent = opt.dataset.jarak || '';
      sumJarakWrap.style.display = opt.dataset.jarak ? 'flex' : 'none';
      if (opt.dataset.img) sumImgEl.src = opt.dataset.img;
    } else {
      sumHomestayEl.textContent = 'Belum ada homestay dipilih';
      sumJarakWrap.style.display = 'none';
    }

    totalBayarEl.textContent = formatRp(hargaPerMalam * durasi);
  }

  btnMin.addEventListener('click', () => {
    if(durasi > 1) durasi--;
    durasiValue.textContent = durasi;
    sumDurasiEl.textContent = durasi;
    updateRingkasan();
  });

  btnPlus.addEventListener('click', () => {
    durasi++;
    durasiValue.textContent = durasi;
    sumDurasiEl.textContent = durasi;
    updateRingkasan();
  });

  tipeSelect.addEventListener('change', updateRingkasan);

  checkinInput.addEventListener('change', () => {
    if(checkinInput.value){
      const d = new Date(checkinInput.value + 'T00:00:00');
      sumTanggalEl.textContent = d.toLocaleDateString('id-ID', { day:'2-digit', month:'short', year:'numeric' });
    }
  });

  updateRingkasan();

  // toggle highlight pilihan metode bayar
  document.querySelectorAll('.metode-bayar-option').forEach(function (label) {
    label.addEventListener('click', function () {
      document.querySelectorAll('.metode-bayar-option').forEach(function (l) {
        l.classList.remove('border-orange', 'bg-orange-light');
        l.classList.add('border-bordc');
      });
      this.classList.remove('border-bordc');
      this.classList.add('border-orange', 'bg-orange-light');
    });
  });

  // SUBMIT — kirim ke backend proses_booking.php
  const btnSubmit = document.getElementById('btnSubmit');
  const btnSubmitText = document.getElementById('btnSubmitText');

  document.getElementById('formReservasi').addEventListener('submit', function(e){
    e.preventDefault();

    const nama = this.nama_lengkap.value.trim();
    const wa   = this.whatsapp.value.trim();
    const tanggal = this.tanggal_checkin.value;
    const homestayId = this.tipe_penginapan.value;
    const metodeBayar = this.metode_bayar.value; // 'online' atau 'ditempat'

    if(!nama || !wa || !tanggal || !homestayId){
      alert('Mohon lengkapi semua data yang wajib diisi.');
      return;
    }

    const payload = {
      nama_lengkap: nama,
      whatsapp: wa,
      email: this.email.value.trim(),
      tanggal_checkin: tanggal,
      homestay_id: homestayId,
      durasi_malam: durasi,
      metode_bayar: metodeBayar
      // total_bayar SENGAJA tidak dikirim -> dihitung ulang di server
      // (proses_booking.php) supaya harga tidak bisa dimanipulasi dari client.
    };

    btnSubmit.disabled = true;
    btnSubmitText.textContent = 'Memproses...';

    fetch('proses_booking.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload)
    })
      .then(res => res.text().then(text => ({ status: res.status, text })))
      .then(({ status, text }) => {
        let data;
        try {
          data = JSON.parse(text);
        } catch (parseErr) {
          // Server tidak membalas JSON valid -> biasanya error PHP.
          // Tampilkan isi responsnya biar kelihatan penyebab aslinya.
          console.error('Respon server bukan JSON. Status:', status, 'Isi:', text);
          alert('Server error (status ' + status + '). Buka Console (F12) untuk detail lengkap.\n\nCuplikan respon:\n' + text.substring(0, 300));
          btnSubmit.disabled = false;
          btnSubmitText.textContent = 'PESAN SEKARANG';
          return;
        }

        if (data.ok && data.redirect) {
          window.location.href = data.redirect;
        } else {
          alert(data.message || 'Terjadi kesalahan, silakan coba lagi.');
          btnSubmit.disabled = false;
          btnSubmitText.textContent = 'PESAN SEKARANG';
        }
      })
      .catch((err) => {
        console.error('Fetch gagal total:', err);
        alert('Gagal menghubungi server (kemungkinan salah alamat/path proses_booking.php). Detail di Console (F12).');
        btnSubmit.disabled = false;
        btnSubmitText.textContent = 'PESAN SEKARANG';
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
</script>

</body>
</html>