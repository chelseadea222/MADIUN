<?php
/**
 * MadiunTrack - Dashboard Admin
 * Diselaraskan dengan gaya desain di folder user/ (Tailwind, brand biru, font default)
 */

session_start();

// ===== Dummy data (nantinya bisa diganti dengan query database, sama seperti dashboard_user.php) =====
$admin = [
    'nama' => 'Admin',
    'role' => 'Super Admin',
];

$menu = [
    ['icon' => 'home', 'label' => 'Dashboard', 'link' => 'dashboard_admin.php'],
    ['icon' => 'ticket', 'label' => 'Tiket Wisata', 'link' => 'tiket_wisata.php'],
    ['icon' => 'map-pin', 'label' => 'Destinasi Wisata', 'link' => '#'],
    ['icon' => 'home', 'label' => 'Homestay', 'link' => 'homestay_admin.php'],
    ['icon' => 'user', 'label' => 'Pengguna', 'active' => true, 'link' => 'pengguna_admin.php'],
];

$menu_bawah = [
    ['icon' => 'settings', 'label' => 'Pengaturan', 'link' => 'pengaturan.php'],
];

function icon($name, $size = 20, $color = 'currentColor')
{
    $icons = [
        'home'       => '<path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1Z"/>',
        'map-pin'    => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'ticket'     => '<path d="M3 9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v1.5a1.5 1.5 0 0 0 0 3V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1.5a1.5 1.5 0 0 0 0-3V9Z"/><path d="M9 7v10" stroke-dasharray="3 3"/>',
        'building'   => '<rect x="4" y="3" width="16" height="18" rx="1"/><path d="M9 8h.01M15 8h.01M9 12h.01M15 12h.01M9 16h.01M15 16h.01"/>',
        'user'       => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4.5-6 8-6s7 2 8 6"/>',
        'settings'   => '<circle cx="12" cy="12" r="3"/><path d="M19.4 13a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.9 2.9l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V19a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.9-2.9l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1H4a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.9 2.9l.1.1a1.7 1.7 0 0 0 1.9.3H10a1.7 1.7 0 0 0 1-1.6V4a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.9 2.9l-.1.1a1.7 1.7 0 0 0-.3 1.9V10a1.7 1.7 0 0 0 1.6 1H20a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.6 1Z"/>',
        'logout'     => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'bell'       => '<path d="M6 8a6 6 0 0 1 12 0c0 5 2 6 2 6H4s2-1 2-6"/><path d="M10 21a2 2 0 0 0 4 0"/>',
        'star'       => '<path d="m12 2 2.9 6.4 7 .7-5.3 4.7 1.6 6.9L12 17.3 5.8 20.7l1.6-6.9L2.1 9.1l7-.7Z"/>',
        'book-open'  => '<path d="M12 7c-2-2-5-2-9-1v13c4-1 7-1 9 1 2-2 5-2 9-1V6c-4-1-7-1-9 1Z"/><path d="M12 7v13"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'chevron-right'=> '<path d="m9 18 6-6-6-6"/>',
        'arrow-right'=> '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
        'eye'        => '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/>',
        'chart'      => '<path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/>',
        'download'   => '<path d="M12 3v12M7 10l5 5 5-5"/><path d="M5 21h14"/>',
        'file-text'  => '<path d="M6 2h9l5 5v15H6z"/><path d="M15 2v5h5"/><path d="M9 13h6M9 17h6"/>',
        'clock'      => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>',
        'menu'       => '<path d="M4 6h16M4 12h16M4 18h16"/>',
        'x'          => '<path d="M18 6 6 18M6 6l12 12"/>',
    ];
    $path = $icons[$name] ?? '';
    return "<svg width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"{$color}\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">{$path}</svg>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MadiunTrack - Kelola Pengguna</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer components {
            .pill-selesai { @apply bg-green-100 text-green-700; }
            .pill-diproses { @apply bg-amber-100 text-amber-700; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased m-0">

<div class="flex min-h-screen">

    <!-- Overlay gelap, tampil saat sidebar terbuka di mobile -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden"></div>

    <aside id="sidebar" class="w-64 bg-white border-r border-slate-200 flex-col p-5 shrink-0 flex fixed md:static inset-y-0 left-0 z-40 -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out overflow-y-auto">
        <div class="flex items-center justify-between px-2 pb-6">
            <div class="flex items-center gap-2.5 text-lg font-bold">
                <span class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center"><?= icon('map-pin', 18, '#fff') ?></span>
                <span>Madiun<span class="text-blue-700">Track</span></span>
            </div>
            <button onclick="toggleSidebar()" class="md:hidden text-slate-400 hover:text-slate-700 bg-transparent border-none cursor-pointer">
                <?= icon('x', 20) ?>
            </button>
        </div>

        <div class="text-[11px] font-bold text-slate-400 tracking-wider px-3 mb-2">MANAJEMEN</div>

        <nav class="flex flex-col gap-1">
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

        <div class="text-[11px] font-bold text-slate-400 tracking-wider px-3 mt-5 mb-2">PENGATURAN</div>

        <nav class="flex flex-col gap-1 flex-1">
            <?php foreach ($menu_bawah as $item): ?>
                <?php
                $baseStyleB = "flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors";
                $activeStyleB = !empty($item['active'])
                    ? "$baseStyleB bg-blue-700 text-white shadow-sm"
                    : "$baseStyleB text-slate-500 hover:bg-slate-50 hover:text-slate-900";
                ?>
                <a href="<?= htmlspecialchars($item['link']) ?>" class="<?= $activeStyleB ?>">
                    <?= icon($item['icon'], 18) ?>
                    <span><?= htmlspecialchars($item['label']) ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="border-t border-slate-200 pt-3 mt-2">
            <a href="logout.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 text-sm font-medium transition-colors hover:bg-red-50 hover:text-red-600">
                <?= icon('logout', 18) ?>
                <span>Keluar</span>
            </a>
        </div>

        <div class="mt-4 bg-gradient-to-br from-blue-900 to-blue-700 rounded-2xl p-4 text-white">
            <h4 class="text-sm font-bold mb-1.5 mt-0">Kelola Wisata Madiun</h4>
            <p class="text-[12px] text-white/85 leading-relaxed m-0">Pantau data, kelola layanan, dan tingkatkan pengalaman wisatawan.</p>
        </div>
    </aside>

    <main class="flex-1 min-w-0 flex flex-col">

        <header class="flex justify-between items-center px-4 md:px-7 py-4 border-b border-slate-200 bg-white sticky top-0 z-20">
            <button onclick="toggleSidebar()" class="md:hidden text-slate-500 hover:text-slate-700 bg-transparent border-none cursor-pointer p-1">
                <?= icon('menu', 24) ?>
            </button>
            <div class="flex items-center gap-4">
                <span class="bg-blue-50 text-blue-700 font-bold text-[11px] px-3.5 py-2 rounded-full">MODE ADMIN</span>
                <button class="relative text-slate-500 hover:text-slate-700 bg-transparent border-none cursor-pointer">
                    <?= icon('bell', 19) ?>
                    <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border-2 border-white">3</span>
                </button>
                <div class="flex items-center gap-2.5 pl-3 border-l border-slate-200 text-sm text-slate-500 cursor-pointer">
                    <div class="w-9 h-9 rounded-full bg-blue-700 flex items-center justify-center text-white font-bold text-[13px]">A</div>
                    <div>
                        <div class="font-semibold text-slate-900 leading-tight"><?= htmlspecialchars($admin['nama']) ?></div>
                        <div class="text-[11px] text-slate-500"><?= htmlspecialchars($admin['role']) ?></div>
                    </div>
                    <?= icon('chevron-down', 16) ?>
                </div>
            </div>
        </header>
<?php
// ===== Dummy data pengguna (backup/tarikan data akun dari sisi user) =====
$stat_pengguna = [
    ['icon' => 'user',    'warna_bg' => 'bg-purple-100', 'warna_icon' => 'text-purple-600', 'label' => 'TOTAL PENGGUNA',     'nilai' => '1.256'],
    ['icon' => 'star',    'warna_bg' => 'bg-green-100',  'warna_icon' => 'text-green-600',  'label' => 'PENGGUNA AKTIF',     'nilai' => '1.198'],
    ['icon' => 'clock',   'warna_bg' => 'bg-amber-100',  'warna_icon' => 'text-amber-600',  'label' => 'BARU BULAN INI',     'nilai' => '58'],
    ['icon' => 'x',       'warna_bg' => 'bg-red-100',    'warna_icon' => 'text-red-600',    'label' => 'NONAKTIF/DIBLOKIR',  'nilai' => '58'],
];

$pengguna_all = [
    ['id' => 'U001', 'nama' => 'Rara Anindya',    'email' => 'rara@gmail.com',     'hp' => '0812-3456-7801', 'daftar' => '12 Jan 2026', 'transaksi' => 6, 'status' => 'Aktif'],
    ['id' => 'U002', 'nama' => 'Budi Santoso',    'email' => 'budi.s@gmail.com',   'hp' => '0813-2211-9087', 'daftar' => '03 Feb 2026', 'transaksi' => 3, 'status' => 'Aktif'],
    ['id' => 'U003', 'nama' => 'Siti Aisyah',     'email' => 'siti.aisyah@yahoo.com','hp' => '0857-6634-2210', 'daftar' => '20 Feb 2026', 'transaksi' => 2, 'status' => 'Aktif'],
    ['id' => 'U004', 'nama' => 'Dewi Lestari',    'email' => 'dewi.lestari@gmail.com','hp' => '0821-4478-3321', 'daftar' => '05 Mar 2026', 'transaksi' => 8, 'status' => 'Aktif'],
    ['id' => 'U005', 'nama' => 'Andi Pratama',    'email' => 'andi.p@gmail.com',   'hp' => '0895-3322-1187', 'daftar' => '18 Mar 2026', 'transaksi' => 1, 'status' => 'Nonaktif'],
    ['id' => 'U006', 'nama' => 'Rizky Maulana',   'email' => 'rizky.m@gmail.com',  'hp' => '0878-1122-3345', 'daftar' => '22 Apr 2026', 'transaksi' => 4, 'status' => 'Aktif'],
    ['id' => 'U007', 'nama' => 'Putri Wulandari', 'email' => 'putri.w@gmail.com',  'hp' => '0812-9988-7766', 'daftar' => '30 Apr 2026', 'transaksi' => 0, 'status' => 'Diblokir'],
];
?>
        <div class="p-4 md:p-7">

            <div class="flex items-center justify-between flex-wrap gap-3 mb-1">
                <div>
                    <h1 class="text-2xl font-semibold m-0 mb-1 text-slate-900">Kelola Pengguna</h1>
                    <p class="text-slate-500 text-sm m-0">Data akun pengguna yang terdaftar dari halaman user (backup data user).</p>
                </div>
                <button class="flex items-center gap-2 py-2.5 px-4 rounded-xl font-semibold text-[13px] text-white bg-blue-700 hover:bg-blue-800 transition-colors cursor-pointer">
                    <?= icon('download', 15, '#fff') ?> Backup Data Pengguna
                </button>
            </div>

            <!-- STAT CARDS -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 my-6">
                <?php foreach ($stat_pengguna as $c): ?>
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex gap-3.5 items-start">
                        <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 <?= $c['warna_bg'] ?> <?= $c['warna_icon'] ?>">
                            <?= icon($c['icon'], 20) ?>
                        </span>
                        <div class="min-w-0">
                            <div class="text-[11px] font-bold text-slate-400 tracking-wide mb-1.5"><?= $c['label'] ?></div>
                            <div class="text-xl font-bold text-slate-900"><?= $c['nilai'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- TABEL PENGGUNA -->
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                    <div class="flex items-center gap-2.5 font-semibold text-[15px]">
                        <span class="w-9 h-9 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center"><?= icon('user', 16) ?></span>
                        Data Akun Pengguna
                    </div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <input type="text" placeholder="Cari nama / email pengguna..." class="text-[13px] border border-slate-200 rounded-lg px-3 py-2 outline-none focus:border-blue-400 w-56">
                        <select class="text-[13px] border border-slate-200 rounded-lg px-3 py-2 outline-none bg-white">
                            <option>Semua Status</option>
                            <option>Aktif</option>
                            <option>Nonaktif</option>
                            <option>Diblokir</option>
                        </select>
                    </div>
                </div>
                <div class="overflow-x-auto">
                <table class="w-full border-collapse text-[13px] min-w-[860px]">
                    <thead>
                        <tr class="text-left">
                            <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">ID</th>
                            <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Nama</th>
                            <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Email</th>
                            <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">No. HP</th>
                            <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Tgl Daftar</th>
                            <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Transaksi</th>
                            <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Status</th>
                            <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pengguna_all as $p): ?>
                            <?php
                            $pill = 'pill-selesai';
                            if ($p['status'] === 'Nonaktif') $pill = 'pill-diproses';
                            elseif ($p['status'] === 'Diblokir') $pill = 'bg-red-100 text-red-600';
                            ?>
                            <tr>
                                <td class="py-3.5 px-2.5 border-b border-slate-100 text-slate-500">#<?= htmlspecialchars($p['id']) ?></td>
                                <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= htmlspecialchars($p['nama']) ?></td>
                                <td class="py-3.5 px-2.5 border-b border-slate-100 text-slate-600"><?= htmlspecialchars($p['email']) ?></td>
                                <td class="py-3.5 px-2.5 border-b border-slate-100 text-slate-600"><?= htmlspecialchars($p['hp']) ?></td>
                                <td class="py-3.5 px-2.5 border-b border-slate-100 text-slate-600"><?= htmlspecialchars($p['daftar']) ?></td>
                                <td class="py-3.5 px-2.5 border-b border-slate-100 text-slate-800"><?= (int)$p['transaksi'] ?></td>
                                <td class="py-3.5 px-2.5 border-b border-slate-100">
                                    <span class="text-[11px] font-semibold px-3 py-1.5 rounded-full inline-block <?= $pill ?>"><?= strtoupper($p['status']) ?></span>
                                </td>
                                <td class="py-3.5 px-2.5 border-b border-slate-100">
                                    <div class="flex gap-1.5">
                                        <a href="#" title="Lihat Detail" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center"><?= icon('eye', 15) ?></a>
                                        <a href="#" title="Blokir/Aktifkan" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center"><?= icon('settings', 15) ?></a>
                                        <a href="#" title="Hapus Data" class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center"><?= icon('x', 15) ?></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
  // Toggle sidebar mobile (buka/tutup drawer menu + overlay)
  function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('sidebarOverlay').classList.toggle('hidden');
  }
</script>

</body>
</html>