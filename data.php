<?php
/**
 * data.php
 * Sumber data booking bersama.
 *
 * CATATAN: Ini masih simulasi. Status pembayaran "disimpan" pakai $_SESSION
 * supaya perubahan status (menunggu -> lunas) terasa nyata saat demo,
 * walau server di-refresh. Di project sungguhan, ganti bagian ini dengan
 * query ke database (MySQL/PostgreSQL) dan JANGAN pakai session untuk data booking.
 */

session_start();

function getAllBookings() {
    // Data dasar (anggap ini hasil SELECT dari tabel bookings)
    $bookings = [
        'BKG-0002' => [
            'id'            => 'BKG-0002',
            'status'        => 'lunas',
            'nama'          => 'rara',
            'wa'            => '0856745534',
            'tipe'          => 'Villa',
            'malam'         => 3,
            'checkin'       => '15 Jun 2026',
            'dipesan_pada'  => '14 Jun 2026, 19:22',
            'total_bayar'   => 2250000,
            'gambar'        => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?q=80&w=800&auto=format&fit=crop',
            'alamat'        => 'Jl. Kayu Aya No. 8, Seminyak, Bali',
            'metode_bayar'  => 'Transfer Bank BCA',
            'catatan'       => 'Late check-in sekitar pukul 21.00, mohon disiapkan welcome drink.',
        ],
        'BKG-0001' => [
            'id'            => 'BKG-0001',
            'status'        => 'menunggu',
            'nama'          => 'rara',
            'wa'            => '0856745534',
            'tipe'          => 'Villa',
            'malam'         => 1,
            'checkin'       => '10 Jun 2026',
            'dipesan_pada'  => '14 Jun 2026, 19:16',
            'total_bayar'   => 750000,
            'gambar'        => 'https://images.unsplash.com/photo-1602343168117-bb8ffe3e2e9f?q=80&w=800&auto=format&fit=crop',
            'alamat'        => 'Jl. Raya Ubud, Gianyar, Bali',
            'metode_bayar'  => 'Menunggu Pembayaran - Virtual Account',
            'catatan'       => '-',
        ],
    ];

    // Terapkan "override" status yang tersimpan di session (hasil simulasi pembayaran)
    if (!empty($_SESSION['booking_overrides'])) {
        foreach ($_SESSION['booking_overrides'] as $id => $override) {
            if (isset($bookings[$id])) {
                $bookings[$id] = array_merge($bookings[$id], $override);
            }
        }
    }

    return $bookings;
}

function getBooking($id) {
    $all = getAllBookings();
    return isset($all[$id]) ? $all[$id] : null;
}

function markAsPaid($id, $metode) {
    $_SESSION['booking_overrides'][$id] = [
        'status'       => 'lunas',
        'metode_bayar' => $metode,
        'catatan'      => 'Pembayaran berhasil (simulasi) via ' . $metode,
    ];
}

function rupiah($angka) {
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

function statusBadge($status) {
    switch ($status) {
        case 'lunas':
            return ['label' => 'LUNAS', 'bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'bar' => 'bg-emerald-500', 'chip' => 'bg-emerald-500'];
        case 'menunggu':
            return ['label' => 'MENUNGGU PEMBAYARAN', 'bg' => 'bg-rose-100', 'text' => 'text-rose-600', 'bar' => 'bg-rose-500', 'chip' => 'bg-rose-500'];
        case 'selesai':
            return ['label' => 'SELESAI', 'bg' => 'bg-sky-100', 'text' => 'text-sky-700', 'bar' => 'bg-sky-500', 'chip' => 'bg-sky-500'];
        default:
            return ['label' => strtoupper($status), 'bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'bar' => 'bg-slate-400', 'chip' => 'bg-slate-400'];
    }
}