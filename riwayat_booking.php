<?php
/**
 * riwayat_booking.php
 * Menampilkan riwayat booking ASLI dari database (tabel `booking`,
 * hasil submit form di booking.php -> proses_booking.php).
 *
 * Status yang dipakai (lihat create_table_booking.sql):
 *   - menunggu_pembayaran  : pilih Bayar Online, belum bayar
 *   - lunas                : pilih Bayar Online, sudah bayar
 *   - bayar_ditempat       : pilih Bayar di Tempat -> BELUM DIBAYAR, bayar nanti saat check-in
 *   - dibatalkan           : booking dibatalkan
 *
 * ------------------------------------------------------------------
 * GANTI DI SINI kalau nama tabel/kolom database kamu berbeda
 * (samakan dengan yang di proses_booking.php dan bayar.php):
 * ------------------------------------------------------------------
 */
$TABEL = 'booking';
$KOLOM = [
    'id'              => 'id',
    'kode_booking'    => 'kode_booking',
    'nama_lengkap'    => 'nama_lengkap',
    'whatsapp'        => 'whatsapp',
    'email'           => 'email',
    'homestay_id'     => 'homestay_id',
    'homestay_nama'   => 'homestay_nama',
    'tanggal_checkin' => 'tanggal_checkin',
    'durasi_malam'    => 'durasi_malam',
    'total_bayar'     => 'total_bayar',
    'metode_bayar'    => 'metode_bayar',
    'status'          => 'status',
    'created_at'      => 'created_at',
    'paid_at'         => 'paid_at',
];
// ------------------------------------------------------------------

session_start();
require_once 'koneksi.php';

