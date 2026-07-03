<?php
/**
 * functions.php
 * Kumpulan fungsi & konfigurasi bersama yang dipakai di semua halaman admin.
 */

// ----------------------------------------------------------------------
// Proteksi akses: hanya role admin yang boleh membuka halaman ini.
// Panggil requireAdmin() di baris paling atas tiap halaman (setelah session_start()).
// ----------------------------------------------------------------------
function requireAdmin()
{
    if (empty($_SESSION['user_id']) || empty($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../user/login.php'); // sesuaikan path login sesuai struktur project Anda
        exit;
    }
}

// ----------------------------------------------------------------------
// Data menu navbar (dipakai bersama oleh includes/layout_head.php)
// ----------------------------------------------------------------------
function getMenuUtama()
{
    return [
        ['icon' => 'home',      'label' => 'Dashboard',           'link' => 'dashboard_admin.php'],
        ['icon' => 'ticket',    'label' => 'Tiket Wisata',         'link' => 'tiket_wisata.php'],
        ['icon' => 'building',  'label' => 'Reservasi Penginapan', 'link' => 'reservasi_penginapan.php'],
        ['icon' => 'map-pin',   'label' => 'Destinasi Wisata',     'link' => 'destinasi_wisata.php'],
        ['icon' => 'home',      'label' => 'Homestay',             'link' => 'homestay.php'],
        ['icon' => 'user',      'label' => 'Pengguna',             'link' => 'pengguna.php'],
        ['icon' => 'star',      'label' => 'Ulasan',               'link' => 'ulasan.php'],
        ['icon' => 'book-open', 'label' => 'Laporan',              'link' => 'laporan.php'],
    ];
}

function getMenuBawah()
{
    return [
        ['icon' => 'settings', 'label' => 'Pengaturan', 'link' => 'pengaturan.php'],
        ['icon' => 'user',     'label' => 'Akun Admin', 'link' => 'akun_admin.php'],
    ];
}

// ----------------------------------------------------------------------
// Helper format
// ----------------------------------------------------------------------
function rupiah($angka)
{
    return 'Rp' . number_format((float)$angka, 0, ',', '.');
}

function tanggalIndo($tanggal)
{
    if (!$tanggal) return '-';
    $bulan = ['', 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
    $ts = strtotime($tanggal);
    return date('d', $ts) . ' ' . $bulan[(int)date('n', $ts)] . ' ' . date('Y', $ts);
}

function pillStatus($status)
{
    $map = [
        'Selesai'        => 'bg-green-100 text-green-700',
        'aktif'          => 'bg-green-100 text-green-700',
        'tampil'         => 'bg-green-100 text-green-700',
        'Diproses'       => 'bg-amber-100 text-amber-700',
        'Dibatalkan'     => 'bg-red-100 text-red-700',
        'nonaktif'       => 'bg-slate-100 text-slate-500',
        'disembunyikan'  => 'bg-slate-100 text-slate-500',
    ];
    $cls = $map[$status] ?? 'bg-slate-100 text-slate-500';
    return "<span class=\"text-[11px] font-semibold px-3 py-1.5 rounded-full inline-block {$cls}\">" . strtoupper($status) . "</span>";
}

// ----------------------------------------------------------------------
// Ikon SVG (sama seperti pada dashboard_admin.php)
// ----------------------------------------------------------------------
function icon($name, $size = 20, $color = 'currentColor')
{
    $icons = [
        'home'          => '<path d="M3 9.5 12 3l9 6.5V20a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1Z"/>',
        'map-pin'       => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'ticket'        => '<path d="M3 9a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v1.5a1.5 1.5 0 0 0 0 3V15a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-1.5a1.5 1.5 0 0 0 0-3V9Z"/><path d="M9 7v10" stroke-dasharray="3 3"/>',
        'building'      => '<rect x="4" y="3" width="16" height="18" rx="1"/><path d="M9 8h.01M15 8h.01M9 12h.01M15 12h.01M9 16h.01M15 16h.01"/>',
        'user'          => '<circle cx="12" cy="8" r="4"/><path d="M4 21c1-4 4.5-6 8-6s7 2 8 6"/>',
        'settings'      => '<circle cx="12" cy="12" r="3"/><path d="M19.4 13a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.9 2.9l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.6V19a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.9-2.9l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.6-1H4a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.9 2.9l.1.1a1.7 1.7 0 0 0 1.9.3H10a1.7 1.7 0 0 0 1-1.6V4a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.6 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.9 2.9l-.1.1a1.7 1.7 0 0 0-.3 1.9V10a1.7 1.7 0 0 0 1.6 1H20a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.6 1Z"/>',
        'logout'        => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
        'bell'          => '<path d="M6 8a6 6 0 0 1 12 0c0 5 2 6 2 6H4s2-1 2-6"/><path d="M10 21a2 2 0 0 0 4 0"/>',
        'star'          => '<path d="m12 2 2.9 6.4 7 .7-5.3 4.7 1.6 6.9L12 17.3 5.8 20.7l1.6-6.9L2.1 9.1l7-.7Z"/>',
        'book-open'     => '<path d="M12 7c-2-2-5-2-9-1v13c4-1 7-1 9 1 2-2 5-2 9-1V6c-4-1-7-1-9 1Z"/><path d="M12 7v13"/>',
        'chevron-down'  => '<path d="m6 9 6 6 6-6"/>',
        'chevron-right' => '<path d="m9 18 6-6-6-6"/>',
        'arrow-right'   => '<path d="M5 12h14"/><path d="m13 6 6 6-6 6"/>',
        'eye'           => '<path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7Z"/><circle cx="12" cy="12" r="3"/>',
        'chart'         => '<path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/>',
        'download'      => '<path d="M12 3v12M7 10l5 5 5-5"/><path d="M5 21h14"/>',
        'file-text'     => '<path d="M6 2h9l5 5v15H6z"/><path d="M15 2v5h5"/><path d="M9 13h6M9 17h6"/>',
        'clock'         => '<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>',
        'plus'          => '<path d="M12 5v14M5 12h14"/>',
        'edit'          => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>',
        'trash'         => '<path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/>',
        'x'             => '<path d="M18 6 6 18"/><path d="M6 6l12 12"/>',
        'search'        => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
        'lock'          => '<rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/>',
        'mail'          => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/>',
        'phone'         => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3 19.5 19.5 0 0 1-6-6 19.8 19.8 0 0 1-3-8.7A2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1.9.3 1.8.6 2.7a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.4-1.4a2 2 0 0 1 2.1-.4c.9.3 1.8.5 2.7.6a2 2 0 0 1 1.8 2Z"/>',
    ];
    $path = $icons[$name] ?? '';
    return "<svg width=\"{$size}\" height=\"{$size}\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"{$color}\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\">{$path}</svg>";
}