<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Madiun Track - Dashboard Admin</title>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Plus Jakarta Sans', 'sans-serif'],
        },
        colors: {
          orange: { DEFAULT: '#f7941d', light: '#fff1e0' },
          bluec:  { DEFAULT: '#3b6fe0', light: '#e8f0fe' },
          purplec:{ DEFAULT: '#8b5cf6', light: '#f1eafe' },
          greenc: { DEFAULT: '#16a34a', light: '#e6f7ea' },
          ink:    '#1e2433',
          mutedc: '#8b93a7',
          bordc:  '#eaecf2',
          bgc:    '#f6f7fb',
        }
      }
    }
  }
</script>
<style>
  body{ font-family:'Plus Jakarta Sans', sans-serif; }
  ::-webkit-scrollbar{ width:8px; height:8px; }
  ::-webkit-scrollbar-thumb{ background:#dfe2ea; border-radius:8px; }
</style>
</head>
<body class="bg-bgc text-ink text-sm flex min-h-screen">

<!-- SIDEBAR -->
<aside class="w-[246px] bg-white border-r border-bordc p-4 pt-6 flex flex-col sticky top-0 h-screen shrink-0">
  <div class="flex items-center gap-2.5 px-2 pb-5">
    <div class="w-[34px] h-[34px] rounded-[9px] bg-orange flex items-center justify-center text-white shrink-0">
      <svg viewBox="0 0 24 24" fill="currentColor" class="w-[18px] h-[18px]"><path d="M12 2C7.6 2 4 5.6 4 10c0 5.4 7 11.5 7.3 11.8.2.1.4.2.7.2s.5-.1.7-.2C13 21.5 20 15.4 20 10c0-4.4-3.6-8-8-8zm0 11c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z"/></svg>
    </div>
    <div class="font-extrabold text-base tracking-tight">Madiun <span class="text-orange">Track</span></div>
  </div>

  <div class="text-[11px] font-bold text-[#b3b9c8] tracking-wider mx-2 mt-2 mb-2">MANAJEMEN</div>

  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 bg-orange-light text-orange">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><path d="M3 10.5L12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg>
    Dashboard
  </a>
  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 text-[#5b6274] hover:bg-[#f5f6fa]">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18M8 14h.01M12 14h4"/></svg>
    Tiket Wisata
  </a>
  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 text-[#5b6274] hover:bg-[#f5f6fa]">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><path d="M3 10.5L12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9 21v-6h6v6"/></svg>
    Reservasi Penginapan
  </a>
  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 text-[#5b6274] hover:bg-[#f5f6fa]">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><circle cx="12" cy="10" r="3"/><path d="M12 21s7-6.5 7-11a7 7 0 10-14 0c0 4.5 7 11 7 11z"/></svg>
    Destinasi Wisata
  </a>
  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 text-[#5b6274] hover:bg-[#f5f6fa]">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><path d="M3 12l9-9 9 9"/><path d="M5 10v10h5v-6h4v6h5V10"/></svg>
    Homestay
  </a>
  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 text-[#5b6274] hover:bg-[#f5f6fa]">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6.5 6.5-6.5s6.5 2.9 6.5 6.5"/><circle cx="17.5" cy="8.5" r="2.7"/><path d="M15.5 13.6c2.9.4 5 2.9 5 6.4"/></svg>
    Pengguna
  </a>
  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 text-[#5b6274] hover:bg-[#f5f6fa]">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><path d="M12 17.3l-6.2 3.3 1.2-6.9L2 8.9l6.9-1L12 1.7l3.1 6.2 6.9 1-5 4.8 1.2 6.9z"/></svg>
    Ulasan
  </a>
  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 text-[#5b6274] hover:bg-[#f5f6fa]">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><path d="M6 2h9l5 5v15H6z"/><path d="M15 2v5h5"/><path d="M9 13h6M9 17h6"/></svg>
    Laporan
  </a>

  <div class="text-[11px] font-bold text-[#b3b9c8] tracking-wider mx-2 mt-4 mb-2">PENGATURAN</div>

  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 text-[#5b6274] hover:bg-[#f5f6fa]">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 00.3 1.9l.1.1a2 2 0 11-2.8 2.8l-.1-.1a1.7 1.7 0 00-1.9-.3 1.7 1.7 0 00-1 1.6V21a2 2 0 11-4 0v-.2a1.7 1.7 0 00-1-1.6 1.7 1.7 0 00-1.9.3l-.1.1a2 2 0 11-2.8-2.8l.1-.1a1.7 1.7 0 00.3-1.9 1.7 1.7 0 00-1.6-1H3a2 2 0 110-4h.2a1.7 1.7 0 001.6-1 1.7 1.7 0 00-.3-1.9l-.1-.1a2 2 0 112.8-2.8l.1.1a1.7 1.7 0 001.9.3H9a1.7 1.7 0 001-1.6V3a2 2 0 114 0v.2a1.7 1.7 0 001 1.6 1.7 1.7 0 001.9-.3l.1-.1a2 2 0 112.8 2.8l-.1.1a1.7 1.7 0 00-.3 1.9V9a1.7 1.7 0 001.6 1H21a2 2 0 110 4h-.2a1.7 1.7 0 00-1.6 1z"/></svg>
    Pengaturan
  </a>
  <a class="flex items-center gap-2.5 px-3 py-2.5 rounded-[10px] font-semibold text-[13.5px] mb-0.5 text-[#5b6274] hover:bg-[#f5f6fa]">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px] shrink-0"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
    Akun Admin
  </a>

  <div class="mt-auto bg-gradient-to-b from-[#eef1fb] to-[#e7ecfb] rounded-2xl p-4 relative overflow-hidden">
    <div class="flex gap-2 mb-3.5">
      <div class="w-11 h-11 rounded-[10px] bg-white flex items-center justify-center shadow-[0_4px_10px_rgba(60,70,120,.08)]">
        <svg viewBox="0 0 24 24" fill="none" stroke="#3b6fe0" stroke-width="2" class="w-[22px] h-[22px]"><circle cx="12" cy="12" r="9"/><path d="M12 3v9l6 3"/></svg>
      </div>
      <div class="w-11 h-11 rounded-[10px] bg-white flex items-center justify-center shadow-[0_4px_10px_rgba(60,70,120,.08)]">
        <svg viewBox="0 0 24 24" fill="none" stroke="#f7941d" stroke-width="2" class="w-[22px] h-[22px]"><rect x="4" y="10" width="4" height="10"/><rect x="10" y="6" width="4" height="14"/><rect x="16" y="13" width="4" height="7"/></svg>
      </div>
    </div>
    <h4 class="text-sm font-extrabold mb-1.5">Kelola Wisata Madiun</h4>
    <p class="text-xs text-[#6b7180] leading-relaxed">Pantau data, kelola layanan, dan tingkatkan pengalaman wisatawan.</p>
  </div>
</aside>

<!-- MAIN -->
<div class="flex-1 min-w-0">
  <!-- TOPBAR -->
  <div class="flex items-center justify-end gap-4 px-8 py-4 border-b border-bordc bg-white">
    <div class="w-[38px] h-[38px] rounded-[10px] flex items-center justify-center bg-[#f6f7fb] text-[#5b6274] cursor-pointer">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px]"><circle cx="12" cy="12" r="4"/><path d="M12 2v2M12 20v2M4.9 4.9l1.4 1.4M17.7 17.7l1.4 1.4M2 12h2M20 12h2M4.9 19.1l1.4-1.4M17.7 6.3l1.4-1.4"/></svg>
    </div>
    <div class="bg-bluec-light text-bluec font-bold text-xs px-3.5 py-2 rounded-full">MODE ADMIN</div>
    <div class="relative w-[38px] h-[38px] rounded-[10px] flex items-center justify-center bg-[#f6f7fb] text-[#5b6274] cursor-pointer">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[18px] h-[18px]"><path d="M18 8a6 6 0 10-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 01-3.4 0"/></svg>
      <div class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-4 h-4 rounded-full flex items-center justify-center border-2 border-white">3</div>
    </div>
    <div class="flex items-center gap-2.5 pl-3 border-l border-bordc cursor-pointer">
      <div class="w-9 h-9 rounded-full bg-gradient-to-br from-[#5b6ee1] to-[#8b5cf6] flex items-center justify-center text-white font-bold text-[13px]">A</div>
      <div>
        <div class="font-bold text-[13px] leading-tight">Admin</div>
        <div class="text-[11px] text-mutedc">Super Admin</div>
      </div>
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#8b93a7" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
    </div>
  </div>

  <div class="p-8 pt-7">
    <h1 class="text-[26px] font-extrabold tracking-tight mb-1">Dashboard Admin</h1>
    <p class="text-mutedc text-[13.5px] mb-6">Pantau data operasional, perbarui status, dan ekspor data pengunjung.</p>

    <!-- STAT CARDS -->
    <div class="grid grid-cols-4 max-[1200px]:grid-cols-2 gap-4.5 mb-5">
      <div class="bg-white border border-bordc rounded-2xl p-5 flex gap-3.5 items-start">
        <div class="w-[46px] h-[46px] rounded-xl flex items-center justify-center shrink-0 bg-orange-light text-orange">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[22px] h-[22px]"><path d="M3 8a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 000 4v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2a2 2 0 000-4z"/><path d="M12 6v12" stroke-dasharray="2 2"/></svg>
        </div>
        <div>
          <div class="text-[11px] font-bold text-mutedc tracking-wide mb-1.5">TIKET WISATA TERJUAL</div>
          <div class="flex items-baseline gap-2 flex-wrap">
            <div class="text-[22px] font-extrabold tracking-tight">128</div>
            <div class="text-xs font-bold text-greenc flex items-center gap-0.5">↗ 24.5%</div>
          </div>
          <div class="text-[11.5px] text-mutedc mt-1">+25 dari bulan lalu</div>
        </div>
      </div>

      <div class="bg-white border border-bordc rounded-2xl p-5 flex gap-3.5 items-start">
        <div class="w-[46px] h-[46px] rounded-xl flex items-center justify-center shrink-0 bg-bluec-light text-bluec">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[22px] h-[22px]"><path d="M3 10.5L12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/><path d="M9 21v-6h6v6"/></svg>
        </div>
        <div>
          <div class="text-[11px] font-bold text-mutedc tracking-wide mb-1.5">RESERVASI PENGINAPAN</div>
          <div class="flex items-baseline gap-2 flex-wrap">
            <div class="text-[22px] font-extrabold tracking-tight">42</div>
            <div class="text-xs font-bold text-greenc flex items-center gap-0.5">↗ 18.7%</div>
          </div>
          <div class="text-[11.5px] text-mutedc mt-1">+9 dari bulan lalu</div>
        </div>
      </div>

      <div class="bg-white border border-bordc rounded-2xl p-5 flex gap-3.5 items-start">
        <div class="w-[46px] h-[46px] rounded-xl flex items-center justify-center shrink-0 bg-purplec-light text-purplec">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[22px] h-[22px]"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6.5 6.5-6.5s6.5 2.9 6.5 6.5"/><circle cx="17.5" cy="8.5" r="2.7"/><path d="M15.5 13.6c2.9.4 5 2.9 5 6.4"/></svg>
        </div>
        <div>
          <div class="text-[11px] font-bold text-mutedc tracking-wide mb-1.5">TOTAL PENGUNJUNG</div>
          <div class="flex items-baseline gap-2 flex-wrap">
            <div class="text-[22px] font-extrabold tracking-tight">1.256</div>
            <div class="text-xs font-bold text-greenc flex items-center gap-0.5">↗ 31.2%</div>
          </div>
          <div class="text-[11.5px] text-mutedc mt-1">+298 dari bulan lalu</div>
        </div>
      </div>

      <div class="bg-white border border-bordc rounded-2xl p-5 flex gap-3.5 items-start">
        <div class="w-[46px] h-[46px] rounded-xl flex items-center justify-center shrink-0 bg-greenc-light text-greenc">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[22px] h-[22px]"><path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/></svg>
        </div>
        <div>
          <div class="text-[11px] font-bold text-mutedc tracking-wide mb-1.5">PENDAPATAN TOTAL</div>
          <div class="flex items-baseline gap-2 flex-wrap">
            <div class="text-[22px] font-extrabold tracking-tight">Rp12.450.000</div>
            <div class="text-xs font-bold text-greenc flex items-center gap-0.5">↗ 22.1%</div>
          </div>
          <div class="text-[11.5px] text-mutedc mt-1">+Rp2.250.000 dari bulan lalu</div>
        </div>
      </div>
    </div>

    <!-- CHARTS -->
    <div class="grid grid-cols-[1.35fr_1fr] max-[1200px]:grid-cols-1 gap-4.5 mb-5">
      <div class="bg-white border border-bordc rounded-2xl p-5 px-5.5">
        <div class="flex items-center justify-between mb-3.5">
          <h3 class="text-[15px] font-extrabold">Tren Transaksi Bulanan</h3>
          <div class="text-xs font-semibold text-[#5b6274] bg-[#f6f7fb] border border-bordc px-3 py-1.5 rounded-[9px] flex items-center gap-2 cursor-pointer">
            6 Bulan Terakhir
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
          </div>
        </div>
        <div class="h-[230px] relative"><canvas id="lineChart"></canvas></div>
      </div>

      <div class="bg-white border border-bordc rounded-2xl p-5 px-5.5">
        <div class="flex items-center justify-between mb-3.5">
          <h3 class="text-[15px] font-extrabold">Data Pengunjung Berdasarkan Bulan</h3>
          <div class="text-xs font-semibold text-[#5b6274] bg-[#f6f7fb] border border-bordc px-3 py-1.5 rounded-[9px] flex items-center gap-2 cursor-pointer">
            6 Bulan Terakhir
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M6 9l6 6 6-6"/></svg>
          </div>
        </div>
        <div class="h-[230px] relative"><canvas id="barChart"></canvas></div>
      </div>
    </div>

    <!-- BOTTOM -->
    <div class="grid grid-cols-[1.75fr_1fr] max-[1200px]:grid-cols-1 gap-4.5">
      <div class="bg-white border border-bordc rounded-2xl p-5 px-5.5">
        <div class="flex items-center justify-between mb-4">
          <div class="flex items-center gap-2.5 font-extrabold text-[15px]">
            <div class="w-[34px] h-[34px] rounded-[9px] bg-orange-light text-orange flex items-center justify-center">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M3 10h18"/></svg>
            </div>
            10 Tiket Wisata Terbaru
          </div>
          <div class="text-[12.5px] font-bold text-bluec bg-bluec-light px-3.5 py-2 rounded-[9px] flex items-center gap-1.5 cursor-pointer">
            Lihat Semua
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 6l6 6-6 6"/></svg>
          </div>
        </div>
        <table class="w-full border-collapse text-[13px]">
          <thead>
            <tr class="text-left">
              <th class="text-[11px] font-bold text-mutedc tracking-wide px-2.5 pb-3 border-b border-bordc">Nama Pembeli</th>
              <th class="text-[11px] font-bold text-mutedc tracking-wide px-2.5 pb-3 border-b border-bordc">Destinasi</th>
              <th class="text-[11px] font-bold text-mutedc tracking-wide px-2.5 pb-3 border-b border-bordc">Tanggal</th>
              <th class="text-[11px] font-bold text-mutedc tracking-wide px-2.5 pb-3 border-b border-bordc">Jumlah Tiket</th>
              <th class="text-[11px] font-bold text-mutedc tracking-wide px-2.5 pb-3 border-b border-bordc">Total</th>
              <th class="text-[11px] font-bold text-mutedc tracking-wide px-2.5 pb-3 border-b border-bordc">Status</th>
              <th class="text-[11px] font-bold text-mutedc tracking-wide px-2.5 pb-3 border-b border-bordc">Aksi</th>
            </tr>
          </thead>
          <tbody id="ticketTable"></tbody>
        </table>
      </div>

      <div class="flex flex-col gap-4.5">
        <div class="bg-white border border-bordc rounded-2xl p-5 px-5.5">
          <div class="flex items-center gap-2.5 mb-4">
            <div class="w-[34px] h-[34px] rounded-[9px] bg-bluec-light text-bluec flex items-center justify-center">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M3 9h18M8 2v4M16 2v4"/></svg>
            </div>
            <div>
              <div class="font-extrabold text-[14.5px]">Ringkasan Hari Ini</div>
              <div class="text-[11.5px] text-mutedc">26 Mei 2026</div>
            </div>
          </div>

          <div class="flex items-center gap-3 py-3 border-b border-[#f2f3f7]">
            <div class="w-[34px] h-[34px] rounded-[9px] flex items-center justify-center shrink-0 bg-orange-light text-orange">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><rect x="3" y="6" width="18" height="12" rx="2"/></svg>
            </div>
            <div class="flex-1 font-semibold text-[13px] text-[#3a4152]">Tiket Terjual</div>
            <div class="font-extrabold text-[15px]">18</div>
          </div>

          <div class="flex items-center gap-3 py-3 border-b border-[#f2f3f7]">
            <div class="w-[34px] h-[34px] rounded-[9px] flex items-center justify-center shrink-0 bg-bluec-light text-bluec">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path d="M3 10.5L12 3l9 7.5"/><path d="M5 9.5V21h14V9.5"/></svg>
            </div>
            <div class="flex-1 font-semibold text-[13px] text-[#3a4152]">Reservasi Penginapan</div>
            <div class="font-extrabold text-[15px]">6</div>
          </div>

          <div class="flex items-center gap-3 pt-3">
            <div class="w-[34px] h-[34px] rounded-[9px] flex items-center justify-center shrink-0 bg-purplec-light text-purplec">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.6 2.9-6.5 6.5-6.5s6.5 2.9 6.5 6.5"/></svg>
            </div>
            <div class="flex-1 font-semibold text-[13px] text-[#3a4152]">Pengunjung Baru</div>
            <div class="font-extrabold text-[15px]">52</div>
          </div>
        </div>

        <div class="bg-white border border-bordc rounded-2xl p-5 px-5.5">
          <div class="flex gap-3 mb-4">
            <div class="w-[34px] h-[34px] rounded-[9px] bg-bluec-light text-bluec flex items-center justify-center shrink-0">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4"><path d="M12 3v12M7 10l5 5 5-5"/><path d="M5 21h14"/></svg>
            </div>
            <div>
              <div class="font-extrabold text-[14.5px] mb-0.5">Ekspor Data</div>
              <div class="text-xs text-mutedc leading-snug">Unduh laporan data dalam format yang tersedia.</div>
            </div>
          </div>
          <div class="flex gap-2.5 mt-4">
            <button class="flex-1 flex items-center justify-center gap-2 py-2.5 px-2.5 rounded-[10px] font-bold text-[12.5px] text-white bg-[#1a9c56] cursor-pointer">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[15px] h-[15px]"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M8 8l8 8M16 8l-8 8"/></svg>
              Export Excel
            </button>
            <button class="flex-1 flex items-center justify-center gap-2 py-2.5 px-2.5 rounded-[10px] font-bold text-[12.5px] text-white bg-[#181c27] cursor-pointer">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[15px] h-[15px]"><path d="M6 2h9l5 5v15H6z"/><path d="M15 2v5h5"/></svg>
              Export PDF
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const tickets = [
    {nama:"Rara", dest:"Pahlawan Street Center (PSC)", tgl:"26 Mei 2026", jml:2, total:"Rp40.000", status:"DIPROSES"},
    {nama:"Budi Santoso", dest:"Taman Bantaran Kali Madiun", tgl:"25 Mei 2026", jml:4, total:"Rp80.000", status:"SELESAI"},
    {nama:"Siti Aisyah", dest:"Taman Sumber Umis", tgl:"25 Mei 2026", jml:2, total:"Rp40.000", status:"DIPROSES"},
    {nama:"Dewi Lestari", dest:"Alun-Alun Kota Madiun", tgl:"24 Mei 2026", jml:3, total:"Rp60.000", status:"SELESAI"},
    {nama:"Andi Pratama", dest:"Pahlawan Street Center (PSC)", tgl:"24 Mei 2026", jml:2, total:"Rp40.000", status:"DIPROSES"},
  ];

  const tbody = document.getElementById('ticketTable');
  tickets.forEach(t=>{
    const pillClass = t.status === "SELESAI"
      ? "bg-greenc-light text-greenc"
      : "bg-[#fff4de] text-[#c8860a]";
    tbody.innerHTML += `
      <tr>
        <td class="py-3.5 px-2.5 border-b border-[#f2f3f7] font-semibold text-[#3a4152]">${t.nama}</td>
        <td class="py-3.5 px-2.5 border-b border-[#f2f3f7] font-semibold text-[#3a4152]">${t.dest}</td>
        <td class="py-3.5 px-2.5 border-b border-[#f2f3f7] font-semibold text-[#3a4152]">${t.tgl}</td>
        <td class="py-3.5 px-2.5 border-b border-[#f2f3f7] font-semibold text-[#3a4152]">${t.jml}</td>
        <td class="py-3.5 px-2.5 border-b border-[#f2f3f7] font-semibold text-[#3a4152]">${t.total}</td>
        <td class="py-3.5 px-2.5 border-b border-[#f2f3f7]">
          <span class="text-[11px] font-bold px-3 py-1.5 rounded-full inline-block ${pillClass}">${t.status}</span>
        </td>
        <td class="py-3.5 px-2.5 border-b border-[#f2f3f7]">
          <div class="w-[30px] h-[30px] rounded-lg bg-bluec-light text-bluec flex items-center justify-center cursor-pointer">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-[15px] h-[15px]"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
          </div>
        </td>
      </tr>`;
  });

  // Line chart
  new Chart(document.getElementById('lineChart'), {
    type:'line',
    data:{
      labels:['Jan','Feb','Mar','Apr','Mei','Jun'],
      datasets:[{
        data:[14,17,20,17,19,15],
        borderColor:'#f7941d',
        backgroundColor:(ctx)=>{
          const g = ctx.chart.ctx.createLinearGradient(0,0,0,220);
          g.addColorStop(0,'rgba(247,148,29,0.35)');
          g.addColorStop(1,'rgba(247,148,29,0)');
          return g;
        },
        fill:true,
        tension:0.4,
        pointRadius:4,
        pointBackgroundColor:'#fff',
        pointBorderColor:'#f7941d',
        pointBorderWidth:2,
        borderWidth:2.5,
      }]
    },
    options:{
      responsive:true,
      maintainAspectRatio:false,
      plugins:{legend:{display:false}},
      scales:{
        y:{min:10,max:24,ticks:{stepSize:2,color:'#8b93a7',font:{size:11}},grid:{color:'#f0f1f5'}},
        x:{ticks:{color:'#8b93a7',font:{size:11}},grid:{display:false}}
      }
    }
  });

  // Bar chart
  new Chart(document.getElementById('barChart'), {
    type:'bar',
    data:{
      labels:['Jan','Feb','Mar','Apr','Mei','Jun'],
      datasets:[{
        data:[0,42,63,49,36,84],
        backgroundColor:'#3b6fe0',
        borderRadius:6,
        maxBarThickness:34,
      }]
    },
    options:{
      responsive:true,
      maintainAspectRatio:false,
      plugins:{legend:{display:false}},
      scales:{
        y:{min:0,max:90,ticks:{stepSize:15,color:'#8b93a7',font:{size:11}},grid:{color:'#f0f1f5'}},
        x:{ticks:{color:'#8b93a7',font:{size:11}},grid:{display:false}}
      }
    }
  });
</script>

</body>
</html>