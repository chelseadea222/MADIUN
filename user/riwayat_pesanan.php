<?php
require_once '../config/koneksi.php';
// Pastikan user sudah login
session_start();
if (!isset($_SESSION['user_id'])) { header('Location: login.php'); exit; }

// Ambil data dari tabel pemesanan_tiket
// Hanya tampilkan pesanan yang SUDAH diupload bukti pembayarannya
// (bukti_pembayaran terisi = user sudah menyelesaikan konfirmasi pembayaran).
// Pesanan yang masih 'Menunggu Pembayaran' (belum upload bukti) tidak muncul di sini.
//
// Kalau riwayat harus per-user (bukan semua orang), tambahkan filter user_id, contoh:
// "... WHERE bukti_pembayaran IS NOT NULL AND user_id = ? ORDER BY id_transaksi DESC"
// lalu bind $_SESSION['user_id'] dengan mysqli_prepare + bind_param.
$query = "SELECT * FROM pemesanan_tiket WHERE bukti_pembayaran IS NOT NULL ORDER BY id_transaksi DESC";
$result = mysqli_query($koneksi, $query);
$riwayat_db = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Madiun Track - Riwayat Pemesanan</title>
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
</style>
</head>
<body class="bg-gradient-to-br from-[#eef0fb] via-[#f4f1fb] to-[#fdf1ec] min-h-screen text-[#1e2433] text-sm">

<div class="max-w-[1300px] mx-auto p-6">

  <!-- TOP BAR -->
  <div class="flex items-center gap-4 mb-6">
    <button onclick="window.history.back()" class="w-11 h-11 rounded-2xl bg-white border border-bordc flex items-center justify-center shadow-sm shrink-0">
      <svg viewBox="0 0 24 24" fill="none" stroke="#1e2433" stroke-width="2" class="w-5 h-5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
    </button>
    <div>
      <div class="font-extrabold text-2xl">Riwayat Pemesanan</div>
      <div class="text-mutedc text-[13px]">Lihat dan kelola semua pesanan tiket wisata Anda.</div>
    </div>
  </div>

  <!-- LIST -->
  <div id="list" class="flex flex-col gap-4"></div>

  <!-- EMPTY STATE -->
  <div id="empty" class="hidden flex-col items-center justify-center text-center bg-white rounded-[24px] border border-bordc py-20 px-6">
    <div class="w-16 h-16 rounded-full bg-purplec-light flex items-center justify-center mb-4">
      <svg viewBox="0 0 24 24" fill="none" stroke="#6d4de0" stroke-width="2" class="w-7 h-7"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/></svg>
    </div>
    <div class="font-extrabold text-lg mb-1">Belum ada riwayat pemesanan</div>
    <div class="text-mutedc text-[13px] max-w-xs">Pesanan yang sudah kamu konfirmasi pembayarannya akan muncul di sini.</div>
  </div>

  <!-- FOOTER -->
  <div id="footerNote" class="hidden text-center text-mutedc text-[13px] mt-7 items-center justify-center gap-1.5">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-3.5 h-3.5"><circle cx="12" cy="12" r="9"/><path d="M12 8h.01M11 12h1v4h1"/></svg>
    <span id="footerText"></span>
  </div>

</div>

