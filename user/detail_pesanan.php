<?php
// detail_pesanan.php
// Dituju dari tombol "Lihat Detail" di riwayat_pesanan.php lewat ?order_id=...
// Tampilan e-tiket untuk PENGGUNA: QR code untuk di-scan di lokasi wisata,
// kode tiket, rincian destinasi yang dibeli, tanggal, dan total bayar.

require_once '../config/koneksi.php';
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

$order_id = $_GET['order_id'] ?? '';
if ($order_id === '') {
    header('Location: riwayat_pesanan.php');
    exit;
}

// --- AKSI: BATALKAN PESANAN ---
if (isset($_POST['batalkan']) && $_POST['order_id'] === $order_id) {
    $cancel = mysqli_prepare($koneksi, "UPDATE pemesanan_tiket SET status = 'Dibatalkan' WHERE id_transaksi = ?");
    mysqli_stmt_bind_param($cancel, 's', $order_id);
    mysqli_stmt_execute($cancel);
    header('Location: detail_pesanan.php?order_id=' . urlencode($order_id));
    exit;
}

// --- AMBIL DATA PESANAN ---
$stmt = mysqli_prepare($koneksi, "SELECT * FROM pemesanan_tiket WHERE id_transaksi = ?");
mysqli_stmt_bind_param($stmt, 's', $order_id);
mysqli_stmt_execute($stmt);
$order = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$order) {
    header('Location: riwayat_pesanan.php');
    exit;
}

// --- AMBIL DAFTAR ITEM/DESTINASI DI TRANSAKSI INI ---
$stmtDetail = mysqli_prepare($koneksi, "SELECT * FROM pemesanan_detail WHERE id_transaksi = ?");
mysqli_stmt_bind_param($stmtDetail, 's', $order_id);
mysqli_stmt_execute($stmtDetail);
$items = mysqli_fetch_all(mysqli_stmt_get_result($stmtDetail), MYSQLI_ASSOC);

$statusStyleMap = [
    'MENUNGGU PEMBAYARAN' => ['bg' => 'bg-orange-light', 'text' => 'text-orange',    'label' => 'Menunggu Pembayaran'],
    'DIPROSES'            => ['bg' => 'bg-orange-light', 'text' => 'text-orange',    'label' => 'Diproses'],
    'DIBATALKAN'          => ['bg' => 'bg-red-50',        'text' => 'text-red-500',  'label' => 'Dibatalkan'],
    'SELESAI'             => ['bg' => 'bg-green-50',      'text' => 'text-green-600','label' => 'Selesai'],
    'DIKONFIRMASI'        => ['bg' => 'bg-purplec-light', 'text' => 'text-purplec',  'label' => 'Dikonfirmasi'],
];
$statusKey = strtoupper(trim($order['status'] ?? ''));
$st = $statusStyleMap[$statusKey] ?? ['bg' => 'bg-[#f1f1f5]', 'text' => 'text-[#5b5b6b]', 'label' => $order['status'] ?? '-'];

$bisaDibatalkan = in_array($statusKey, ['MENUNGGU PEMBAYARAN', 'DIPROSES']);

// QR code berisi kode tiket (id_transaksi) supaya bisa di-scan petugas di lokasi wisata
// untuk verifikasi keaslian tiket. Diproduksi lewat layanan gratis qrserver.com.
$qrData = urlencode($order['id_transaksi']);
$qrUrl  = "https://api.qrserver.com/v1/create-qr-code/?size=220x220&margin=8&data={$qrData}";

$tanggalTampil = $order['tanggal_pesan'] ?? '-';
if (!empty($order['tanggal_pesan'])) {
    $ts = strtotime($order['tanggal_pesan']);
    if ($ts) {
        $tanggalTampil = date('d M Y, H:i', $ts) . ' WIB';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Madiun Track - Tiket Saya</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
        colors: {
          orange: { DEFAULT: '#f7941d', light: '#fff1e0' },
          purplec:{ DEFAULT: '#6d4de0', light: '#eee9fd' },
          mutedc: '#8b93a7',
          bordc:  '#e9e9f2',
        }
      }
    }
  }
</script>
<style>
  body{ font-family:'Plus Jakarta Sans', sans-serif; }
  .ticket-notch{
    position:absolute;
    width:28px; height:28px;
    background:#f4f1fb; /* samakan dengan warna background body */
    border-radius:50%;
    top:50%;
    transform:translateY(-50%);
  }
  .dashed-line{
    border-top:2px dashed #dbdbe8;
  }
</style>
</head>
<body class="bg-gradient-to-br from-[#eef0fb] via-[#f4f1fb] to-[#fdf1ec] min-h-screen text-[#1e2433] text-sm">

