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
    ['icon' => 'home',     'label' => 'Dashboard',             'active' => true, 'link' => 'dashboard_admin.php'],
    ['icon' => 'ticket',   'label' => 'Tiket Wisata',           'link' => '#'],
    ['icon' => 'building', 'label' => 'Reservasi Penginapan',   'link' => '#'],
    ['icon' => 'map-pin',  'label' => 'Destinasi Wisata',       'link' => '#'],
    ['icon' => 'home',     'label' => 'Homestay',               'link' => '#'],
    ['icon' => 'user',     'label' => 'Pengguna',               'link' => '#'],
    ['icon' => 'star',     'label' => 'Ulasan',                 'link' => '#'],
    ['icon' => 'book-open','label' => 'Laporan',                'link' => '#'],
];

$menu_bawah = [
    ['icon' => 'settings', 'label' => 'Pengaturan', 'link' => '#'],
    ['icon' => 'user',     'label' => 'Akun Admin', 'link' => '#'],
];

$stat_cards = [
    [
        'icon' => 'ticket', 'warna_bg' => 'bg-orange-100', 'warna_icon' => 'text-orange-600',
        'label' => 'TIKET WISATA TERJUAL', 'nilai' => '128', 'naik' => '24.5%', 'ket' => '+25 dari bulan lalu',
    ],
    [
        'icon' => 'building', 'warna_bg' => 'bg-blue-100', 'warna_icon' => 'text-blue-700',
        'label' => 'RESERVASI PENGINAPAN', 'nilai' => '42', 'naik' => '18.7%', 'ket' => '+9 dari bulan lalu',
    ],
    [
        'icon' => 'user', 'warna_bg' => 'bg-purple-100', 'warna_icon' => 'text-purple-600',
        'label' => 'TOTAL PENGUNJUNG', 'nilai' => '1.256', 'naik' => '31.2%', 'ket' => '+298 dari bulan lalu',
    ],
    [
        'icon' => 'chart', 'warna_bg' => 'bg-green-100', 'warna_icon' => 'text-green-600',
        'label' => 'PENDAPATAN TOTAL', 'nilai' => 'Rp12.450.000', 'naik' => '22.1%', 'ket' => '+Rp2.250.000 dari bulan lalu',
    ],
];

$tickets = [
    ['nama' => 'Rara',           'dest' => 'Pahlawan Street Center (PSC)',   'tgl' => '26 Mei 2026', 'jml' => 2, 'total' => 'Rp40.000', 'status' => 'Diproses'],
    ['nama' => 'Budi Santoso',   'dest' => 'Taman Bantaran Kali Madiun',     'tgl' => '25 Mei 2026', 'jml' => 4, 'total' => 'Rp80.000', 'status' => 'Selesai'],
    ['nama' => 'Siti Aisyah',    'dest' => 'Taman Sumber Umis',              'tgl' => '25 Mei 2026', 'jml' => 2, 'total' => 'Rp40.000', 'status' => 'Diproses'],
    ['nama' => 'Dewi Lestari',   'dest' => 'Alun-Alun Kota Madiun',          'tgl' => '24 Mei 2026', 'jml' => 3, 'total' => 'Rp60.000', 'status' => 'Selesai'],
    ['nama' => 'Andi Pratama',   'dest' => 'Pahlawan Street Center (PSC)',   'tgl' => '24 Mei 2026', 'jml' => 2, 'total' => 'Rp40.000', 'status' => 'Diproses'],
];

