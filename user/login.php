<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) { session_start(); }

// Memanggil logika pemeriksaan database
require_once __DIR__ . '/../proses/proses_login.php';

// Jika sudah login, arahkan ke halaman yang sesuai
if (isset($_SESSION['role'])) {
    if (strtolower($_SESSION['role']) === 'admin') {
        header('Location: dashboard_admin.php'); exit;
    } else {
        header('Location: dashboard_user.php'); exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BromoTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { jakarta: ['Plus Jakarta Sans', 'sans-serif'] },
                    colors: {
                        brandDark: '#0f172a',    /* Biru Navy */
                        brandAccent: '#E8621A',  /* Oranye Bromo */
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f8fafc; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-[850px] flex flex-col md:flex-row shadow-2xl rounded-[2rem] overflow-hidden bg-white border border-slate-100">
        
        <div class="hidden md:flex w-[40%] bg-brandDark relative flex-col justify-end p-8 overflow-hidden">
            <img src="https://i.pinimg.com/736x/d5/fa/66/d5fa660d2e02cb8b5f2c3e1489919426.jpg" 
                 class="absolute inset-0 w-full h-full object-cover opacity-20 grayscale" alt="Bromo">
            <div class="absolute inset-0 bg-gradient-to-t from-brandDark via-brandDark/40 to-transparent"></div>
            
            <div class="relative z-10">
                <h2 class="text-white text-xl font-extrabold italic leading-tight mb-2 uppercase tracking-tighter">
                    Bromo<span class="text-brandAccent">Track</span>
                </h2>
                <p class="text-slate-400 text-[11px] leading-relaxed italic">
                    Sistem Tracking Wisata Terpadu.
                </p>
            </div>
        </div>

        <div class="w-full md:w-[60%] p-8 sm:p-12 flex flex-col justify-center">
            
            <div class="mb-8 text-center md:text-left">
                <h3 class="text-xl font-black text-brandDark uppercase italic tracking-tighter">Sign In</h3>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.2em] mt-1">Access Control System</p>
            </div>

            <?php if (isset($error) && $error): ?>
                <div class="mb-6 p-3 bg-red-50 border-l-4 border-red-500 rounded-lg flex items-center gap-3 animate-pulse">
                    <i class="bi bi-shield-lock-fill text-red-500"></i>
                    <span class="text-red-700 text-[11px] font-bold italic"><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <form method="POST" action="" class="space-y-4">
                <div class="space-y-1.5">
                    <label class="block text-brandDark text-[9px] font-black uppercase tracking-widest ml-1">Email</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-brandAccent transition-colors italic">
                            <i class="bi bi-envelope-fill"></i>
                        </span>
                        <input type="email" name="email" required autocomplete="off" placeholder="admin@bromotrack.com"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-10 pr-4 text-xs font-semibold focus:outline-none focus:border-brandDark focus:ring-4 focus:ring-slate-100 transition-all">
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-brandDark text-[9px] font-black uppercase tracking-widest ml-1">Password</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-300 group-focus-within:text-brandAccent transition-colors italic">
                            <i class="bi bi-key-fill"></i>
                        </span>
                        <input type="password" name="password" required autocomplete="new-password" placeholder="••••••••"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl py-3 pl-10 pr-4 text-xs font-semibold focus:outline-none focus:border-brandDark focus:ring-4 focus:ring-slate-100 transition-all">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-brandDark hover:bg-slate-800 text-white font-black py-3.5 rounded-xl text-[10px] tracking-[0.2em] uppercase italic transition-all flex items-center justify-center gap-2 shadow-lg shadow-slate-200">
                        Login Dashboard <i class="bi bi-arrow-right-short text-lg text-brandAccent"></i>
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-50 text-center md:text-left">
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest italic">
                    Belum punya akun? <a href="register.php" class="text-brandAccent hover:underline ml-1">Daftar</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>