<div class="max-w-[520px] mx-auto p-6">

  <!-- TOP BAR -->
  <div class="flex items-center gap-4 mb-6">
    <button onclick="window.location.href='riwayat_pesanan.php'" class="w-11 h-11 rounded-2xl bg-white border border-bordc flex items-center justify-center shadow-sm shrink-0">
      <svg viewBox="0 0 24 24" fill="none" stroke="#1e2433" stroke-width="2" class="w-5 h-5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    </button>
    <div>
      <div class="font-extrabold text-2xl">Tiket Saya</div>
      <div class="text-mutedc text-[13px]">Tunjukkan QR ini ke petugas saat masuk lokasi wisata.</div>
    </div>
  </div>

  <!-- E-TICKET CARD -->
  <div class="bg-white rounded-[28px] shadow-[0_10px_40px_-10px_rgba(60,50,150,0.2)] overflow-hidden mb-5">

    <!-- HEADER TIKET -->
    <div class="bg-gradient-to-br from-[#2a1f6b] via-[#3a2a8c] to-[#6d4de0] p-6 text-white relative">
      <div class="flex items-center justify-between mb-1">
        <div class="text-white/70 text-[11.5px] font-bold tracking-wide">MADIUN TRACK E-TICKET</div>
        <span class="text-xs font-bold px-3 py-1 rounded-full tracking-wide <?= $st['bg'] . ' ' . $st['text'] ?>"><?= htmlspecialchars($st['label']) ?></span>
      </div>
      <div class="font-extrabold text-lg leading-snug"><?= htmlspecialchars($order['destinasi'] ?? '-') ?></div>
      <div class="text-white/70 text-[12.5px] mt-1"><?= htmlspecialchars($tanggalTampil) ?></div>
    </div>

    <!-- QR CODE -->
    <div class="relative flex flex-col items-center py-7 px-6">
      <div class="ticket-notch -left-[14px]"></div>
      <div class="ticket-notch -right-[14px]"></div>

      <img src="<?= htmlspecialchars($qrUrl) ?>" alt="QR Tiket" class="w-[180px] h-[180px] mb-3">
      <div class="text-mutedc text-[11px] font-bold tracking-wide mb-1">KODE TIKET</div>
      <div class="font-extrabold text-lg text-purplec tracking-wider">#<?= htmlspecialchars($order['id_transaksi']) ?></div>
    </div>

    <div class="dashed-line"></div>

    <!-- DETAIL TIKET -->
    <div class="p-6">
      <div class="grid grid-cols-2 gap-4 mb-5">
        <div>
          <div class="text-mutedc text-[11px] font-bold mb-1">ATAS NAMA</div>
          <div class="font-bold text-[14px]"><?= htmlspecialchars($order['nama_pembeli'] ?? '-') ?></div>
        </div>
        <?php if (!empty($order['jumlah_orang'])): ?>
        <div>
          <div class="text-mutedc text-[11px] font-bold mb-1">JUMLAH TIKET</div>
          <div class="font-bold text-[14px]"><?= htmlspecialchars($order['jumlah_orang']) ?> Orang</div>
        </div>
        <?php endif; ?>
      </div>

      <!-- RINCIAN DESTINASI -->
      <?php if (!empty($items)): ?>
      <div class="text-mutedc text-[11px] font-bold mb-2">RINCIAN DESTINASI</div>
      <div class="flex flex-col gap-2 mb-5">
        <?php foreach ($items as $item): ?>
        <div class="flex items-center justify-between gap-3 bg-[#f6f7fb] border border-bordc rounded-xl px-3.5 py-2.5">
          <div class="flex items-center gap-2.5 min-w-0">
            <span class="text-[14px] shrink-0">📍</span>
            <div class="min-w-0">
              <div class="font-semibold text-[13px] truncate"><?= htmlspecialchars($item['nama_tempat'] ?? '-') ?></div>
              <?php if (isset($item['jumlah'])): ?>
              <div class="text-[11px] text-mutedc"><?= (int)$item['jumlah'] ?> tiket</div>
              <?php endif; ?>
            </div>
          </div>
          <?php if (isset($item['harga'])): ?>
          <div class="text-[12.5px] font-bold text-purplec shrink-0">Rp <?= number_format((float)$item['harga'] * (int)($item['jumlah'] ?? 1), 0, ',', '.') ?></div>
          <?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>

      <!-- TOTAL -->
      <div class="flex items-center justify-between pt-4 border-t border-bordc">
        <div class="text-mutedc text-[12px] font-bold">TOTAL PEMBAYARAN</div>
        <div class="font-extrabold text-xl text-purplec">Rp <?= number_format((float)($order['total_bayar'] ?? 0), 0, ',', '.') ?></div>
      </div>
    </div>
  </div>

  <!-- CATATAN PENGGUNAAN -->
  <div class="flex items-start gap-3 bg-purplec-light rounded-2xl p-4 mb-5">
    <svg viewBox="0 0 24 24" fill="none" stroke="#6d4de0" stroke-width="2" class="w-5 h-5 shrink-0 mt-0.5"><circle cx="12" cy="12" r="9"/><path d="M12 8h.01M11 12h1v4h1"/></svg>
    <div class="text-[12.5px] text-[#5b5580] leading-relaxed">
      Simpan tiket ini di HP Anda. Tunjukkan QR code kepada petugas di pintu masuk untuk verifikasi. Tiket hanya berlaku untuk tanggal kunjungan yang tertera.
    </div>
  </div>

  <!-- ACTIONS -->
  <div class="flex flex-col sm:flex-row gap-3">
    <button onclick="window.location.href='riwayat_pesanan.php'" class="flex-1 bg-white border-[1.5px] border-bordc text-[#1e2433] font-bold text-sm py-3.5 rounded-2xl">
      Kembali ke Riwayat
    </button>
    <?php if ($bisaDibatalkan): ?>
    <form method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?');">
      <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id_transaksi']) ?>">
      <button type="submit" name="batalkan" value="1" class="w-full bg-white border-[1.5px] border-red-200 text-red-500 font-bold text-sm py-3.5 rounded-2xl">
        Batalkan Pesanan
      </button>
    </form>
    <?php endif; ?>
  </div>

</div>

</body>
</html>