$ringkasan = [
    ['icon' => 'ticket',   'warna_bg' => 'bg-orange-100', 'warna_icon' => 'text-orange-600', 'label' => 'Tiket Terjual',       'nilai' => '18'],
    ['icon' => 'building', 'warna_bg' => 'bg-blue-100',   'warna_icon' => 'text-blue-700',   'label' => 'Reservasi Penginapan', 'nilai' => '6'],
    ['icon' => 'user',     'warna_bg' => 'bg-purple-100', 'warna_icon' => 'text-purple-600', 'label' => 'Pengunjung Baru',      'nilai' => '52'],
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
    ];
    $path = $icons[$name] ?? '';
    return "<svg width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"{$color}\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">{$path}</svg>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>MadiunTrack - Dashboard Admin</title>
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

    <aside class="w-60 bg-white border-r border-slate-200 flex-col p-5 shrink-0 hidden md:flex">
        <div class="flex items-center gap-2.5 px-2 pb-6 text-lg font-bold">
            <span class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center"><?= icon('map-pin', 18, '#fff') ?></span>
            <span>Madiun<span class="text-blue-700">Track</span></span>
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
                <a href="<?= htmlspecialchars($item['link']) ?>" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors">
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

        <header class="flex justify-between items-center px-7 py-4 border-b border-slate-200 bg-white sticky top-0 z-20">
            <div></div>
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

        <div class="p-4 md:p-7">

            <h1 class="text-2xl font-semibold m-0 mb-1 text-slate-900">Dashboard Admin</h1>
            <p class="text-slate-500 text-sm m-0 mb-6">Pantau data operasional, perbarui status, dan ekspor data pengunjung.</p>

            <!-- STAT CARDS -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <?php foreach ($stat_cards as $c): ?>
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm flex gap-3.5 items-start">
                        <span class="w-11 h-11 rounded-xl flex items-center justify-center shrink-0 <?= $c['warna_bg'] ?> <?= $c['warna_icon'] ?>">
                            <?= icon($c['icon'], 20) ?>
                        </span>
                        <div class="min-w-0">
                            <div class="text-[11px] font-bold text-slate-400 tracking-wide mb-1.5"><?= $c['label'] ?></div>
                            <div class="flex items-baseline gap-2 flex-wrap">
                                <div class="text-xl font-bold text-slate-900"><?= $c['nilai'] ?></div>
                                <div class="text-xs font-semibold text-green-600">&#8599; <?= $c['naik'] ?></div>
                            </div>
                            <div class="text-[11.5px] text-slate-500 mt-1"><?= $c['ket'] ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- CHARTS -->
            <div class="grid grid-cols-1 xl:grid-cols-[1.35fr_1fr] gap-4 mb-6 items-start">
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3.5">
                        <h3 class="text-[15px] font-semibold m-0">Tren Transaksi Bulanan</h3>
                        <span class="text-xs font-semibold text-slate-500 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg flex items-center gap-2 cursor-pointer">
                            6 Bulan Terakhir <?= icon('chevron-down', 12) ?>
                        </span>
                    </div>
                    <div class="h-[230px] relative"><canvas id="lineChart"></canvas></div>
                </div>

                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-3.5">
                        <h3 class="text-[15px] font-semibold m-0">Pengunjung per Bulan</h3>
                        <span class="text-xs font-semibold text-slate-500 bg-slate-50 border border-slate-200 px-3 py-1.5 rounded-lg flex items-center gap-2 cursor-pointer">
                            6 Bulan Terakhir <?= icon('chevron-down', 12) ?>
                        </span>
                    </div>
                    <div class="h-[230px] relative"><canvas id="barChart"></canvas></div>
                </div>
            </div>

            <!-- BOTTOM -->
            <div class="grid grid-cols-1 xl:grid-cols-[1.75fr_1fr] gap-4 items-start">
                <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                        <div class="flex items-center gap-2.5 font-semibold text-[15px]">
                            <span class="w-9 h-9 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center"><?= icon('ticket', 16) ?></span>
                            Tiket Wisata Terbaru
                        </div>
                        <a href="#" class="text-[12.5px] font-semibold text-blue-700 bg-blue-50 px-3.5 py-2 rounded-lg flex items-center gap-1.5">
                            Lihat Semua <?= icon('chevron-right', 12) ?>
                        </a>
                    </div>
                    <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-[13px] min-w-[600px]">
                        <thead>
                            <tr class="text-left">
                                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Nama Pembeli</th>
                                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Destinasi</th>
                                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Tanggal</th>
                                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Jumlah</th>
                                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Total</th>
                                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Status</th>
                                <th class="text-[11px] font-bold text-slate-400 tracking-wide px-2.5 pb-3 border-b border-slate-200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tickets as $t): ?>
                                <?php $pill = $t['status'] === 'Selesai' ? 'pill-selesai' : 'pill-diproses'; ?>
                                <tr>
                                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= htmlspecialchars($t['nama']) ?></td>
                                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= htmlspecialchars($t['dest']) ?></td>
                                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= htmlspecialchars($t['tgl']) ?></td>
                                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= (int)$t['jml'] ?></td>
                                    <td class="py-3.5 px-2.5 border-b border-slate-100 font-medium text-slate-800"><?= htmlspecialchars($t['total']) ?></td>
                                    <td class="py-3.5 px-2.5 border-b border-slate-100">
                                        <span class="text-[11px] font-semibold px-3 py-1.5 rounded-full inline-block <?= $pill ?>"><?= strtoupper($t['status']) ?></span>
                                    </td>
                                    <td class="py-3.5 px-2.5 border-b border-slate-100">
                                        <a href="#" class="w-8 h-8 rounded-lg bg-blue-50 text-blue-700 flex items-center justify-center"><?= icon('eye', 15) ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    </div>
                </div>

                <div class="flex flex-col gap-4">
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex items-center gap-2.5 mb-4">
                            <span class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center"><?= icon('clock', 16) ?></span>
                            <div>
                                <div class="font-semibold text-[14.5px] text-slate-900">Ringkasan Hari Ini</div>
                                <div class="text-[11.5px] text-slate-500"><?= date('d F Y') ?></div>
                            </div>
                        </div>
                        <?php foreach ($ringkasan as $r): ?>
                            <div class="flex items-center gap-3 py-3 border-b border-slate-100 last:border-b-0">
                                <span class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0 <?= $r['warna_bg'] ?> <?= $r['warna_icon'] ?>"><?= icon($r['icon'], 16) ?></span>
                                <div class="flex-1 font-medium text-[13px] text-slate-700"><?= htmlspecialchars($r['label']) ?></div>
                                <div class="font-bold text-[15px] text-slate-900"><?= htmlspecialchars($r['nilai']) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                        <div class="flex gap-3 mb-4">
                            <span class="w-9 h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center shrink-0"><?= icon('download', 16) ?></span>
                            <div>
                                <div class="font-semibold text-[14.5px] text-slate-900 mb-0.5">Ekspor Data</div>
                                <div class="text-xs text-slate-500 leading-snug">Unduh laporan data dalam format yang tersedia.</div>
                            </div>
                        </div>
                        <div class="flex gap-2.5">
                            <button class="flex-1 flex items-center justify-center gap-2 py-2.5 px-2.5 rounded-xl font-semibold text-[12.5px] text-white bg-green-600 hover:bg-green-700 transition-colors cursor-pointer">
                                <?= icon('download', 15, '#fff') ?> Export Excel
                            </button>
                            <button class="flex-1 flex items-center justify-center gap-2 py-2.5 px-2.5 rounded-xl font-semibold text-[12.5px] text-white bg-slate-800 hover:bg-slate-900 transition-colors cursor-pointer">
                                <?= icon('file-text', 15, '#fff') ?> Export PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</div>

