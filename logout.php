<?php
/**
 * MadiunTrack - Logout
 * Menghancurkan session user dan mengarahkan kembali ke halaman login.
 */

// Cegah halaman ini di-cache browser (supaya tombol back tidak bisa balik ke halaman dashboard)
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

session_start();

// Hapus semua variabel session
$_SESSION = [];

// Hapus cookie session di browser (kalau ada)
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params['path'],
        $params['domain'],
        $params['secure'],
        $params['httponly']
    );
}

// Hancurkan session di server
session_destroy();

// Arahkan ke halaman login
header('Location: login.php');
exit;