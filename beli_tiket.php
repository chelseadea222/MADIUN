<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Halaman ini hanya boleh diakses oleh member yang sudah login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['nama'])) {
    header('Location: login.php');
    exit;
}

$namaMember = $_SESSION['nama'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Madiun Track - Destinasi Wisata</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        bgc: '#f3f4f8',
        textc: '#1e2433',
        orange: '#f7941d',
        orangeLight: '#fff1e0',
        blue: '#3b6fe0',
        blueLight: '#eef1fd',
        navy: '#0f1f45',
        muted: '#8b93a7',
        borderc: '#eaecf2',
        purpleLight: '#f3e8ff',
        purple: '#9333ea',
      },
      fontFamily: {
        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
      },
    },
  },
};
</script>
<style>
  /* Scrollbar tipis untuk daftar ringkasan pembayaran */
  .summary-list::-webkit-scrollbar { width: 4px; }
  .summary-list::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
</style>
</head>
<body class="bg-bgc text-textc font-sans text-sm">

<div class="max-w-[1400px] mx-auto p-5">

  <div class="flex items-center justify-between flex-wrap gap-4 mb-5">
    <div class="flex items-center gap-3">
      <a href="index.php" class="w-9 h-9 rounded-full bg-white border border-borderc flex items-center justify-center shadow-sm hover:bg-slate-50 transition-colors" title="Kembali ke Beranda">
        <svg viewBox="0 0 24 24" fill="none" stroke="#1e2433" stroke-width="2" width="16" height="16"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
      </a>
      <div class="flex items-center gap-2">
        <div class="w-8 h-8 rounded-lg bg-orange text-white flex items-center justify-center shrink-0">
          <svg viewBox="0 0 24 24" fill="currentColor" width="16" height="16"><path d="M12 2C7.6 2 4 5.6 4 10c0 5.4 7 11.5 7.3 11.8.2.1.4.2.7.2s.5-.1.7-.2C13 21.5 20 15.4 20 10c0-4.4-3.6-8-8-8zm0 11c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/></svg>
        </div>
        <div>
          <div class="font-extrabold text-base leading-tight">Madiun<span class="text-orange">Track</span></div>
          <div class="text-[10px] text-muted font-semibold tracking-wide">TICKETING DASHBOARD</div>
        </div>
      </div>
    </div>

    <div class="flex items-center gap-3">
      <div class="bg-white border border-borderc rounded-xl px-3.5 py-2 shadow-sm cursor-pointer flex items-center gap-2">
        <svg viewBox="0 0 24 24" fill="none" stroke="#3b6fe0" stroke-width="2" width="16" height="16"><path d="M3 8.5c0-1 .5-1.7 1.3-2.2M21 8.5c0-1-.5-1.7-1.3-2.2M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/><circle cx="12" cy="8" r="4"/></svg>
        <div>
          <div class="font-bold text-xs leading-tight">Butuh bantuan?</div>
          <div class="text-[10.5px] text-muted">Hubungi kami</div>
        </div>
      </div>

      <div class="relative w-10 h-10 rounded-full bg-white border border-borderc flex items-center justify-center shadow-sm cursor-pointer shrink-0">
        <svg viewBox="0 0 24 24" fill="none" stroke="#5b6274" stroke-width="2" width="16" height="16"><path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 01-3.4 0"/></svg>
        <div class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] font-bold w-[18px] h-[18px] rounded-full flex items-center justify-center border-2 border-white">3</div>
      </div>

      <div class="flex items-center gap-2 cursor-pointer">
        <img src="https://i.pravatar.cc/80?img=47" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm" alt="avatar">
        <div>
          <div class="font-bold text-[12.5px] leading-tight"><?= htmlspecialchars($namaMember) ?></div>
          <div class="text-[10.5px] text-muted">Member</div>
        </div>
        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-[1fr_340px] gap-5">

    <div class="bg-white border border-borderc rounded-3xl p-6 relative overflow-hidden">
      <div class="flex items-center justify-between font-extrabold text-lg mb-1 relative z-10">
        <div class="flex items-center gap-1">Destinasi Wisata <span>✨</span></div>
        <div class="text-orange bg-orangeLight font-bold text-[12.5px] px-3 py-1.5 rounded-full flex items-center gap-1.5">
          <svg viewBox="0 0 24 24" fill="currentColor" width="14" height="14"><path d="M12 2l2.5 6H21l-5 4 2 7-6-4-6 4 2-7-5-4h6.5z"/></svg>
          <span id="selectedCount">0</span> Terpilih
        </div>
      </div>
      <p class="text-muted text-[13px] mb-5 relative z-10">Pilih destinasi favoritmu dan nikmati pengalaman terbaik di Madiun!</p>

      <img src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a?w=600&q=60" class="absolute top-0 right-0 w-[380px] h-[110px] object-cover opacity-30 rounded-bl-3xl pointer-events-none select-none" alt="">

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 relative z-10" id="destGrid"></div>

      <div class="bg-blueLight rounded-2xl p-4 mt-5 flex items-center justify-between flex-wrap gap-4">
        <div class="flex gap-3 items-start max-w-[320px]">
          <div class="w-9 h-9 rounded-full bg-white flex items-center justify-center shrink-0">
            <svg viewBox="0 0 24 24" fill="none" stroke="#3b6fe0" stroke-width="2" width="16" height="16"><rect x="3" y="6" width="18" height="12" rx="2"/></svg>
          </div>
          <div>
            <div class="font-bold text-[12.5px] mb-0.5">Informasi Tiket</div>
            <div class="text-[11.5px] text-muted leading-relaxed">Tiket berlaku untuk 1 orang dan hanya dapat digunakan pada tanggal kunjungan yang dipilih.</div>
          </div>
        </div>

        <div class="flex items-center gap-5 flex-wrap">
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shrink-0">
              <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" width="16" height="16"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
            </div>
            <div>
              <div class="font-bold text-[11.5px]">Tiket Resmi</div>
              <div class="text-[10.5px] text-muted">Terjamin</div>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shrink-0">
              <svg viewBox="0 0 24 24" fill="none" stroke="#3b6fe0" stroke-width="2" width="16" height="16"><path d="M13 2L3 14h7l-1 8 10-12h-7z"/></svg>
            </div>
            <div>
              <div class="font-bold text-[11.5px]">Mudah &amp; Cepat</div>
              <div class="text-[10.5px] text-muted">Pembelian</div>
            </div>
          </div>
          <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shrink-0">
              <svg viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2" width="16" height="16"><path d="M12 2l8 3v6c0 5-3.5 8.5-8 11-4.5-2.5-8-6-8-11V5z"/></svg>
            </div>
            <div>
              <div class="font-bold text-[11.5px]">Aman</div>
              <div class="text-[10.5px] text-muted">Transaksi 100%</div>
            </div>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-5 pt-5 border-t border-borderc">
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-orangeLight text-orange flex items-center justify-center shrink-0">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
          </div>
          <div>
            <div class="font-bold text-[11.5px]">Harga Terbaik</div>
            <div class="text-[10.5px] text-muted">Jaminan harga resmi</div>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-purpleLight text-purple flex items-center justify-center shrink-0">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><rect x="3" y="6" width="18" height="12" rx="2"/></svg>
          </div>
          <div>
            <div class="font-bold text-[11.5px]">Tiket Instan</div>
            <div class="text-[10.5px] text-muted">Langsung diterima</div>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-orangeLight text-orange flex items-center justify-center shrink-0">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
          </div>
          <div>
            <div class="font-bold text-[11.5px]">Banyak Pilihan</div>
            <div class="text-[10.5px] text-muted">Destinasi menarik</div>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <div class="w-8 h-8 rounded-lg bg-purpleLight text-purple flex items-center justify-center shrink-0">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><path d="M3 8.5c0-1 .5-1.7 1.3-2.2M21 8.5c0-1-.5-1.7-1.3-2.2M6 21v-2a4 4 0 014-4h4a4 4 0 014 4v2"/><circle cx="12" cy="8" r="4"/></svg>
          </div>
          <div>
            <div class="font-bold text-[11.5px]">Customer Support</div>
            <div class="text-[10.5px] text-muted">Siap membantu</div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex flex-col gap-5">

      <div class="bg-white border border-borderc rounded-3xl p-6 relative overflow-hidden">
        <div class="flex items-center gap-2 font-extrabold text-[15px] mb-5">
          <div class="w-8 h-8 rounded-lg bg-purpleLight text-purple flex items-center justify-center shrink-0">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16"><rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h8M8 11h8M8 15h5"/></svg>
          </div>
          Lengkapi Data
        </div>

        <label class="block text-[12.5px] font-semibold mb-1.5">Nama Pengunjung</label>
        <input type="text" id="visitorName" value="<?= htmlspecialchars($namaMember) ?>" placeholder="Sesuai KTP" class="w-full border border-borderc rounded-xl px-4 py-3 text-[13px] outline-none mb-1.5 bg-white transition-colors focus:border-blue">
        <div class="text-[10.5px] text-muted mb-4">Otomatis terisi dari akun Anda. Bisa diubah bila membeli untuk orang lain.</div>

        <label class="block text-[12.5px] font-semibold mb-1.5">Metode Pembayaran</label>
        <select id="payMethod" class="w-full border border-borderc rounded-xl px-4 py-3 text-[13px] outline-none mb-1.5 bg-white transition-colors focus:border-blue">
          <option value="">Pilih metode...</option>
          <option value="qris">QRIS</option>
          <option value="bca">Transfer BCA</option>
          <option value="bni">Transfer BNI</option>
          <option value="mandiri">Transfer Mandiri</option>
        </select>
        <div class="text-[10.5px] text-muted">Kamu bisa memilih lebih dari satu destinasi — atur jumlah tiket langsung di tiap kartu destinasi.</div>

        <div class="bg-blueLight rounded-xl p-3.5 mt-5 flex items-center gap-3">
          <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center shrink-0">
            <svg viewBox="0 0 24 24" fill="none" stroke="#3b6fe0" stroke-width="2" width="16" height="16"><path d="M12 2l8 3v6c0 5-3.5 8.5-8 11-4.5-2.5-8-6-8-11V5z"/></svg>
          </div>
          <div>
            <div class="font-bold text-xs text-textc">Keamanan Terjamin</div>
            <div class="text-[11px] text-muted leading-relaxed">Data dan transaksi Anda aman bersama kami.</div>
          </div>
        </div>
      </div>

      <div class="bg-navy text-white rounded-3xl p-6 relative overflow-hidden">
        <div class="flex items-center gap-2 font-extrabold text-[15px] mb-5 relative z-10">
          <svg viewBox="0 0 24 24" fill="none" stroke="#f7941d" stroke-width="2" width="16" height="16"><rect x="3" y="6" width="18" height="12" rx="2"/></svg>
          Rincian Pembayaran
        </div>

        <div class="relative z-10">
          <div id="sumItems" class="summary-list max-h-40 overflow-y-auto mb-4 pr-1"></div>
          <div id="sumEmpty" class="text-[12.5px] text-white/50 mb-4">Belum ada destinasi dipilih.</div>

          <div class="flex items-center justify-between text-[13px] pb-4 mb-4 border-b border-dashed border-white/20">
            <span class="text-white/60">Biaya Layanan</span>
            <span class="font-semibold">Rp 0</span>
          </div>

          <div class="text-xs text-white/50 mb-1">Total Pembayaran</div>
          <div class="text-[26px] font-extrabold text-orange mb-5" id="sumTotal">Rp 0</div>
        </div>

        <button id="btnBayar" class="w-full flex items-center justify-center gap-2 bg-orange text-white font-bold py-3.5 rounded-xl text-sm transition relative z-10 hover:brightness-105 active:scale-[0.99] disabled:opacity-50 disabled:cursor-not-allowed">
          Bayar Sekarang
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" width="16" height="16"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
        </button>
        <div class="flex items-center justify-center gap-1 text-[11px] text-white/60 mt-3 relative z-10">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="14" height="14"><path d="M9 12l2 2 4-4"/><circle cx="12" cy="12" r="9"/></svg>
          Pembayaran Anda dilindungi 100%
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const destinations = [
    { id:1, name:"Pahlawan Street Center (PSC)", price:10000, img:"https://images.unsplash.com/photo-1548013146-72479768bada?w=200&q=70" },
    { id:2, name:"Taman Sumber Umis", price:5000, img:"https://images.unsplash.com/photo-1519331379826-f10be5486c6f?w=200&q=70" },
    { id:3, name:"Alun-Alun Kota Madiun", price:5000, img:"https://images.unsplash.com/photo-1519744792095-2f2205e87b6f?w=200&q=70" },
    { id:4, name:"Taman Bantaran Kali Madiun", price:5000, img:"https://images.unsplash.com/photo-1500534623283-312aade485b7?w=200&q=70" },
    { id:5, name:"Monumen Kresek", price:5000, img:"https://images.unsplash.com/photo-1543429257-27a3a3aa0e0e?w=200&q=70" },
    { id:6, name:"Madiun Umbul Square", price:20000, img:"https://images.unsplash.com/photo-1519046904884-53103b34b206?w=200&q=70" },
    { id:7, name:"Taman Trembesi", price:10000, img:"https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=200&q=70" },
    { id:8, name:"Waduk Bening Widas", price:15000, img:"https://images.unsplash.com/photo-1439405326854-014607f694d7?w=200&q=70" },
    { id:9, name:"Desa Wisata Brumbun", price:25000, img:"https://images.unsplash.com/photo-1470770903676-69b98201ea1c?w=200&q=70" },
    { id:10, name:"Ngrowo Bening Edupark", price:15000, img:"https://images.unsplash.com/photo-1501854140801-50d01698950b?w=200&q=70" },
    { id:11, name:"Hutan Pinus NONGKO IJO", price:10000, img:"https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=200&q=70" },
  ];

  const cart = { 1: 1 };
  const grid = document.getElementById('destGrid');

  function formatRp(n){
    return "Rp " + n.toLocaleString('id-ID');
  }

  function renderGrid(){
    grid.innerHTML = "";
    destinations.forEach(d=>{
      const qty = cart[d.id] || 0;
      const isSelected = qty > 0;

      const card = document.createElement('div');
      card.className = `flex items-center gap-2.5 border rounded-xl p-2.5 bg-white transition-all cursor-pointer hover:border-slate-400 ${isSelected ? 'border-orange bg-orangeLight/40' : 'border-borderc'}`;

      card.innerHTML = `
        <img src="${d.img}" class="w-11 h-11 rounded-lg object-cover pointer-events-none" alt="${d.name}">
        <div class="flex-1 min-w-0" data-role="select" data-id="${d.id}">
          <div class="font-semibold text-[11.5px] leading-tight whitespace-nowrap overflow-hidden text-ellipsis">${d.name}</div>
          <div class="text-orange font-bold text-[11.5px]">${formatRp(d.price)}</div>
        </div>
        ${isSelected
          ? `<div class="flex items-center gap-1.5 shrink-0">
               <button data-action="dec" data-id="${d.id}" class="w-6 h-6 rounded-md flex items-center justify-center font-bold text-[11px] bg-white border border-borderc text-slate-600">−</button>
               <span class="font-bold text-[11.5px] w-3 text-center">${qty}</span>
               <button data-action="inc" data-id="${d.id}" class="w-6 h-6 rounded-md flex items-center justify-center font-bold text-[11px] bg-orange text-white">+</button>
             </div>`
          : `<button data-action="inc" data-id="${d.id}" class="w-6 h-6 rounded-full border-2 border-borderc bg-white text-muted flex items-center justify-center font-bold text-xs shrink-0">+</button>`
        }
      `;
      grid.appendChild(card);
    });

    grid.querySelectorAll('[data-role="select"]').forEach(el=>{
      el.addEventListener('click', ()=>{
        const id = parseInt(el.dataset.id);
        if(!cart[id]) cart[id] = 1;
        renderGrid();
        updateSummary();
      });
    });

    grid.querySelectorAll('button[data-action]').forEach(btn=>{
      btn.addEventListener('click', (e)=>{
        e.stopPropagation();
        const id = parseInt(btn.dataset.id);
        const action = btn.dataset.action;
        if(action === 'inc') cart[id] = (cart[id]||0) + 1;
        if(action === 'dec'){
          cart[id] = Math.max(0, (cart[id]||0) - 1);
          if(cart[id] === 0) delete cart[id];
        }
        renderGrid();
        updateSummary();
      });
    });
  }

  function updateSummary(){
    const ids = Object.keys(cart);
    document.getElementById('selectedCount').textContent = ids.length;

    const itemsWrap = document.getElementById('sumItems');
    const emptyMsg = document.getElementById('sumEmpty');

    if(ids.length === 0){
      itemsWrap.innerHTML = "";
      emptyMsg.style.display = 'block';
      document.getElementById('sumTotal').textContent = formatRp(0);
      return;
    }

    emptyMsg.style.display = 'none';
    let total = 0;

    itemsWrap.innerHTML = ids.map(id=>{
      const d = destinations.find(x=>x.id == id);
      const qty = cart[id];
      const subtotal = d.price * qty;
      total += subtotal;
      return `
        <div class="flex items-center justify-between text-[12.5px] mb-2.5">
          <span class="text-white/70 whitespace-nowrap overflow-hidden text-ellipsis pr-2">${d.name} <span class="text-white/40">x${qty}</span></span>
          <span class="font-semibold shrink-0">${formatRp(subtotal)}</span>
        </div>`;
    }).join("");

    document.getElementById('sumTotal').textContent = formatRp(total);
  }

  renderGrid();
  updateSummary();

  // BAYAR SEKARANG
  document.getElementById('btnBayar').addEventListener('click', function() {
    const nameInput = document.getElementById('visitorName');
    const payMethod = document.getElementById('payMethod');
    const ids = Object.keys(cart);

    let errors = [];
    if(ids.length === 0) errors.push("Pilih minimal satu destinasi.");
    if(!nameInput.value.trim()) errors.push("Nama pengunjung wajib diisi.");
    if(!payMethod.value) errors.push("Pilih metode pembayaran.");

    nameInput.classList.remove('border-red-500');
    payMethod.classList.remove('border-red-500');

    if(errors.length > 0){
      if(!nameInput.value.trim()) nameInput.classList.add('border-red-500');
      if(!payMethod.value) payMethod.classList.add('border-red-500');
      alert("Mohon lengkapi dulu:\n\n- " + errors.join("\n- "));
      return;
    }

    const payloadItems = ids.map(id => {
      const d = destinations.find(x => x.id == id);
      return { destinasi: d.name, harga: d.price, jumlah: cart[id] };
    });

    const formData = new FormData();
    formData.append('nama', nameInput.value.trim());
    formData.append('metode', payMethod.value);
    formData.append('items', JSON.stringify(payloadItems));

    const btn = document.getElementById('btnBayar');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = 'Memproses...';

    fetch('proses_beli_tiket.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if(data.order_id) {
        window.location.href = "konfirmasi_pembayaran.php?order_id=" + data.order_id;
      } else {
        alert("Gagal: " + (data.error || "Terjadi kesalahan saat memproses pesanan."));
        btn.disabled = false;
        btn.innerHTML = originalText;
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert("Terjadi kesalahan jaringan atau respons server tidak valid.");
      btn.disabled = false;
      btn.innerHTML = originalText;
    });
  });
</script>

</body>
</html>