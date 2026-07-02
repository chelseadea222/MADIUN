<?php require_once '../config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservasi Penginapan - MadiunTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Style agar input/select terlihat sangat premium */
        .form-input { @apply w-full bg-slate-50 border border-slate-200 rounded-xl py-3.5 px-4 focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 outline-none transition duration-200; }
    </style>
</head>
<body class="bg-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-5xl rounded-[2.5rem] shadow-2xl flex flex-col lg:flex-row overflow-hidden border border-slate-200">
        
        <div class="bg-slate-900 lg:w-2/5 p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="relative z-10">
                <a href="landingpage.php" class="text-slate-400 hover:text-white mb-8 block transition text-sm">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
                <h2 class="text-4xl font-black mb-4">Mulai <br>Petualanganmu</h2>
                <p class="text-slate-400 text-sm leading-relaxed">Pilih villa atau area camp terbaik untuk kenyamanan liburan Anda di Madiun.</p>
            </div>
            
            <div class="relative z-10 space-y-4 mt-10">
                <div class="flex items-center gap-3"><i class="bi bi-shield-check text-amber-500"></i><span class="text-sm">Harga Terjamin</span></div>
                <div class="flex items-center gap-3"><i class="bi bi-headset text-amber-500"></i><span class="text-sm">Dukungan 24/7</span></div>
            </div>
        </div>

        <div class="flex-1 p-8 lg:p-12 overflow-y-auto">
            <h3 class="text-2xl font-bold text-slate-900 mb-8">Detail Reservasi</h3>

            <form action="proses_booking.php" method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-input" placeholder="Sesuai KTP" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Nomor WhatsApp</label>
                        <input type="text" name="no_hp" class="form-input" placeholder="08xxxxxxxxxx" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Check-in</label>
                        <input type="date" name="tgl_checkin" class="form-input" required>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Tipe Penginapan</label>
                        <select name="tipe_penginapan" id="tipe_penginapan" onchange="hitungTotal()" class="form-input" required>
                            <option value="">-- Pilih Tipe --</option>
                            <option value="Villa" data-harga="750000">Villa (Rp 750rb)</option>
                            <option value="Camp" data-harga="150000">Camp (Rp 150rb)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Durasi (Malam)</label>
                        <input type="number" name="durasi" id="durasi" min="1" value="1" oninput="hitungTotal()" class="form-input" required>
                    </div>
                </div>

                <div class="bg-slate-900 rounded-2xl p-6 text-center text-white mt-4">
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest">Total Bayar</p>
                    <strong id="display_total" class="text-3xl font-black text-amber-500 block">Rp 0</strong>
                    <input type="hidden" name="total_bayar" id="input_total_bayar">
                </div>

                <button type="submit" name="submit_booking" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-lg transition-all active:scale-95">
                    PESAN SEKARANG
                </button>
            </form>
        </div>
    </div>

    <script>
        function hitungTotal() {
            const tipe = document.getElementById('tipe_penginapan');
            const durasi = document.getElementById('durasi').value || 0;
            const harga = tipe.options[tipe.selectedIndex].getAttribute('data-harga') || 0;
            const total = harga * durasi;
            document.getElementById('display_total').innerText = "Rp " + total.toLocaleString('id-ID');
            document.getElementById('input_total_bayar').value = total;
        }
    </script>
</body>
</html>