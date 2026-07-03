<?php
/**
 * bayar.php
 * Halaman pembayaran untuk booking yang metode-nya "Bayar Online".
 *
 * CATATAN: Bagian "Bayar Sekarang" di file ini masih SIMULASI (belum
 * terhubung payment gateway asli seperti Midtrans/Xendit). Saat tombol
 * ditekan, status booking di database langsung diubah jadi "lunas".
 * Lihat catatan di bagian bawah file untuk langkah upgrade ke gateway asli.
 *
 * ------------------------------------------------------------------
 * GANTI DI SINI kalau nama tabel/kolom database kamu berbeda:
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
    'paid_at'         => 'paid_at',
];
// ------------------------------------------------------------------

session_start();
require_once '../config/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id']) ? (int)$_POST['id'] : 0);

function ambilBooking($koneksi, $TABEL, $KOLOM, $id) {
    $sql = "SELECT * FROM `{$TABEL}` WHERE `{$KOLOM['id']}` = ? LIMIT 1";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    return $row ?: null;
}

$booking = $id ? ambilBooking($koneksi, $TABEL, $KOLOM, $id) : null;
$error = null;

if (!$booking) {
    $error = 'Booking tidak ditemukan.';
} elseif ($booking[$KOLOM['status']] === 'lunas') {
    header('Location: riwayat_booking.php?sukses=lunas&kode=' . urlencode($booking[$KOLOM['kode_booking']]));
    exit;
}

// ------------------------------------------------------------------
// Proses submit pembayaran (SIMULASI)
// ------------------------------------------------------------------
if ($booking && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['metode_transfer'])) {
    $sql = "UPDATE `{$TABEL}` SET `{$KOLOM['status']}` = 'lunas', `{$KOLOM['paid_at']}` = NOW() WHERE `{$KOLOM['id']}` = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header('Location: riwayat_booking.php?sukses=lunas&kode=' . urlencode($booking[$KOLOM['kode_booking']]));
    exit;
}

$vaNumber = $booking ? '8808' . str_pad($booking[$KOLOM['id']], 8, '0', STR_PAD_LEFT) : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran<?= $booking ? ' - ' . htmlspecialchars($booking[$KOLOM['kode_booking']]) : '' ?></title>
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
<style>body{ font-family:'Plus Jakarta Sans', sans-serif; } .dashed{ border-top:1.5px dashed #e2e4ee; }</style>
</head>
<body class="bg-[#eef0f5] min-h-screen flex items-center justify-center p-5">

<div class="w-full max-w-lg">

  <a href="booking.php" class="inline-flex items-center gap-2 text-mutedc hover:text-navy text-[13px] font-semibold mb-5">
    &larr; Kembali ke Booking
  </a>

  <?php if ($error): ?>
    <div class="bg-white rounded-[24px] shadow-[0_25px_70px_-25px_rgba(15,31,69,0.35)] p-10 text-center">
      <div class="text-4xl mb-3">⚠️</div>
      <p class="text-navy font-semibold"><?= htmlspecialchars($error) ?></p>
      <a href="booking.php" class="inline-block mt-4 text-orange font-bold">Kembali ke Booking</a>
    </div>
  <?php else: ?>

  <div class="mb-4 inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-full">
    🧪 Mode Simulasi — belum terhubung payment gateway asli
  </div>

  <div class="bg-white rounded-[24px] shadow-[0_25px_70px_-25px_rgba(15,31,69,0.35)] p-7 mb-5">
    <h1 class="text-[22px] font-extrabold text-navy mb-1">Selesaikan Pembayaran</h1>
    <p class="text-[13px] text-mutedc mb-5"><?= htmlspecialchars($booking[$KOLOM['kode_booking']]) ?></p>

    <div class="flex items-center justify-between bg-[#f6f7fb] rounded-2xl p-4 mb-5">
      <div>
        <div class="font-bold text-navy text-[14px]"><?= htmlspecialchars($booking[$KOLOM['homestay_nama']]) ?></div>
        <div class="text-[12.5px] text-mutedc">Check-in: <?= htmlspecialchars(date('d M Y', strtotime($booking[$KOLOM['tanggal_checkin']]))) ?> · <?= (int)$booking[$KOLOM['durasi_malam']] ?> Malam</div>
      </div>
    </div>

    <div class="dashed pt-4 flex items-center justify-between">
      <span class="text-mutedc text-[13px]">Total Pembayaran</span>
      <span class="text-[24px] font-extrabold text-orange">Rp <?= number_format($booking[$KOLOM['total_bayar']], 0, ',', '.') ?></span>
    </div>
  </div>

  <form id="payForm" method="POST" action="bayar.php" class="bg-white rounded-[24px] shadow-[0_25px_70px_-25px_rgba(15,31,69,0.35)] p-7">
    <input type="hidden" name="id" value="<?= (int)$booking[$KOLOM['id']] ?>">

    <h2 class="font-bold text-navy text-[14px] mb-4">Pilih Metode Pembayaran</h2>

    <div class="flex flex-col gap-3 mb-6">
      <label class="metode-option flex items-center gap-3 border-2 border-orange bg-orange-light rounded-xl p-4 cursor-pointer">
        <input type="radio" name="metode_transfer" value="transfer" checked class="accent-orange">
        <div class="flex-1">
          <div class="font-semibold text-navy text-[13.5px]">Transfer Bank</div>
          <div class="text-[11.5px] text-mutedc">Virtual Account BCA / Mandiri / BNI</div>
        </div>
        <span class="text-xl">🏦</span>
      </label>
      <label class="metode-option flex items-center gap-3 border-2 border-bordc rounded-xl p-4 cursor-pointer">
        <input type="radio" name="metode_transfer" value="qris" class="accent-orange">
        <div class="flex-1">
          <div class="font-semibold text-navy text-[13.5px]">QRIS</div>
          <div class="text-[11.5px] text-mutedc">Scan pakai aplikasi bank/e-wallet apa saja</div>
        </div>
        <span class="text-xl">📷</span>
      </label>
    </div>

    <div id="vaBox" class="bg-[#f6f7fb] rounded-xl p-4 mb-5 text-[13px]">
      <div class="text-mutedc text-[11px] uppercase font-semibold mb-1">Nomor Virtual Account (dummy)</div>
      <div class="font-mono font-bold text-navy text-lg tracking-wider"><?= $vaNumber ?></div>
    </div>

    <button type="submit" id="payButton" class="w-full flex items-center justify-center gap-2 bg-gradient-to-r from-orange to-[#ff7a45] text-white font-bold py-3.5 rounded-2xl text-[14px] hover:brightness-105 active:scale-[0.99] transition disabled:opacity-60">
      <span id="payButtonText">Bayar Sekarang</span>
    </button>
    <p class="text-center text-[11.5px] text-mutedc mt-3">Ini simulasi — klik tombol di atas akan menandai booking sebagai "Lunas".</p>
  </form>
  <?php endif; ?>
</div>

<script>
  document.querySelectorAll('.metode-option').forEach(function (label) {
    label.addEventListener('click', function () {
      document.querySelectorAll('.metode-option').forEach(function (l) {
        l.classList.remove('border-orange', 'bg-orange-light');
        l.classList.add('border-bordc');
      });
      this.classList.remove('border-bordc');
      this.classList.add('border-orange', 'bg-orange-light');
      const isTransfer = this.querySelector('input').value === 'transfer';
      document.getElementById('vaBox').style.display = isTransfer ? 'block' : 'none';
    });
  });

  const form = document.getElementById('payForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      const btn = document.getElementById('payButton');
      const btnText = document.getElementById('payButtonText');
      btn.disabled = true;
      btnText.textContent = 'Memproses pembayaran...';
      setTimeout(function () { form.submit(); }, 1500);
    });
  }
</script>
</body>
</html>

<?php
/*
------------------------------------------------------------------
UPGRADE KE PAYMENT GATEWAY ASLI (opsional):
------------------------------------------------------------------
1. Daftar akun merchant Midtrans/Xendit/DOKU/Tripay.
2. Ganti blok UPDATE status "lunas" di atas dengan pemanggilan API gateway
   untuk membuat transaksi (dapat snap_token / payment_url / VA asli).
3. Buat file webhook.php yang menerima notifikasi otomatis dari gateway
   saat status pembayaran berubah, baru UPDATE status di database dari situ
   (bukan langsung dari klik tombol seperti sekarang).
*/