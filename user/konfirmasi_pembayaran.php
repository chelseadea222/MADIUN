<?php
// konfirmasi_pembayaran.php
// Halaman ini sekarang mengambil data pesanan LANGSUNG dari database
// (bukan dari sessionStorage lagi), berdasarkan ?order_id=... yang dikirim
// dari beli_tiket.php setelah proses_checkout.php berhasil INSERT.

require_once '../config/koneksi.php';

$order_id = $_GET['order_id'] ?? '';

if ($order_id === '') {
    header('Location: beli_tiket.php');
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM pemesanan_tiket WHERE id_transaksi = ?");
mysqli_stmt_bind_param($stmt, 's', $order_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$order = mysqli_fetch_assoc($result);

if (!$order) {
    // ID transaksi tidak ditemukan di database
    header('Location: beli_tiket.php');
    exit;
}

// Kalau pembayaran untuk order ini sudah pernah dikonfirmasi (bukti sudah ada),
// langsung arahkan ke riwayat supaya tidak upload bukti dobel.
if ($order['bukti_transfer']) {
    header('Location: riwayat_pesanan.php');
    exit;
}

$stmtDetail = mysqli_prepare($koneksi, "SELECT * FROM pemesanan_detail WHERE id_transaksi = ?");
mysqli_stmt_bind_param($stmtDetail, 's', $order_id);
mysqli_stmt_execute($stmtDetail);
$detailResult = mysqli_stmt_get_result($stmtDetail);
$items = mysqli_fetch_all($detailResult, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Madiun Track - Verifikasi Pembayaran</title>
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
  .sparkle{ position:absolute; color:#fbbf24; }
  .dropzone.dragover{ border-color:#6d4de0; background:#f5f3ff; }
</style>
</head>
<body class="bg-gradient-to-br from-[#eef0fb] via-[#f4f1fb] to-[#fdf1ec] min-h-screen text-[#1e2433] text-sm">

<div class="max-w-[1560px] mx-auto p-6">

  <!-- TOP BAR -->
  <div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4">
      <button onclick="window.history.back()" class="w-11 h-11 rounded-2xl bg-white border border-bordc flex items-center justify-center shadow-sm shrink-0">
        <svg viewBox="0 0 24 24" fill="none" stroke="#1e2433" stroke-width="2" class="w-5 h-5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      </button>
      <div>
        <div class="font-extrabold text-xl">Verifikasi Pembayaran</div>
        <div class="text-mutedc text-[13px]">Langkah terakhir sebelum pesanan diproses</div>
      </div>
    </div>
    <div class="flex items-center gap-2.5">
      <div class="w-9 h-9 rounded-full bg-purplec-light flex items-center justify-center shrink-0">
        <svg viewBox="0 0 24 24" fill="none" stroke="#6d4de0" stroke-width="2" class="w-4 h-4"><path d="M12 2l8 3v6c0 5-3.5 8.5-8 11-4.5-2.5-8-6-8-11V5z"/><path d="M9 12l2 2 4-4"/></svg>
      </div>
      <div>
        <div class="font-bold text-[13px] leading-tight">Transaksi Aman</div>
        <div class="text-[11.5px] text-mutedc">Data Anda 100% Terlindungi</div>
      </div>
    </div>
  </div>

  <!-- MAIN CARD -->
  <div class="grid grid-cols-[420px_1fr] max-[900px]:grid-cols-1 bg-white rounded-[28px] overflow-hidden shadow-[0_20px_60px_-15px_rgba(60,50,150,0.25)]">

    <!-- LEFT PANEL -->
    <div class="relative bg-gradient-to-br from-[#2a1f6b] via-[#3a2a8c] to-[#6d4de0] p-10 flex flex-col overflow-hidden">
      <!-- decorative sparkles -->
      <svg class="sparkle" style="top:18%;right:14%;width:20px;height:20px" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0l2 10 10 2-10 2-2 10-2-10-10-2 10-2z"/></svg>
      <svg class="sparkle" style="top:42%;right:6%;width:12px;height:12px" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0l2 10 10 2-10 2-2 10-2-10-10-2 10-2z"/></svg>
      <svg class="sparkle" style="top:52%;left:8%;width:14px;height:14px" viewBox="0 0 24 24" fill="currentColor"><path d="M12 0l2 10 10 2-10 2-2 10-2-10-10-2 10-2z"/></svg>

      <div class="w-16 h-16 rounded-full bg-white/15 flex items-center justify-center mb-6 relative">
        <div class="w-11 h-11 rounded-full bg-white flex items-center justify-center">
          <svg viewBox="0 0 24 24" fill="none" stroke="#6d4de0" stroke-width="2.2" class="w-5 h-5"><path d="M12 2l8 3v6c0 5-3.5 8.5-8 11-4.5-2.5-8-6-8-11V5z"/><path d="M9 12l2 2 4-4"/></svg>
        </div>
      </div>

      <h1 class="text-white text-3xl font-extrabold leading-tight mb-1">Konfirmasi</h1>
      <h1 class="text-orange text-3xl font-extrabold leading-tight mb-1">Pembayaran</h1>
      <div class="w-10 h-1 bg-orange rounded-full mb-5"></div>

      <p class="text-white/70 text-[13.5px] leading-relaxed max-w-[280px] mb-10">
        Pastikan data dan bukti transfer sudah sesuai. Kami akan memverifikasi pembayaran Anda secepat mungkin.
      </p>

      <!-- illustration -->
      <div class="relative flex-1 flex items-end justify-center min-h-[180px]">
        <div class="relative">
          <div class="w-40 h-40 rounded-full bg-white/10 blur-2xl absolute -bottom-4 left-1/2 -translate-x-1/2"></div>
          <svg viewBox="0 0 200 180" class="w-56 relative z-10">
            <ellipse cx="100" cy="165" rx="70" ry="10" fill="#000" opacity="0.15"/>
            <rect x="30" y="140" width="140" height="20" rx="10" fill="#c7bdf0"/>
            <rect x="45" y="60" width="80" height="90" rx="10" fill="#a595e8"/>
            <rect x="95" y="40" width="60" height="90" rx="6" fill="#ffffff" transform="rotate(8 95 40)"/>
            <line x1="105" y1="55" x2="150" y2="50" stroke="#d8d3f5" stroke-width="3" transform="rotate(8 95 40)"/>
            <line x1="105" y1="65" x2="150" y2="60" stroke="#d8d3f5" stroke-width="3" transform="rotate(8 95 40)"/>
            <line x1="105" y1="75" x2="140" y2="70" stroke="#d8d3f5" stroke-width="3" transform="rotate(8 95 40)"/>
            <circle cx="118" cy="98" r="16" fill="#22c55e"/>
            <path d="M111 98l5 5 10-10" stroke="white" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
      </div>

      <div class="relative z-10 flex items-center gap-3 bg-white/10 rounded-2xl p-4 mt-6 backdrop-blur-sm">
        <div class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center shrink-0">
          <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" class="w-4 h-4"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg>
        </div>
        <div class="text-white/85 text-[12.5px] leading-relaxed">
          Verifikasi akan dilakukan oleh admin dalam maksimal <span class="text-orange font-bold">1x24 jam</span>.
        </div>
      </div>
    </div>

    <!-- RIGHT PANEL -->
    <div class="p-10">
      <form id="formBukti" action="upload_bukti.php" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['id_transaksi']) ?>">

      <label class="block font-bold text-[13.5px] mb-2.5">ID Transaksi</label>
      <div class="flex items-center gap-3 bg-[#f6f7fb] border border-bordc rounded-2xl px-4 py-4 mb-7">
        <div class="w-9 h-9 rounded-xl bg-purplec-light flex items-center justify-center shrink-0">
          <svg viewBox="0 0 24 24" fill="none" stroke="#6d4de0" stroke-width="2" class="w-4 h-4"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/></svg>
        </div>
        <span id="trxId" class="font-extrabold text-[16px] tracking-wide"><?= htmlspecialchars($order['id_transaksi']) ?></span>
      </div>

      <label class="block font-bold text-[13.5px] mb-2.5">Unggah Bukti Transfer</label>
      <label id="dropzone" class="dropzone flex flex-col items-center justify-center gap-3 border-2 border-dashed border-bordc rounded-2xl py-14 cursor-pointer transition mb-6">
        <div class="w-16 h-16 rounded-full bg-purplec-light flex items-center justify-center">
          <svg viewBox="0 0 24 24" fill="none" stroke="#6d4de0" stroke-width="2" class="w-7 h-7"><path d="M12 3v12M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
        </div>
        <div class="text-center">
          <div class="font-bold text-[14px]" id="dzTitle">Klik atau seret gambar di sini</div>
          <div class="text-mutedc text-[12.5px] mt-1">Format yang didukung: JPG, PNG, JPEG</div>
          <div class="text-mutedc text-[12.5px]">Maksimal ukuran 5MB</div>
        </div>
        <input type="file" id="buktiInput" name="bukti" accept=".jpg,.jpeg,.png" class="hidden">
      </label>

      <div id="previewWrap" class="hidden mb-6">
        <div class="flex items-center gap-3 bg-[#f6f7fb] border border-bordc rounded-2xl p-3">
          <img id="previewImg" class="w-14 h-14 rounded-xl object-cover shrink-0" alt="preview">
          <div class="flex-1 min-w-0">
            <div class="font-semibold text-[13px] truncate" id="fileName">-</div>
            <div class="text-[11.5px] text-mutedc" id="fileSize">-</div>
          </div>
          <button onclick="removeFile()" class="w-8 h-8 rounded-lg bg-white border border-bordc flex items-center justify-center text-red-500 shrink-0">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path d="M18 6L6 18M6 6l12 12"/></svg>
          </button>
        </div>
      </div>

      <div class="flex items-center gap-4 bg-purplec-light rounded-2xl p-4 mb-6">
        <svg viewBox="0 0 24 24" fill="none" stroke="#6d4de0" stroke-width="2" class="w-5 h-5 shrink-0"><circle cx="12" cy="12" r="9"/><path d="M12 8h.01M11 12h1v4h1"/></svg>
        <div class="flex-1">
          <div class="font-bold text-[13px] text-purplec">Perhatian</div>
          <div class="text-[12.5px] text-[#5b5580] leading-relaxed">Pastikan bukti transfer menampilkan jumlah, tanggal, nama pengirim, dan rekening tujuan dengan jelas.</div>
        </div>
        <svg viewBox="0 0 24 24" fill="none" stroke="#a595e8" stroke-width="1.5" class="w-10 h-10 shrink-0 hidden sm:block"><rect x="4" y="3" width="14" height="18" rx="2"/><path d="M7 8h8M7 12h8M7 16h5"/></svg>
      </div>

      <button id="btnKirim" type="submit" disabled class="w-full flex items-center justify-center gap-2.5 bg-gradient-to-r from-orange to-purplec text-white font-bold py-4 rounded-2xl text-[15px] disabled:opacity-50 disabled:cursor-not-allowed transition">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px]"><path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4 20-7z"/></svg>
        Kirim Konfirmasi
      </button>
      <div class="flex items-center justify-center gap-1.5 text-[11.5px] text-mutedc mt-4">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3.5 h-3.5"><rect x="5" y="11" width="14" height="9" rx="2"/><path d="M8 11V7a4 4 0 018 0v4"/></svg>
        Data Anda aman dan hanya digunakan untuk verifikasi pembayaran
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  // ID transaksi sudah dirender langsung dari PHP di atas (<?= $order['id_transaksi'] ?>),
  // jadi tidak perlu lagi baca dari sessionStorage di sini.

  const dropzone = document.getElementById('dropzone');
  const buktiInput = document.getElementById('buktiInput');
  const previewWrap = document.getElementById('previewWrap');
  const btnKirim = document.getElementById('btnKirim');
  const formBukti = document.getElementById('formBukti');

  dropzone.addEventListener('click', ()=> buktiInput.click());

  ['dragover','dragenter'].forEach(evt=>{
    dropzone.addEventListener(evt, (e)=>{ e.preventDefault(); dropzone.classList.add('dragover'); });
  });
  ['dragleave','drop'].forEach(evt=>{
    dropzone.addEventListener(evt, (e)=>{ e.preventDefault(); dropzone.classList.remove('dragover'); });
  });
  dropzone.addEventListener('drop', (e)=>{
    const file = e.dataTransfer.files[0];
    if(file){
      // supaya file yang di-drag ikut ke-submit lewat form (bukan cuma dipratinjau)
      const dt = new DataTransfer();
      dt.items.add(file);
      buktiInput.files = dt.files;
      handleFile(file);
    }
  });

  buktiInput.addEventListener('change', ()=>{
    if(buktiInput.files[0]) handleFile(buktiInput.files[0]);
  });

  function handleFile(file){
    const validTypes = ['image/jpeg','image/png','image/jpg'];
    if(!validTypes.includes(file.type)){
      alert('Format file tidak didukung. Gunakan JPG, PNG, atau JPEG.');
      removeFile();
      return;
    }
    if(file.size > 5 * 1024 * 1024){
      alert('Ukuran file terlalu besar. Maksimal 5MB.');
      removeFile();
      return;
    }

    const reader = new FileReader();
    reader.onload = (e)=>{
      document.getElementById('previewImg').src = e.target.result;
      document.getElementById('fileName').textContent = file.name;
      document.getElementById('fileSize').textContent = (file.size/1024).toFixed(0) + ' KB';
      previewWrap.classList.remove('hidden');
      btnKirim.disabled = false;
    };
    reader.readAsDataURL(file);
  }

  function removeFile(){
    buktiInput.value = '';
    previewWrap.classList.add('hidden');
    btnKirim.disabled = true;
  }

  // Tombol "Kirim Konfirmasi" sekarang type="submit" di dalam <form> beneran
  // (action="upload_bukti.php", enctype="multipart/form-data"). Saat diklik,
  // browser otomatis submit file + order_id ke upload_bukti.php, yang akan:
  //   1. Validasi & simpan file ke folder uploads/bukti/
  //   2. UPDATE bukti_transfer + status ('Diproses') di tabel pemesanan_tiket
  //   3. Redirect ke riwayat_pesanan.php
  // Jadi tidak perlu lagi menangani submit secara manual lewat JS di sini.
  formBukti.addEventListener('submit', ()=>{
    btnKirim.disabled = true;
    btnKirim.textContent = 'Mengirim...';
  });
</script>

</body>
</html>