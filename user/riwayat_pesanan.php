<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Madiun Track - Riwayat Pemesanan</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
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

<!-- MODAL DETAIL PESANAN -->
<div id="modalOverlay" class="hidden fixed inset-0 bg-[#1e2433]/50 backdrop-blur-sm z-50 items-center justify-center p-4" onclick="if(event.target===this) tutupDetail()">
  <div class="bg-white w-full max-w-[520px] max-h-[88vh] overflow-y-auto rounded-[24px] shadow-2xl">

    <!-- Header modal -->
    <div class="relative">
      <img id="mGambar" src="" alt="" class="w-full h-[170px] object-cover rounded-t-[24px]">
      <button onclick="tutupDetail()" class="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 flex items-center justify-center shadow-md">
        <svg viewBox="0 0 24 24" fill="none" stroke="#1e2433" stroke-width="2" class="w-4.5 h-4.5"><path d="M18 6L6 18M6 6l12 12"/></svg>
      </button>
      <div class="absolute bottom-3 left-4 flex items-center gap-2.5 flex-wrap">
        <span id="mOrderId" class="text-white font-bold text-sm bg-black/30 px-3 py-1 rounded-full backdrop-blur-sm"></span>
        <span id="mStatus" class="text-xs font-bold px-3 py-1 rounded-full tracking-wide"></span>
      </div>
    </div>

    <div class="p-6 flex flex-col gap-5">
      <div>
        <div class="text-[22px] font-bold text-[#1e2433]" id="mNama"></div>
        <div class="flex items-start gap-2 text-mutedc text-sm leading-relaxed mt-1">
          <span class="mt-0.5 shrink-0">📍</span>
          <span id="mLokasi"></span>
        </div>
      </div>

      <!-- Info jadwal -->
      <div class="grid grid-cols-2 gap-3">
        <div class="bg-[#f7f8fc] rounded-2xl p-3.5">
          <div class="text-[11px] text-mutedc font-bold tracking-wide mb-1">TANGGAL</div>
          <div class="font-bold text-sm flex items-center gap-1.5">📅 <span id="mTanggal"></span></div>
        </div>
        <div class="bg-[#f7f8fc] rounded-2xl p-3.5">
          <div class="text-[11px] text-mutedc font-bold tracking-wide mb-1">JAM</div>
          <div class="font-bold text-sm flex items-center gap-1.5">🕐 <span id="mJam"></span></div>
        </div>
        <div class="bg-[#f7f8fc] rounded-2xl p-3.5">
          <div class="text-[11px] text-mutedc font-bold tracking-wide mb-1">JUMLAH ORANG</div>
          <div class="font-bold text-sm flex items-center gap-1.5">👥 <span id="mJumlahOrang"></span></div>
        </div>
        <div class="bg-[#f7f8fc] rounded-2xl p-3.5">
          <div class="text-[11px] text-mutedc font-bold tracking-wide mb-1">METODE BAYAR</div>
          <div class="font-bold text-sm flex items-center gap-1.5">💳 <span id="mMetode"></span></div>
        </div>
      </div>

      <!-- Data pemesan -->
      <div id="mPemesanWrap" class="border-t border-bordc pt-4">
        <div class="text-[11px] text-mutedc font-bold tracking-wide mb-2">DATA PEMESAN</div>
        <div class="flex flex-col gap-1.5 text-sm" id="mPemesanIsi"></div>
      </div>

      <!-- Rincian biaya -->
      <div class="border-t border-bordc pt-4">
        <div class="text-[11px] text-mutedc font-bold tracking-wide mb-2">RINCIAN BIAYA</div>
        <div class="flex flex-col gap-2 text-sm" id="mRincian"></div>
        <div class="flex items-center justify-between mt-3 pt-3 border-t border-dashed border-bordc">
          <span class="font-bold text-[#1e2433]">Total Pembayaran</span>
          <span class="text-xl font-extrabold text-purplec" id="mTotal"></span>
        </div>
      </div>

      <!-- QR Code untuk check-in di loket -->
      <div id="mQrWrap" class="border-t border-bordc pt-4 flex flex-col items-center text-center">
        <div class="text-[11px] text-mutedc font-bold tracking-wide mb-3">KODE TIKET</div>
        <div id="mQrCode" class="p-3 bg-white border-[1.5px] border-bordc rounded-2xl inline-block"></div>
        <div class="text-mutedc text-[13px] mt-3 max-w-[280px]">Tunjukkan QR code ini ke petugas di loket untuk scan / check-in.</div>
      </div>

      <button onclick="tutupDetail()" class="w-full bg-purplec text-white font-bold text-sm py-3 rounded-xl mt-1 hover:opacity-90 transition">
        Tutup
      </button>
    </div>
  </div>
</div>

