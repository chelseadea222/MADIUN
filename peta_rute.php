<?php
session_start();

// Halaman ini hanya boleh diakses oleh member yang sudah login (konsisten dengan dashboard_user.php)
if (!isset($_SESSION['user_id']) || !isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit;
}

$id_user_login = $_SESSION['user_id'];
require_once 'koneksi.php';

// ===== Data user (dipakai untuk sidebar & header, sama seperti halaman lain) =====
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

// ===== Menu navigasi (identik dengan dashboard_user.php, "Peta & Rute" aktif) =====
$menu = [
    ['icon' => 'home', 'label' => 'Beranda', 'link' => 'dashboard_user.php'],
    ['icon' => 'map-pin', 'label' => 'Destinasi', 'link' => 'destinasi_user.php'],
    ['icon' => 'ticket', 'label' => 'Tiket Saya', 'link' => 'beli_tiket.php'],
    ['icon' => 'building', 'label' => 'Homestay Saya', 'link' => 'booking.php'],
    ['icon' => 'map', 'label' => 'Peta & Rute', 'active' => true, 'link' => 'peta_rute.php'],
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
        'bell' => '<path d="M6 8a6 6 0 0 1 12 0c0 5 2 6 2 6H4s2-1 2-6"/><path d="M10 21a2 2 0 0 0 4 0"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
    ];
    $path = $icons[$name] ?? '';
    return "<svg width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"{$color}\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">{$path}</svg>";
}

