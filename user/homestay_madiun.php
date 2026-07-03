<?php
// data_homestay.php
// Sumber data tunggal daftar homestay. Di-include oleh homestay_madiun.php
// (halaman daftar) dan booking_homestay.php (halaman booking) supaya datanya
// selalu sinkron di kedua halaman.
//
// CATATAN: 'harga' di sini dibuat integer (bukan string "Rp 150.000") supaya
// gampang dihitung otomatis di halaman booking (harga x jumlah malam).
// 'id' dipakai untuk menandai homestay yang dipilih lewat URL (?id=...).

$homestay_madiun = [

    [
        "id"    => "wilis-indah",
        "nama"  => "Homestay Wilis Indah",
        "jarak" => "2 km dari PSC",
        "rating"=> "4.8",
        "harga" => 150000,
        "img"   => "https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=800",
        "desc"  => "Homestay nyaman dengan fasilitas lengkap dan dekat pusat kota."
    ],

    [
        "id"    => "villa-lereng-wilis",
        "nama"  => "Villa Lereng Wilis",
        "jarak" => "15 km dari pusat kota",
        "rating"=> "4.9",
        "harga" => 300000,
        "img"   => "https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=800",
        "desc"  => "Villa dengan pemandangan pegunungan yang sejuk."
    ],

    [
        "id"    => "madiun-raya",
        "nama"  => "Penginapan Madiun Raya",
        "jarak" => "0.5 km dari Alun-Alun",
        "rating"=> "4.6",
        "harga" => 200000,
        "img"   => "https://images.unsplash.com/photo-1578683010236-d716f9a3f461?q=80&w=800",
        "desc"  => "Penginapan strategis dekat pusat kota."
    ],

    [
        "id"    => "guest-house-pahlawan",
        "nama"  => "Guest House Pahlawan",
        "jarak" => "1 km dari PSC",
        "rating"=> "4.7",
        "harga" => 175000,
        "img"   => "https://images.unsplash.com/photo-1616594039964-ae9021a400a0?q=80&w=800",
        "desc"  => "Guest House modern dengan fasilitas lengkap."
    ],

    [
        "id"    => "bantaran-sari",
        "nama"  => "Homestay Bantaran Sari",
        "jarak" => "300 m dari Bantaran Kali",
        "rating"=> "4.5",
        "harga" => 120000,
        "img"   => "https://images.unsplash.com/photo-1555854877-bab0e564b8d5?q=80&w=800",
        "desc"  => "Homestay murah dan nyaman."
    ]

];