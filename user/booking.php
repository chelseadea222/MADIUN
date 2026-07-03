<?php
session_start();
require_once '../config/koneksi.php';
require_once 'homestay_madiun.php'; // isi $homestay_madiun

// Kalau datang dari tombol "Booking" di homestay_madiun.php (?id=...),
// homestay itu otomatis ke-pilih di dropdown.
$selectedId = $_GET['id'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Madiun Track - Booking Homestay</title>
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
          navy:   '#0f1f45',
          mutedc: '#8b93a7',
          bordc:  '#e6e8f0',
        }
      }
    }
  }
</script>
<style>
  body{ font-family:'Plus Jakarta Sans', sans-serif; }
  input:focus, select:focus{ outline:none; border-color:#f7941d; box-shadow:0 0 0 3px rgba(247,148,29,0.12); }
  .dashed{ border-top:1.5px dashed #e2e4ee; }
</style>
</head>
<body class="bg-[#eef0f5] min-h-screen flex items-center justify-center p-5">

<div class="w-full max-w-[1320px] bg-white rounded-[32px] shadow-[0_25px_70px_-25px_rgba(15,31,69,0.35)] overflow-hidden grid grid-cols-1 lg:grid-cols-[460px_1fr]">

  <!-- LEFT: HERO -->
  <div class="relative min-h-[420px] lg:min-h-full flex flex-col p-8 lg:p-10 text-white overflow-hidden">
    <img src="https://images.unsplash.com/photo-1518998053901-5348d3961a04?w=900&q=70" alt="Madiun" class="absolute inset-0 w-full h-full object-cover">
    <div class="absolute inset-0 bg-gradient-to-b from-navy/80 via-navy/50 to-navy/90"></div>

    <button onclick="window.history.back()" class="relative z-10 flex items-center gap-2.5 mb-10 w-fit">
      <span class="w-9 h-9 rounded-full bg-white flex items-center justify-center shrink-0">
        <svg viewBox="0 0 24 24" fill="none" stroke="#0f1f45" stroke-width="2.2" class="w-4 h-4"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      </span>
      <span class="font-bold text-[14px]">Kembali</span>
    </button>

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
</script>

</body>
</html>