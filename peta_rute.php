<?php
session_start();
require_once 'koneksi.php';
// Data Koordinat Destinasi di Madiun & Sekitarnya
$destinasi_madiun = [
    ["nama" => "Pahlawan Street Center (PSC)", "lat" => "-7.6273", "lon" => "111.5244"],
    ["nama" => "Taman Sumber Umis", "lat" => "-7.6268", "lon" => "111.5239"],
    ["nama" => "Alun-Alun Kota Madiun", "lat" => "-7.6293", "lon" => "111.5231"],
    ["nama" => "Taman Bantaran Kali Madiun", "lat" => "-7.6200", "lon" => "111.5180"],
    ["nama" => "Monumen Kresek", "lat" => "-7.6583", "lon" => "111.6038"],
    ["nama" => "Madiun Umbul Square", "lat" => "-7.7475", "lon" => "111.5306"],
    ["nama" => "Waduk Bening Widas", "lat" => "-7.5458", "lon" => "111.7833"],
    ["nama" => "Ngrowo Bening Edupark", "lat" => "-7.6433", "lon" => "111.5361"],
    ["nama" => "Hutan Pinus NONGKO IJO", "lat" => "-7.7289", "lon" => "111.6667"]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Rute - MadiunTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { brand: '#0e7490', brandDark: '#083344', accent: '#ea580c' }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Scrollbar styling untuk panel kiri */
        .custom-scroll::-webkit-scrollbar { width: 5px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 flex flex-col min-h-screen overflow-x-hidden">

    <nav class="bg-white border-b border-slate-200 h-16 flex-none shadow-sm z-50">
        <div class="w-full mx-auto px-4 lg:px-8 h-full flex items-center justify-between">
            <a href="landingpage.php" class="text-slate-500 font-bold flex items-center gap-2 hover:text-brand transition-colors text-sm">
                <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center"><i class="bi bi-arrow-left"></i></div>
                <span class="hidden md:inline">Kembali</span>
            </a>
            <span class="text-xl font-black tracking-tight text-brandDark">
                MADIUN<span class="text-accent">TRACK</span>
            </span>
            <div class="w-8"></div>
        </div>
    </nav>

    <main class="flex-grow flex flex-col lg:flex-row w-full lg:h-[calc(100vh-4rem)]">
        
        <div class="w-full lg:w-[400px] xl:w-[450px] bg-white flex-none border-r border-slate-200 z-10 shadow-xl overflow-y-auto custom-scroll p-6 lg:p-8">
            <div class="mb-8">
                <h2 class="text-3xl font-black text-brandDark mb-1">Navigasi Rute</h2>
                <p class="text-slate-500 text-sm">Cari jalur terbaik ke destinasi impianmu.</p>
            </div>

            <div class="space-y-6">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Lokasi Awal (Titik Jemput)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400"><i class="bi bi-geo-fill"></i></span>
                        <input type="text" id="input_asal" placeholder="Ketik Desa, Kecamatan, Kota..." 
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 pl-11 pr-4 text-sm font-semibold text-slate-700 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 transition-all">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Destinasi Wisata</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-accent"><i class="bi bi-geo-alt-fill"></i></span>
                        <select id="input_tujuan" class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 pl-11 pr-10 text-sm font-semibold text-slate-700 focus:outline-none focus:border-brand focus:ring-2 focus:ring-brand/20 transition-all appearance-none cursor-pointer">
                            <option value="" disabled selected>-- Pilih Lokasi Wisata --</option>
                            <?php foreach($destinasi_madiun as $dest): ?>
                                <option value="<?= $dest['lat'] ?>,<?= $dest['lon'] ?>"><?= $dest['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 pointer-events-none"><i class="bi bi-chevron-down"></i></span>
                    </div>
                </div>

                <button id="btn-cek" onclick="hitungRute()" class="w-full bg-brand hover:bg-brandDark text-white font-bold py-4 rounded-xl shadow-lg shadow-brand/20 transition-all active:scale-95 flex items-center justify-center gap-2">
                    Tampilkan Peta Rute <i class="bi bi-map-fill"></i>
                </button>
            </div>
            
            <div id="info_hasil" class="hidden mt-8 space-y-4 pt-8 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Info Tujuan</h3>
                
                <div class="bg-gradient-to-br from-orange-50 to-amber-50 p-5 rounded-2xl border border-orange-100 flex items-center gap-5 relative overflow-hidden">
                    <div class="w-14 h-14 rounded-full bg-white shadow-sm flex items-center justify-center shrink-0 z-10 relative">
                        <img id="icon_cuaca" src="" alt="cuaca" class="w-10 h-10">
                    </div>
                    <div class="z-10 relative">
                        <h4 class="text-2xl font-black text-brandDark leading-none" id="hasil_suhu">- °C</h4>
                        <p class="text-[11px] font-bold text-accent mt-1 uppercase tracking-wider" id="hasil_cuaca_desc">Menganalisis...</p>
                    </div>
                </div>

                <a id="btn-gmaps" href="#" target="_blank" class="w-full flex items-center justify-between bg-slate-900 hover:bg-slate-800 text-white font-bold py-4 px-6 rounded-xl transition-all shadow-xl shadow-slate-900/20 active:scale-95 group">
                    <span class="flex items-center gap-3">
                        <i class="bi bi-phone"></i> Navigasi via HP
                    </span>
                    <i class="bi bi-arrow-right group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>

        <div class="w-full h-[60vh] lg:h-full lg:flex-1 relative bg-slate-200 z-0">
            <div id="map" class="absolute inset-0 w-full h-full"></div>
            
            <div id="pesan_awal" class="absolute inset-0 flex flex-col items-center justify-center bg-slate-100/90 backdrop-blur-sm z-20 text-slate-500">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-md mb-4 animate-bounce">
                    <i class="bi bi-map text-4xl text-brand/50"></i>
                </div>
                <p class="font-black text-lg text-slate-700">Peta Belum Tersedia</p>
                <p class="text-sm mt-1">Masukkan lokasi awal untuk menampilkan rute.</p>
            </div>
        </div>

    </main>

    <script>
    async function hitungRute() {
        const asal = document.getElementById('input_asal').value.trim();
        const tujuanSelect = document.getElementById('input_tujuan');
        
        if (asal === "") { alert("Mohon ketik lokasi awal Anda!"); return; }
        if (tujuanSelect.value === "") { alert("Mohon pilih destinasi wisata!"); return; }

        const destNama = tujuanSelect.options[tujuanSelect.selectedIndex].text;
        const [destLat, destLon] = tujuanSelect.value.split(',');
        const btn = document.getElementById('btn-cek');
        const infoHasil = document.getElementById('info_hasil');
        
        btn.innerHTML = `<i class="bi bi-hourglass-split animate-spin"></i> Memuat Data...`;
        btn.disabled = true;

        try {
            // Sembunyikan pesan awal
            document.getElementById('pesan_awal').style.display = 'none';

            // 1. TAMPILKAN IFRAME GOOGLE MAPS
            const mapContainer = document.getElementById('map');
            const originQuery = encodeURIComponent(asal + ", Indonesia");
            // Syntax URL ini adalah trik untuk langsung menggambar rute biru di iframe embed maps
            const gmapsIframeUrl = `https://maps.google.com/maps?saddr=${originQuery}&daddr=${destLat},${destLon}&output=embed`;

            mapContainer.innerHTML = `<iframe width="100%" height="100%" frameborder="0" style="border:0;" src="${gmapsIframeUrl}" allowfullscreen></iframe>`;

            // 2. FETCH CUACA TUJUAN
            let suhu = "30"; 
            let cuacaDesc = "Cerah Berawan";
            let iconCuacaId = "02d"; 

            try {
                const API_KEY = "c4752a971021db39a254799794cedd5b";
                const weatherRes = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${destLat}&lon=${destLon}&appid=${API_KEY}&units=metric&lang=id`);
                
                if(weatherRes.ok) {
                    const weatherData = await weatherRes.json();
                    if(weatherData.main && weatherData.weather) {
                        suhu = Math.round(weatherData.main.temp);
                        cuacaDesc = weatherData.weather[0].description;
                        iconCuacaId = weatherData.weather[0].icon;
                    }
                }
            } catch (e) {
                console.warn("Gagal load API cuaca, menggunakan data default.");
            }

            // Update UI Cuaca
            document.getElementById('hasil_suhu').innerText = `${suhu} °C`;
            document.getElementById('hasil_cuaca_desc').innerText = cuacaDesc;
            document.getElementById('icon_cuaca').src = `https://openweathermap.org/img/wn/${iconCuacaId}.png`;
            
            // 3. UPDATE LINK TOMBOL HP
            const gmapsAppUrl = `https://www.google.com/maps/dir/?api=1&origin=${originQuery}&destination=${destLat},${destLon}&travelmode=driving`;
            document.getElementById('btn-gmaps').href = gmapsAppUrl;
            
            // Munculkan panel hasil
            infoHasil.classList.remove('hidden');

            // 4. EFEK SCROLL OTOMATIS (KHUSUS MOBILE)
            // Jika layar kecil (HP), otomatis scroll ke bawah menuju peta setelah loading selesai
            if(window.innerWidth < 1024) {
                setTimeout(() => { 
                    document.getElementById('map').scrollIntoView({ behavior: 'smooth' }); 
                }, 500);
            }

        } catch (error) {
            alert("Terjadi kesalahan, pastikan koneksi internet Anda stabil.");
        } finally {
            btn.innerHTML = `Tampilkan Peta Rute <i class="bi bi-map-fill"></i>`;
            btn.disabled = false;
        }
    }
    </script>
</body>
</html>