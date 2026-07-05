<?php
session_start();
require_once __DIR__ . '../proses_register.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi - BromoTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        jakarta: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        primary: '#E8621A', // Oranye Bromo
                        primaryDark: '#c7531a',
                        brandBlue: '#0f172a', // Biru Gelap sesuai login
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">


    <div class="w-full max-w-[850px] bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200 overflow-hidden flex flex-col md:flex-row border border-slate-100">
        
        <div class="hidden md:flex w-[40%] bg-brandBlue relative flex-col justify-end p-8 overflow-hidden">
            <img src="https://i.pinimg.com/736x/d5/fa/66/d5fa660d2e02cb8b5f2c3e1489919426.jpg" 
                 class="absolute inset-0 w-full h-full object-cover opacity-20 grayscale" alt="Bromo">
            <div class="absolute inset-0 bg-gradient-to-t from-brandBlue via-brandBlue/40 to-transparent"></div>
            
            <div class="relative z-10">
                <h2 class="text-white text-xl font-extrabold italic leading-tight mb-2 uppercase tracking-tighter">
                    Bromo<span class="text-primary">Track</span>
                </h2>
                <p class="text-slate-400 text-[11px] leading-relaxed italic">
                    Bergabunglah untuk memulai petualangan dan mencatat jejak kunjungan Anda.
                </p>
            </div>
        </div>

        <div class="w-full md:w-[60%] p-8 sm:p-10 flex flex-col justify-center">
            
            <div class="mb-6">
                <h3 class="text-xl font-black text-brandBlue uppercase italic tracking-tighter">Sign Up</h3>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Create New Account</p>
            </div>

            <?php if (isset($error) && $error): ?>
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 rounded-lg flex items-center gap-3 animate-pulse">
                    <i class="bi bi-shield-exclamation text-red-500"></i>
                    <span class="text-red-700 text-[11px] font-bold italic"><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-3">
                <div class="space-y-1">
                    <label class="block text-brandBlue text-[9px] font-black uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-primary transition-colors italic">
                            <i class="bi bi-person-fill"></i>
                        </span>
                        <input type="text" name="nama" required placeholder="Nama Lengkap"
                            value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-xs font-semibold focus:outline-none focus:border-brandBlue focus:ring-4 focus:ring-slate-100 transition-all">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-brandBlue text-[9px] font-black uppercase tracking-widest ml-1">Email</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-primary transition-colors italic">
                            <i class="bi bi-envelope-fill"></i>
                        </span>
                        <input type="email" name="email" required placeholder="admin@bromotrack.com"
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-xs font-semibold focus:outline-none focus:border-brandBlue focus:ring-4 focus:ring-slate-100 transition-all">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="block text-brandBlue text-[9px] font-black uppercase tracking-widest ml-1">Password</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-primary transition-colors italic">
                                <i class="bi bi-key-fill"></i>
                            </span>
                            <input type="password" name="password" required placeholder="••••••"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-xs font-semibold focus:outline-none focus:border-brandBlue focus:ring-4 focus:ring-slate-100 transition-all">
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-brandBlue text-[9px] font-black uppercase tracking-widest ml-1">Konfirmasi</label>
                        <div class="relative group">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-primary transition-colors italic">
                                <i class="bi bi-shield-lock-fill"></i>
                            </span>
                            <input type="password" name="confirm_password" required placeholder="••••••"
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl py-2.5 pl-10 pr-4 text-xs font-semibold focus:outline-none focus:border-brandBlue focus:ring-4 focus:ring-slate-100 transition-all">
                        </div>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-brandBlue hover:bg-slate-800 text-white font-black py-3.5 rounded-xl text-[10px] tracking-[0.2em] uppercase italic transition-all flex items-center justify-center gap-2 shadow-lg shadow-slate-200">
                        Daftar Akun <i class="bi bi-arrow-right-short text-lg text-primary"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-50 text-center md:text-left">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest italic">
                    Sudah punya akun? <a href="login.php" class="text-primary hover:underline ml-1">Login Sekarang</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>