<script>
  // Line chart - Tren Transaksi Bulanan
  new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
      labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
      datasets: [{
        data: [14,17,20,17,19,15],
        borderColor: '#1d4ed8',
        backgroundColor: (ctx) => {
          const g = ctx.chart.ctx.createLinearGradient(0,0,0,220);
          g.addColorStop(0,'rgba(29,78,216,0.25)');
          g.addColorStop(1,'rgba(29,78,216,0)');
          return g;
        },
        fill: true,
        tension: 0.4,
        pointRadius: 4,
        pointBackgroundColor: '#fff',
        pointBorderColor: '#1d4ed8',
        pointBorderWidth: 2,
        borderWidth: 2.5,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { min: 10, max: 24, ticks: { stepSize: 2, color: '#94a3b8', font: { size: 11 } }, grid: { color: '#f1f5f9' } },
        x: { ticks: { color: '#94a3b8', font: { size: 11 } }, grid: { display: false } }
      }
    }
  });

  // Bar chart - Pengunjung per Bulan
  new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
      labels: ['Jan','Feb','Mar','Apr','Mei','Jun'],
      datasets: [{
        data: [0,42,63,49,36,84],
        backgroundColor: '#ea580c',
        borderRadius: 6,
        maxBarThickness: 34,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { min: 0, max: 90, ticks: { stepSize: 15, color: '#94a3b8', font: { size: 11 } }, grid: { color: '#f1f5f9' } },
        x: { ticks: { color: '#94a3b8', font: { size: 11 } }, grid: { display: false } }
      }
    }
  });
</script>

</body>
</html>