// ------------------------------------------------------------------
// 1. AMBIL DATA BOOKING DARI DATABASE
// ------------------------------------------------------------------
function ambilSemuaBooking($koneksi, $TABEL, $KOLOM) {
    $sql = "SELECT * FROM `{$TABEL}` ORDER BY `{$KOLOM['created_at']}` DESC";
    $result = mysqli_query($koneksi, $sql);
    if (!$result) {
        return [];
    }
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$bookings = ambilSemuaBooking($koneksi, $TABEL, $KOLOM);

// ------------------------------------------------------------------
// 2. FILTER STATUS (via GET, contoh: riwayat_booking.php?status=lunas)
// ------------------------------------------------------------------
$filter = isset($_GET['status']) ? $_GET['status'] : 'semua';

$filtered = array_filter($bookings, function ($b) use ($filter, $KOLOM) {
    $status = $b[$KOLOM['status']];
    if ($filter === 'semua') return true;
    return $status === $filter;
});

// ------------------------------------------------------------------
// 3. HELPER TAMPILAN
// ------------------------------------------------------------------
function rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function statusInfo($status) {
    switch ($status) {
        case 'lunas':
            return ['label' => 'LUNAS', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'bar' => 'bg-emerald-500', 'chip' => 'bg-emerald-500', 'icon' => '✔'];
        case 'menunggu_pembayaran':
            return ['label' => 'MENUNGGU PEMBAYARAN', 'bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'bar' => 'bg-rose-500', 'chip' => 'bg-rose-500', 'icon' => '⏳'];
        case 'bayar_ditempat':
            return ['label' => 'BELUM DIBAYAR · DI TEMPAT', 'bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'bar' => 'bg-amber-500', 'chip' => 'bg-amber-500', 'icon' => '🏠'];
        case 'dibatalkan':
            return ['label' => 'DIBATALKAN', 'bg' => 'bg-slate-200', 'text' => 'text-slate-600', 'bar' => 'bg-slate-400', 'chip' => 'bg-slate-400', 'icon' => '✕'];
        default:
            return ['label' => strtoupper($status), 'bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'bar' => 'bg-slate-400', 'chip' => 'bg-slate-400', 'icon' => '•'];
    }
}

// Data untuk modal detail (dikirim ke JS sebagai JSON, key = id booking)
$bookingsById = [];
foreach ($bookings as $b) {
    $bookingsById[$b[$KOLOM['id']]] = $b;
}

// Notifikasi sukses dari proses_booking.php / bayar.php
$suksesTipe = $_GET['sukses'] ?? null; // 'lunas' atau 'ditempat'
$suksesKode = $_GET['kode'] ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Madiun Track - Riwayat Booking</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: { extend: {
      fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
      colors: { orange: { DEFAULT: '#f7941d', light: '#fff1e0' }, navy: '#0f1f45', mutedc: '#8b93a7', bordc: '#e6e8f0' }
    }}
  }
</script>
<style>
  body { font-family: 'Plus Jakarta Sans', sans-serif; }
  .tab-active { background:#fff1e0; color:#f7941d; border-color:#fbd7a8; }
</style>
</head>
<body class="bg-[#eef0f5] min-h-screen">

<div class="max-w-6xl mx-auto p-6 md:p-10">

  <!-- HEADER -->
  <div class="flex items-start justify-between flex-wrap gap-4 mb-8">
    <div class="flex items-center gap-4">
      <div class="w-14 h-14 rounded-2xl bg-orange-light flex items-center justify-center text-2xl">🧳</div>
      <div>
        <h1 class="text-2xl md:text-3xl font-extrabold text-navy">Riwayat Booking</h1>
        <p class="text-mutedc text-sm md:text-base">Kelola semua pesanan homestay dan lihat detail pembayaran.</p>
      </div>
    </div>
    <a href="booking.php" class="flex items-center gap-2 bg-white border border-bordc rounded-xl px-4 py-2.5 shadow-sm text-navy font-medium hover:bg-slate-50 transition">
      <span>&larr;</span> Booking Baru
    </a>
  </div>

  <!-- NOTIFIKASI SUKSES -->
  <?php if ($suksesTipe === 'lunas'): ?>
  <div class="mb-6 flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-xl px-4 py-3 text-sm font-medium">
    <span class="text-lg">✅</span>
    Pembayaran untuk booking <strong><?= htmlspecialchars($suksesKode ?? '') ?></strong> berhasil. Status sudah <strong>Lunas</strong>.
  </div>
  <?php elseif ($suksesTipe === 'ditempat'): ?>
  <div class="mb-6 flex items-center gap-3 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl px-4 py-3 text-sm font-medium">
    <span class="text-lg">🏠</span>
    Booking <strong><?= htmlspecialchars($suksesKode ?? '') ?></strong> berhasil dibuat dengan metode Bayar di Tempat. Status masih <strong>Belum Dibayar</strong>, menunggu pembaruan dari admin.
  </div>
  <?php endif; ?>

  <!-- TAB FILTER -->
  <div class="flex flex-wrap gap-3 mb-6">
    <?php
    $tabs = [
        'semua'                => ['label' => 'Semua', 'icon' => '▦'],
        'menunggu_pembayaran'  => ['label' => 'Menunggu Pembayaran', 'icon' => '⏳'],
        'bayar_ditempat'       => ['label' => 'Belum Dibayar (Di Tempat)', 'icon' => '🏠'],
        'lunas'                => ['label' => 'Lunas', 'icon' => '✅'],
    ];
    foreach ($tabs as $key => $tab):
        $isActive = $filter === $key;
    ?>
    <a href="?status=<?= $key ?>"
       class="flex items-center gap-2 px-4 py-2.5 rounded-xl border text-sm font-semibold transition
              <?= $isActive ? 'tab-active shadow-sm' : 'bg-white border-bordc text-navy hover:bg-slate-50' ?>">
      <span><?= $tab['icon'] ?></span> <?= $tab['label'] ?>
    </a>
    <?php endforeach; ?>
  </div>

  <!-- LIST BOOKING -->
  <div class="flex flex-col gap-5">
    <?php if (empty($filtered)): ?>
      <div class="bg-white rounded-2xl p-10 text-center text-mutedc shadow-sm">
        Belum ada booking untuk kategori ini.
        <a href="booking.php" class="block mt-2 text-orange font-semibold">Buat booking baru →</a>
      </div>
    <?php endif; ?>

    <?php foreach ($filtered as $b):
        $status = $b[$KOLOM['status']];
        $info = statusInfo($status);
        $id = $b[$KOLOM['id']];
    ?>
    <div class="relative bg-white rounded-2xl shadow-sm overflow-hidden flex flex-col md:flex-row">
      <div class="absolute left-0 top-0 bottom-0 w-1.5 <?= $info['bar'] ?>"></div>

      <div class="flex-1 py-5 px-5">
        <div class="flex items-center gap-3 mb-2 flex-wrap">
          <span class="text-xs font-mono text-mutedc">#<?= htmlspecialchars($b[$KOLOM['kode_booking']]) ?></span>
          <span class="text-xs font-bold px-2.5 py-1 rounded-md <?= $info['bg'] ?> <?= $info['text'] ?>"><?= $info['icon'] ?> <?= $info['label'] ?></span>
        </div>
        <h3 class="text-lg font-bold text-navy"><?= htmlspecialchars($b[$KOLOM['homestay_nama']]) ?></h3>
        <p class="text-[13px] text-navy/70 mb-3"><?= htmlspecialchars($b[$KOLOM['nama_lengkap']]) ?> · 📱 <?= htmlspecialchars($b[$KOLOM['whatsapp']]) ?></p>

        <div class="grid grid-cols-3 gap-3 bg-[#f6f7fb] rounded-xl p-3 mb-3 text-sm max-w-md">
          <div>
            <div class="text-[11px] text-mutedc uppercase font-semibold">Malam</div>
            <div class="font-semibold text-navy"><?= (int)$b[$KOLOM['durasi_malam']] ?> Malam</div>
          </div>
          <div class="col-span-2">
            <div class="text-[11px] text-mutedc uppercase font-semibold">Check-in</div>
            <div class="font-semibold text-orange"><?= htmlspecialchars(date('d M Y', strtotime($b[$KOLOM['tanggal_checkin']]))) ?></div>
          </div>
        </div>

        <p class="text-xs text-mutedc">🗓 Dipesan pada <?= htmlspecialchars(date('d M Y, H:i', strtotime($b[$KOLOM['created_at']]))) ?></p>
      </div>

      <div class="md:w-64 shrink-0 border-t md:border-t-0 md:border-l border-dashed border-bordc p-5 flex flex-col justify-center gap-3">
        <div>
          <div class="text-[11px] text-mutedc uppercase font-semibold">Total Bayar</div>
          <div class="text-xl font-extrabold text-navy"><?= rupiah($b[$KOLOM['total_bayar']]) ?></div>
        </div>

        <?php if ($status === 'menunggu_pembayaran'): ?>
        <a href="bayar.php?id=<?= (int)$id ?>"
           class="flex items-center justify-center gap-1 bg-gradient-to-r from-orange to-[#ff7a45] text-white font-semibold text-sm rounded-xl py-2.5 hover:brightness-105 transition">
          Lanjutkan Pembayaran →
        </a>
        <?php elseif ($status === 'bayar_ditempat'): ?>
        <div class="flex items-center justify-center gap-1 bg-slate-50 border border-slate-200 text-mutedc font-semibold text-xs rounded-xl py-2.5 text-center px-2">
          Menunggu pembaruan dari admin
        </div>
        <?php endif; ?>

        <button type="button"
                onclick="openDetail('<?= (int)$id ?>')"
                class="flex items-center justify-center gap-1 border border-orange/40 text-orange font-semibold text-sm rounded-xl py-2.5 hover:bg-orange-light transition">
          Lihat Detail →
        </button>
      </div>
    </div>
    <?php endforeach; ?>
  </div>

  <!-- BANTUAN -->
  <div class="mt-6 bg-white rounded-2xl shadow-sm p-5 flex items-center justify-between flex-wrap gap-4">
    <div class="flex items-center gap-4">
      <span class="text-3xl">🧳🗺️</span>
      <div>
        <div class="font-bold text-navy">Butuh bantuan?</div>
        <div class="text-sm text-mutedc">Hubungi kami jika ada pertanyaan seputar booking atau pembayaran.</div>
      </div>
    </div>
    <a href="https://wa.me/62856745534" target="_blank"
       class="flex items-center gap-2 border border-bordc rounded-xl px-4 py-2.5 font-semibold text-navy hover:bg-slate-50 transition">
      🎧 Hubungi Support
    </a>
  </div>
</div>

<!-- ================= MODAL DETAIL ================= -->
<div id="detailModal" class="fixed inset-0 bg-navy/50 backdrop-blur-sm hidden items-center justify-center p-4 z-50">
  <div class="bg-white rounded-2xl max-w-md w-full p-6 relative shadow-xl">
    <button onclick="closeDetail()" class="absolute top-4 right-4 text-mutedc hover:text-navy text-xl leading-none">✕</button>

    <div class="flex items-center gap-2 mb-2">
      <span id="dtKode" class="text-xs font-mono text-mutedc"></span>
      <span id="dtStatus" class="text-xs font-bold px-2.5 py-1 rounded-md"></span>
    </div>

    <h3 id="dtHomestay" class="text-lg font-bold text-navy mb-1"></h3>
    <p id="dtPemesan" class="text-sm text-mutedc mb-4"></p>

    <div class="grid grid-cols-2 gap-3 text-sm mb-4">
      <div class="bg-[#f6f7fb] rounded-lg p-3">
        <div class="text-[11px] text-mutedc uppercase font-semibold">Malam</div>
        <div id="dtMalam" class="font-semibold text-navy"></div>
      </div>
      <div class="bg-[#f6f7fb] rounded-lg p-3">
        <div class="text-[11px] text-mutedc uppercase font-semibold">Check-in</div>
        <div id="dtCheckin" class="font-semibold text-orange"></div>
      </div>
      <div class="bg-[#f6f7fb] rounded-lg p-3 col-span-2">
        <div class="text-[11px] text-mutedc uppercase font-semibold">Total Bayar</div>
        <div id="dtTotal" class="font-semibold text-navy"></div>
      </div>
    </div>

    <div class="text-sm mb-1"><span class="text-mutedc">WhatsApp:</span> <span id="dtWa" class="font-medium text-navy"></span></div>
    <div class="text-sm mb-1"><span class="text-mutedc">Email:</span> <span id="dtEmail" class="font-medium text-navy"></span></div>
    <div class="text-sm mb-1"><span class="text-mutedc">Metode Bayar:</span> <span id="dtMetode" class="font-medium text-navy"></span></div>
    <div class="text-sm mb-4"><span class="text-mutedc">Dipesan pada:</span> <span id="dtDipesan" class="font-medium text-navy"></span></div>

    <button onclick="closeDetail()" class="w-full bg-navy text-white font-semibold rounded-xl py-2.5 hover:brightness-110 transition">
      Tutup
    </button>
  </div>
</div>

<script>
  // Data booking dikirim dari PHP -> JavaScript (JSON)
  const bookingsData = <?= json_encode($bookingsById, JSON_UNESCAPED_UNICODE) ?>;

  const statusStyle = {
    lunas:               { label: '✔ LUNAS', bg: 'bg-emerald-100', text: 'text-emerald-700' },
    menunggu_pembayaran: { label: '⏳ MENUNGGU PEMBAYARAN', bg: 'bg-rose-100', text: 'text-rose-600' },
    bayar_ditempat:      { label: '🏠 BELUM DIBAYAR · DI TEMPAT', bg: 'bg-amber-100', text: 'text-amber-700' },
    dibatalkan:          { label: '✕ DIBATALKAN', bg: 'bg-slate-200', text: 'text-slate-600' }
  };

  const metodeLabel = { online: 'Online (Transfer/QRIS)', ditempat: 'Bayar di Tempat (Cash)' };

  function formatRupiah(angka) {
    return 'Rp ' + Number(angka).toLocaleString('id-ID');
  }

  function formatTanggal(str) {
    const d = new Date(str.replace(' ', 'T'));
    return d.toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' });
  }

  function openDetail(id) {
    const b = bookingsData[id];
    if (!b) return;

    document.getElementById('dtKode').textContent = '#' + b.kode_booking;

    const st = statusStyle[b.status] || { label: b.status.toUpperCase(), bg: 'bg-slate-100', text: 'text-slate-700' };
    const statusEl = document.getElementById('dtStatus');
    statusEl.textContent = st.label;
    statusEl.className = 'text-xs font-bold px-2.5 py-1 rounded-md ' + st.bg + ' ' + st.text;

    document.getElementById('dtHomestay').textContent = b.homestay_nama;
    document.getElementById('dtPemesan').textContent = b.nama_lengkap;
    document.getElementById('dtMalam').textContent = b.durasi_malam + ' Malam';
    document.getElementById('dtCheckin').textContent = formatTanggal(b.tanggal_checkin);
    document.getElementById('dtTotal').textContent = formatRupiah(b.total_bayar);
    document.getElementById('dtWa').textContent = b.whatsapp;
    document.getElementById('dtEmail').textContent = b.email || '-';
    document.getElementById('dtMetode').textContent = metodeLabel[b.metode_bayar] || b.metode_bayar;
    document.getElementById('dtDipesan').textContent = formatTanggal(b.created_at);

    const modal = document.getElementById('detailModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  }

  function closeDetail() {
    const modal = document.getElementById('detailModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }

  document.getElementById('detailModal').addEventListener('click', function (e) {
    if (e.target === this) closeDetail();
  });
</script>
</body>
</html>