<?php 
require_once '../config/koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pusat Bantuan - Wisata Bromo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#0e5e6f 0.5px, transparent 0.5px), radial-gradient(#0e5e6f 0.5px, #f8fafc 0.5px);
            background-size: 20px 20px;
            background-position: 0 0, 10px 10px;
            opacity: 0.05;
            position: absolute;
            inset: 0;
            z-index: -1;
        }
    </style>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4 relative overflow-x-hidden">
    <div class="bg-pattern"></div>

    <div class="w-full max-w-xl">
        <a href="landingpage.php" class="inline-flex items-center gap-2 text-sky-600 font-bold mb-6 hover:gap-3 transition-all">
            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
        </a>

        
        <div class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-2xl shadow-sky-100 border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-sky-50 rounded-bl-full -mr-16 -mt-16 z-0"></div>

            <div class="relative z-10">
                <header class="mb-10 text-center md:text-left">
                    <p class="text-orange-400 font-extrabold uppercase tracking-[0.2em] text-xs mb-3">Customer Service</p>
                    <h1 class="text-4xl font-extrabold text-sky-950 leading-tight mb-4">
                        Ada Kendala <br><span class="text-sky-600">Saat Berwisata?</span>
                    </h1>
                    <p class="text-slate-500 font-medium leading-relaxed">
                        Laporan Anda sangat berharga bagi kami untuk menjaga kenyamanan seluruh pengunjung Gunung Bromo.
                    </p>
                </header>

                <form action="proses_keluhan.php" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-sky-900 mb-2 ml-1">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="bi bi-person"></i></span>
                            <input type="text" name="nama_pelapor" placeholder="Masukkan nama sesuai identitas" required
                                   class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-sky-500 focus:border-transparent outline-none transition-all placeholder:text-slate-300 text-slate-700 font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-sky-900 mb-2 ml-1">Email / WhatsApp</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="bi bi-chat-left-text"></i></span>
                            <input type="text" name="kontak_pelapor" placeholder="Untuk konfirmasi laporan" required
                                   class="w-full pl-11 pr-4 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-sky-500 outline-none transition-all placeholder:text-slate-300 text-slate-700 font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-sky-900 mb-2 ml-1">Kategori Masalah</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="bi bi-grid"></i></span>
                            <select name="kategori" required
                                    class="w-full pl-11 pr-10 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-sky-500 outline-none transition-all text-slate-700 font-medium appearance-none cursor-pointer">
                                <option value="">Pilih Jenis Keluhan</option>
                                <option value="Fasilitas">Fasilitas Umum</option>
                                <option value="Pelayanan">Layanan Petugas</option>
                                <option value="Keamanan">Keamanan & Parkir</option>
                                <option value="Kebersihan">Kebersihan Lingkungan</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none"><i class="bi bi-chevron-down text-xs"></i></span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-sky-900 mb-2 ml-1">Detail Masalah</label>
                        <textarea name="pesan_keluhan" placeholder="Ceritakan detail kronologi atau kendala..." required
                                  class="w-full p-5 bg-slate-50 border border-slate-200 rounded-2xl focus:ring-2 focus:ring-sky-500 outline-none transition-all placeholder:text-slate-300 text-slate-700 font-medium min-h-[150px] resize-none"></textarea>
                    </div>

                    <div class="pt-4">
                        <button type="submit" name="submit_keluhan" 
                                class="w-full bg-[#0e5e6f] hover:bg-sky-900 text-white font-black py-5 rounded-2xl shadow-xl shadow-sky-100 transition-all uppercase tracking-widest text-sm flex items-center justify-center gap-3 active:scale-95">
                            Kirim Laporan <i class="bi bi-send-fill text-xs"></i>
                        </button>
                    </div>
                </form>

                <footer class="mt-8 text-center">
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-tighter">
                        <i class="bi bi-shield-check text-sky-600 mr-1"></i> Data Anda akan kami lindungi secara privat
                    </p>
                </footer>
            </div>
        </div>
    </div>
</body>
</html>