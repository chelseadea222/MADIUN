<?php
session_start();
// Hapus semua data session
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - BromoTrack</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        jakarta: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brandDark: '#0f172a',
                        brandAccent: '#E8621A',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Animasi kustom untuk spinner */
        .loader {
            border: 3px solid #f3f3f3;
            border-radius: 50%;
            border-top: 3px solid #E8621A;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body class="bg-[#f8fafc] h-full flex items-center justify-center p-6 text-brandDark">

    <div class="w-full max-w-[450px] bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200 border border-slate-100 p-10 md:p-14 text-center transform transition-all">
        
        <div class="mx-auto w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mb-6">
            <i class="bi bi-door-open-fill text-brandAccent text-4xl"></i>
        </div>

        <h2 class="text-2xl font-extrabold tracking-tight mb-2 uppercase italic">
            Berhasil <span class="text-brandAccent">Logout</span>
        </h2>
        <p class="text-slate-400 text-sm font-medium mb-8 leading-relaxed italic">
            Sesi Anda telah berakhir secara aman.<br>Menghubungkan kembali ke Portal Login...
        </p>

        <div class="flex justify-center items-center gap-3">
            <div class="loader"></div>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-50">
            <a href="login.php" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-300 hover:text-brandAccent transition-colors">
                Klik di sini jika tidak berpindah otomatis
            </a>
        </div>
    </div>

    <div class="fixed bottom-0 left-0 w-full h-1 bg-gradient-to-r from-brandDark via-brandAccent to-brandDark opacity-20"></div>

    <script>
        // Mengarahkan kembali ke login.php setelah 2.5 detik
        setTimeout(function() {
            window.location.href = 'login.php';
        }, 200);
    </script>

</body>
</html>