<script>
  // Palet badge status. Tambahkan status lain di sini kalau perlu
  // (mis. 'SELESAI', 'DIKONFIRMASI', dst).
  const STATUS_STYLE = {
    DIPROSES:   { bg:'bg-orange-light',        text:'text-orange',   label:'DIPROSES'   },
    DIBATALKAN: { bg:'bg-red-50',              text:'text-red-500',  label:'DIBATALKAN' },
    SELESAI:    { bg:'bg-green-50',            text:'text-green-600',label:'SELESAI'    },
    DIKONFIRMASI:{ bg:'bg-purplec-light',      text:'text-purplec',  label:'DIKONFIRMASI' },
  };

  function formatRupiah(angka){
    const n = Number(angka) || 0;
    return 'Rp ' + n.toLocaleString('id-ID');
  }

  function lokasiText(lokasi){
    if(Array.isArray(lokasi)) return lokasi.filter(Boolean).join(', ');
    return lokasi || '-';
  }

  function renderRiwayat(){
    const listEl = document.getElementById('list');
    const emptyEl = document.getElementById('empty');
    const footerEl = document.getElementById('footerNote');
    const footerText = document.getElementById('footerText');

    let riwayat = [];
    try {
      riwayat = JSON.parse(localStorage.getItem('madiuntrack_riwayat') || '[]');
    } catch(e) {
      riwayat = [];
    }

    if(riwayat.length === 0){
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

    listEl.innerHTML = riwayat.map((o, idx) => {
      const st = STATUS_STYLE[o.status] || STATUS_STYLE.DIPROSES;
      const gambar = o.gambar || 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=600&q=80';

      return `
      <div class="bg-white rounded-[20px] p-4 grid grid-cols-1 md:grid-cols-[220px_1fr_260px] gap-6 items-center shadow-[0_4px_18px_rgba(30,20,90,0.05)]">
        <div class="relative w-full h-[150px] rounded-2xl overflow-hidden">
          <img src="${gambar}" alt="${o.nama || 'Destinasi'}" class="w-full h-full object-cover">
          <div class="absolute bottom-2.5 left-2.5 w-9 h-9 bg-white rounded-full flex items-center justify-center text-base shadow-md">🎫</div>
        </div>
        <div class="flex flex-col gap-2 min-w-0">
          <div class="flex items-center gap-2.5 flex-wrap">
            <span class="text-purplec font-bold text-sm">#${o.order_id || 'TRX-XXXXXX'}</span>
            <span class="text-xs font-bold px-3 py-1 rounded-full ${st.bg} ${st.text} tracking-wide">${st.label}</span>
          </div>
          <div class="text-[22px] font-bold text-[#1e2433] mt-0.5 truncate">${o.nama || 'Pemesan'}</div>
          <div class="flex items-start gap-2 text-mutedc text-sm leading-relaxed">
            <span class="mt-0.5 shrink-0">📍</span>
            <span>${lokasiText(o.lokasi)}</span>
          </div>
          <div class="flex gap-4 text-mutedc text-[13px] mt-1">
            <span class="inline-flex items-center gap-1.5">📅 ${o.tanggal || '-'}</span>
            <span class="inline-flex items-center gap-1.5">🕐 ${o.jam || '-'}</span>
          </div>
        </div>
        <div class="flex flex-col items-end gap-2.5 md:border-l md:border-bordc md:pl-6 pt-4 md:pt-0 border-t md:border-t-0 border-bordc justify-center">
          <div class="text-[11px] tracking-wide text-mutedc font-bold self-start md:self-end">TOTAL PEMBAYARAN</div>
          <div class="text-2xl font-extrabold text-purplec">${formatRupiah(o.total)}</div>
          <div class="bg-purplec-light text-purplec text-[13px] font-semibold px-3 py-1 rounded-full inline-flex items-center gap-1.5">👥 ${o.jumlah_orang || 1} Orang</div>
          <button onclick="lihatDetail(${idx})" class="w-full bg-white border-[1.5px] border-bordc text-purplec font-bold text-sm py-2.5 px-4 rounded-xl inline-flex items-center justify-center gap-1.5 hover:bg-purplec-light transition">
            Lihat Detail <span>&rsaquo;</span>
          </button>
        </div>
      </div>`;
    }).join('');
  }

  function lihatDetail(idx){
    const riwayat = JSON.parse(localStorage.getItem('madiuntrack_riwayat') || '[]');
    const order = riwayat[idx];
    if(!order) return;

    const st = STATUS_STYLE[order.status] || STATUS_STYLE.DIPROSES;
    const gambar = order.gambar || 'https://images.unsplash.com/photo-1596422846543-75c6fc197f07?w=800&q=80';

    document.getElementById('mGambar').src = gambar;
    document.getElementById('mGambar').alt = order.nama || 'Destinasi';
    document.getElementById('mOrderId').textContent = '#' + (order.order_id || 'TRX-XXXXXX');

    const statusEl = document.getElementById('mStatus');
    statusEl.textContent = st.label;
    statusEl.className = 'text-xs font-bold px-3 py-1 rounded-full tracking-wide ' + st.bg + ' ' + st.text;

    document.getElementById('mNama').textContent = order.nama || 'Pemesan';
    document.getElementById('mLokasi').textContent = lokasiText(order.lokasi);
    document.getElementById('mTanggal').textContent = order.tanggal || '-';
    document.getElementById('mJam').textContent = order.jam || '-';
    document.getElementById('mJumlahOrang').textContent = (order.jumlah_orang || 1) + ' Orang';
    document.getElementById('mMetode').textContent = order.metode_pembayaran || order.metode || '-';
    document.getElementById('mTotal').textContent = formatRupiah(order.total);

    // Data pemesan (nama pemesan, email, no telepon, dsb — sesuaikan dgn field yang tersimpan)
    const pemesanWrap = document.getElementById('mPemesanWrap');
    const pemesanIsi = document.getElementById('mPemesanIsi');
    const dataPemesan = [
      { label: 'Nama Pemesan', val: order.nama_pemesan || order.nama },
      { label: 'Email', val: order.email },
      { label: 'No. Telepon', val: order.telepon || order.no_hp },
      { label: 'Catatan', val: order.catatan },
    ].filter(d => d.val);

    if(dataPemesan.length){
      pemesanWrap.classList.remove('hidden');
      pemesanIsi.innerHTML = dataPemesan.map(d => `
        <div class="flex justify-between gap-4">
          <span class="text-mutedc">${d.label}</span>
          <span class="font-semibold text-right">${d.val}</span>
        </div>`).join('');
    } else {
      pemesanWrap.classList.add('hidden');
    }

    // Rincian biaya (rincian pembayaran lengkap ala struk)
    // Prioritas: order.rincian (array custom {label, nilai}) kalau ada,
    // kalau tidak, disusun otomatis dari field-field umum yang mungkin tersimpan.
    const rincianEl = document.getElementById('mRincian');
    let items = [];

    if(Array.isArray(order.rincian) && order.rincian.length){
      items = order.rincian.map(r => ({ label: r.label, nilai: r.nilai, minus: !!r.minus }));
    } else {
      const jumlahOrang = order.jumlah_orang || 1;
      const hargaSatuan = order.harga_satuan || (order.subtotal ? order.subtotal / jumlahOrang : null);

      if(hargaSatuan){
        items.push({ label: `Harga Tiket x ${jumlahOrang} orang`, nilai: hargaSatuan * jumlahOrang });
      } else if(order.subtotal){
        items.push({ label: `Subtotal (${jumlahOrang} orang)`, nilai: order.subtotal });
      } else {
        items.push({ label: `Harga Tiket (${jumlahOrang} orang)`, nilai: order.total });
      }

      if(order.biaya_admin)  items.push({ label: 'Biaya Admin', nilai: order.biaya_admin });
      if(order.biaya_layanan) items.push({ label: 'Biaya Layanan', nilai: order.biaya_layanan });
      if(order.asuransi)      items.push({ label: 'Asuransi Perjalanan', nilai: order.asuransi });
      if(order.pajak)         items.push({ label: 'Pajak', nilai: order.pajak });
      if(order.diskon)        items.push({ label: 'Diskon' + (order.kode_promo ? ` (${order.kode_promo})` : ''), nilai: order.diskon, minus: true });
    }

    rincianEl.innerHTML = items.map(it => `
      <div class="flex justify-between">
        <span class="text-mutedc">${it.label}</span>
        <span class="font-semibold ${it.minus ? 'text-red-500' : ''}">${it.minus ? '-' : ''}${formatRupiah(Math.abs(it.nilai))}</span>
      </div>`).join('');

    // QR Code untuk check-in di loket (tidak ditampilkan kalau pesanan dibatalkan)
    const qrWrap = document.getElementById('mQrWrap');
    const qrBox = document.getElementById('mQrCode');
    qrBox.innerHTML = '';

    if(order.status === 'DIBATALKAN'){
      qrWrap.classList.add('hidden');
    } else {
      qrWrap.classList.remove('hidden');
      // Payload QR: berisi data ringkas pesanan agar bisa diverifikasi petugas loket
      const qrPayload = JSON.stringify({
        order_id: order.order_id || null,
        nama: order.nama_pemesan || order.nama || null,
        destinasi: order.nama || null,
        tanggal: order.tanggal || null,
        jam: order.jam || null,
        jumlah_orang: order.jumlah_orang || 1,
        total: order.total || 0
      });

      new QRCode(qrBox, {
        text: qrPayload,
        width: 160,
        height: 160,
        colorDark: '#1e2433',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.M
      });
    }

    const overlay = document.getElementById('modalOverlay');
    overlay.classList.remove('hidden');
    overlay.classList.add('flex');
    document.body.style.overflow = 'hidden';
  }

  function tutupDetail(){
    const overlay = document.getElementById('modalOverlay');
    overlay.classList.add('hidden');
    overlay.classList.remove('flex');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', (e) => {
    if(e.key === 'Escape') tutupDetail();
  });

  renderRiwayat();
</script>

</body>
</html>