// Data Koordinat Destinasi di Madiun & Sekitarnya
$destinasi_madiun = [
    ["nama" => "Pahlawan Street Center (PSC)", "lat" => "-7.6273", "lon" => "111.5244"],
    ["nama" => "Taman Sumber Umis", "lat" => "-7.6268", "lon" => "111.5239"],
    ["nama" => "Alun-Alun Kota Madiun", "lat" => "-7.6293", "lon" => "111.5231"],
    ["nama" => "Taman Bantaran Kali Madiun", "lat" => "-7.6200", "lon" => "111.5180"],
    ["nama" => "Monumen Kresek", "lat" => "-7.6583", "lon" => "111.6038"],
    ["nama" => "Madiun Umbul Square", "lat" => "-7.7475", "lon" => "111.5306"],
    ["nama" => "Waduk Bening Widas", "lat" => "-7.5458", "lon" => "111.7833"],
    ["nama" => "Ngrowo Bening Edupark", "lat" => "-7.6433", "lon" => "111.5361"],
    ["nama" => "Hutan Pinus NONGKO IJO", "lat" => "-7.7289", "lon" => "111.6667"]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MadiunTrack - Peta & Rute</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brand: '#0e7490', brandDark: '#083344', accent: '#ea580c' }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Scrollbar styling untuk panel kiri */
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
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

        <div class="flex-1 flex flex-col lg:flex-row min-h-0">

            <div class="w-full lg:w-[400px] xl:w-[450px] bg-white flex-none border-r border-slate-200 z-10 overflow-y-auto custom-scroll p-6 lg:p-8">
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-brandDark mb-1">Navigasi Rute</h2>
                    <p class="text-slate-500 text-sm">Cari jalur terbaik ke destinasi impianmu.</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Lokasi Awal (Titik Jemput)</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400"><i class="bi bi-geo-fill"></i></span>
                            <input type="text" id="input_asal" placeholder="Ketik Desa, Kecamatan, Kota..."
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 pl-11 pr-4 text-sm font-semibold text-slate-700 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 transition-all">
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Destinasi Wisata</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-accent"><i class="bi bi-geo-alt-fill"></i></span>
                            <select id="input_tujuan" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 pl-11 pr-10 text-sm font-semibold text-slate-700 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 transition-all appearance-none cursor-pointer">
                                <option value="" disabled selected>-- Pilih Lokasi Wisata --</option>
                                <?php foreach($destinasi_madiun as $dest): ?>
                                    <option value="<?= $dest['lat'] ?>,<?= $dest['lon'] ?>"><?= $dest['nama'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 pointer-events-none"><i class="bi bi-chevron-down"></i></span>
                        </div>
                    </div>

                    <button id="btn-cek" onclick="hitungRute()" class="w-full bg-brand hover:bg-brandDark text-white font-bold py-4 rounded-xl shadow-lg shadow-brand/20 transition-all active:scale-95 flex items-center justify-center gap-2">
                        Tampilkan Peta Rute <i class="bi bi-map-fill"></i>
                    </button>
                </div>

                <div id="info_hasil" class="hidden mt-8 space-y-4 pt-8 border-t border-slate-100">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Info Tujuan</h3>

                    <div class="bg-gradient-to-br from-orange-50 to-amber-50 p-5 rounded-2xl border border-orange-100 flex items-center gap-5 relative overflow-hidden">
                        <div class="w-14 h-14 rounded-full bg-white shadow-sm flex items-center justify-center shrink-0 z-10 relative">
                            <img id="icon_cuaca" src="" alt="cuaca" class="w-10 h-10">
                        </div>
                        <div class="z-10 relative">
                            <h4 class="text-2xl font-black text-brandDark leading-none" id="hasil_suhu">- °C</h4>
                            <p class="text-[11px] font-bold text-accent mt-1 uppercase tracking-wider" id="hasil_cuaca_desc">Menganalisis...</p>
                        </div>
                    </div>

                    <a id="btn-gmaps" href="#" target="_blank" class="w-full flex items-center justify-between bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
                        <span class="flex items-center gap-3">
                            <i class="bi bi-phone"></i> Navigasi via HP
                        </span>
                        <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div class="w-full h-[60vh] lg:h-auto lg:flex-1 relative bg-slate-200 z-0">
                <div id="map" class="absolute inset-0 w-full h-full"></div>

                <div id="pesan_awal" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-100/90 backdrop-blur-sm z-20 text-slate-500">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-md mb-4 animate-bounce">
                        <i class="bi bi-map text-4xl text-brand/50"></i>
                    </div>
                    <p class="font-black text-lg text-slate-700">Peta Belum Tersedia</p>
                    <p class="text-sm mt-1">Masukkan lokasi awal untuk menampilkan rute.</p>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
async function hitungRute() {
    const asal = document.getElementById('input_asal').value.trim();
    const tujuanSelect = document.getElementById('input_tujuan');

    if (asal === "") { alert("Mohon ketik lokasi awal Anda!"); return; }
    if (tujuanSelect.value === "") { alert("Mohon pilih destinasi wisata!"); return; }

    const destNama = tujuanSelect.options[tujuanSelect.selectedIndex].text;
    const [destLat, destLon] = tujuanSelect.value.split(',');
    const btn = document.getElementById('btn-cek');
    const infoHasil = document.getElementById('info_hasil');

    btn.innerHTML = `<i class="bi bi-hourglass-split animate-spin"></i> Memuat Data...`;
    btn.disabled = true;

    try {
        // Sembunyikan pesan awal
        document.getElementById('pesan_awal').style.display = 'none';

        // 1. TAMPILKAN IFRAME GOOGLE MAPS
        const mapContainer = document.getElementById('map');
        const originQuery = encodeURIComponent(asal + ", Indonesia");
        // Syntax URL ini adalah trik untuk langsung menggambar rute biru di iframe embed maps
        const gmapsIframeUrl = `https://maps.google.com/maps?saddr=${originQuery}&daddr=${destLat},${destLon}&output=embed`;

        mapContainer.innerHTML = `<iframe width="100%" height="100%" frameborder="0" style="border:0;" src="${gmapsIframeUrl}" allowfullscreen></iframe>`;

        // 2. FETCH CUACA TUJUAN
        let suhu = "30";
        let cuacaDesc = "Cerah Berawan";
        let iconCuacaId = "02d";

        try {
            const API_KEY = "c4752a971021db39a254799794cedd5b";
            const weatherRes = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${destLat}&lon=${destLon}&appid=${API_KEY}&units=metric&lang=id`);

            if(weatherRes.ok) {
                const weatherData = await weatherRes.json();
                if(weatherData.main && weatherData.weather) {
                    suhu = Math.round(weatherData.main.temp);
                    cuacaDesc = weatherData.weather[0].description;
                    iconCuacaId = weatherData.weather[0].icon;
                }
            }
        } catch (e) {
            console.warn("Gagal load API cuaca, menggunakan data default.");
        }

        // Update UI Cuaca
        document.getElementById('hasil_suhu').innerText = `${suhu} °C`;
        document.getElementById('hasil_cuaca_desc').innerText = cuacaDesc;
        document.getElementById('icon_cuaca').src = `https://openweathermap.org/img/wn/${iconCuacaId}.png`;

        // 3. UPDATE LINK TOMBOL HP
        const gmapsAppUrl = `https://www.google.com/maps/dir/?api=1&origin=${originQuery}&destination=${destLat},${destLon}&travelmode=driving`;
        document.getElementById('btn-gmaps').href = gmapsAppUrl;

        // Munculkan panel hasil
        infoHasil.classList.remove('hidden');

        // 4. EFEK SCROLL OTOMATIS (KHUSUS MOBILE)
        // Jika layar kecil (HP), otomatis scroll ke bawah menuju peta setelah loading selesai
        if(window.innerWidth < 1024) {
            setTimeout(() => {
                document.getElementById('map').scrollIntoView({ behavior: 'smooth' });
            }, 500);
        }

    } catch (error) {
        alert("Terjadi kesalahan, pastikan koneksi internet Anda stabil.");
    } finally {
        btn.innerHTML = `Tampilkan Peta Rute <i class="bi bi-map-fill"></i>`;
        btn.disabled = false;
    }
}

// ===== Toggle Sidebar Mobile =====
document.addEventListener('DOMContentLoaded', function () {
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