<script>
  // Palet badge status. Nama status di DB memakai kapital awal (mis. 'Diproses',
  // 'Dibatalkan') sesuai yang di-set oleh upload_bukti.php, jadi pencocokan
  // di bawah ini tidak case-sensitive (lihat getStatusStyle).
  const STATUS_STYLE = {
    'MENUNGGU PEMBAYARAN': { bg:'bg-orange-light',  text:'text-orange',    label:'Menunggu Pembayaran' },
    'DIPROSES':            { bg:'bg-orange-light',  text:'text-orange',    label:'Diproses'            },
    'DIBATALKAN':          { bg:'bg-red-50',         text:'text-red-500',  label:'Dibatalkan'          },
    'SELESAI':             { bg:'bg-green-50',       text:'text-green-600',label:'Selesai'             },
    'DIKONFIRMASI':        { bg:'bg-purplec-light',  text:'text-purplec',  label:'Dikonfirmasi'        },
  };

  function getStatusStyle(status){
    const key = (status || '').toUpperCase().trim();
    return STATUS_STYLE[key] || { bg:'bg-[#f1f1f5]', text:'text-[#5b5b6b]', label: status || '-' };
  }

  function formatRupiah(angka){
    const n = Number(angka) || 0;
    return 'Rp ' + n.toLocaleString('id-ID');
  }

  function renderRiwayat(){
    const listEl = document.getElementById('list');
    const emptyEl = document.getElementById('empty');
    const footerEl = document.getElementById('footerNote');
    const footerText = document.getElementById('footerText');

    // MENGAMBIL DATA DARI PHP (Database)
    // Kolom yang dipakai di bawah: id_transaksi, destinasi, tanggal_pesan,
    // total_bayar, status, jumlah_orang, gambar (opsional).
    // Sesuaikan nama kolom di sini kalau berbeda dengan tabel pemesanan_tiket Anda.
    const riwayat = <?php echo json_encode($riwayat_db); ?>;

    if (riwayat.length === 0) {
      listEl.innerHTML = '';
      emptyEl.classList.remove('hidden');
      emptyEl.classList.add('flex');
      footerEl.classList.add('hidden');
      return;
    }

    emptyEl.classList.add('hidden');
    footerEl.classList.remove('hidden');
    footerEl.classList.add('flex');
    footerText.textContent = `Menampilkan ${riwayat.length} dari ${riwayat.length} riwayat pemesanan`;

    listEl.innerHTML = riwayat.map((o) => {
      const st = getStatusStyle(o.status);
      const gambar = o.gambar || 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=600&q=80';

      return `
      <div class="bg-white rounded-[20px] p-4 grid grid-cols-1 md:grid-cols-[220px_1fr_260px] gap-6 items-center shadow-[0_4px_18px_rgba(30,20,90,0.05)]">
        <div class="relative w-full h-[150px] rounded-2xl overflow-hidden">
          <img src="${gambar}" alt="${o.destinasi || 'Destinasi'}" class="w-full h-full object-cover">
          <div class="absolute bottom-2.5 left-2.5 w-9 h-9 bg-white rounded-full flex items-center justify-center text-base shadow-md">🎫</div>
        </div>
        <div class="flex flex-col gap-2 min-w-0">
          <div class="flex items-center gap-2.5 flex-wrap">
            <span class="text-purplec font-bold text-sm">#${o.id_transaksi}</span>
            <span class="text-xs font-bold px-3 py-1 rounded-full ${st.bg} ${st.text} tracking-wide">${st.label}</span>
          </div>
          <div class="text-[15px] font-bold text-[#1e2433] mt-0.5">${o.nama_pembeli || 'Pemesan'}</div>
          <div class="text-mutedc text-sm leading-relaxed truncate">📍 ${o.destinasi || '-'}</div>
          <div class="flex gap-4 text-mutedc text-[13px] mt-1">
            <span class="inline-flex items-center gap-1.5">📅 ${o.tanggal_pesan || '-'}</span>
          </div>
        </div>
        <div class="flex flex-col items-end gap-2.5 md:border-l md:border-bordc md:pl-6 pt-4 md:pt-0 border-t md:border-t-0 border-bordc justify-center">
          <div class="text-[11px] tracking-wide text-mutedc font-bold self-start md:self-end">TOTAL PEMBAYARAN</div>
          <div class="text-2xl font-extrabold text-purplec">${formatRupiah(o.total_bayar)}</div>
          ${o.jumlah_orang ? `<div class="bg-purplec-light text-purplec text-[13px] font-semibold px-3 py-1 rounded-full inline-flex items-center gap-1.5">👥 ${o.jumlah_orang} Orang</div>` : ''}
          <a href="detail_pesanan.php?order_id=${encodeURIComponent(o.id_transaksi)}" class="w-full bg-white border-[1.5px] border-bordc text-purplec font-bold text-sm py-2.5 px-4 rounded-xl inline-flex items-center justify-center gap-1.5 hover:bg-purplec-light transition">
            Lihat Detail <span>&rsaquo;</span>
          </a>
        </div>
      </div>`;
    }).join('');
  }

  renderRiwayat();
</script>

</body>
</html>