<?php
session_start();
require_once '../config/koneksi.php';

$homestay_madiun = [

[
"nama"=>"Homestay Wilis Indah",
"jarak"=>"2 km dari PSC",
"rating"=>"4.8",
"harga"=>"Rp 150.000",
"img"=>"https://images.unsplash.com/photo-1631049307264-da0ec9d70304?q=80&w=800",
"desc"=>"Homestay nyaman dengan fasilitas lengkap dan dekat pusat kota."
],

[
"nama"=>"Villa Lereng Wilis",
"jarak"=>"15 km dari pusat kota",
"rating"=>"4.9",
"harga"=>"Rp 300.000",
"img"=>"https://images.unsplash.com/photo-1522708323590-d24dbb6b0267?q=80&w=800",
"desc"=>"Villa dengan pemandangan pegunungan yang sejuk."
],

[
"nama"=>"Penginapan Madiun Raya",
"jarak"=>"0.5 km dari Alun-Alun",
"rating"=>"4.6",
"harga"=>"Rp 200.000",
"img"=>"https://images.unsplash.com/photo-1578683010236-d716f9a3f461?q=80&w=800",
"desc"=>"Penginapan strategis dekat pusat kota."
],

[
"nama"=>"Guest House Pahlawan",
"jarak"=>"1 km dari PSC",
"rating"=>"4.7",
"harga"=>"Rp 175.000",
"img"=>"https://images.unsplash.com/photo-1616594039964-ae9021a400a0?q=80&w=800",
"desc"=>"Guest House modern dengan fasilitas lengkap."
],

[
"nama"=>"Homestay Bantaran Sari",
"jarak"=>"300 m dari Bantaran Kali",
"rating"=>"4.5",
"harga"=>"Rp 120.000",
"img"=>"https://images.unsplash.com/photo-1555854877-bab0e564b8d5?q=80&w=800",
"desc"=>"Homestay murah dan nyaman."
]

];
?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">

<title>Semua Homestay</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="bg-gray-100">

<header class="bg-white shadow">

<div class="max-w-7xl mx-auto flex justify-between items-center px-6 py-5">

<h1 class="text-2xl font-bold text-teal-700">

<i class="fa-solid fa-house"></i>

MadiunTrack

</h1>

<a href="landing_user.php"
class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-lg">

← Kembali

</a>

</div>

</header>

<section class="max-w-7xl mx-auto py-10 px-6">

<h2 class="text-3xl font-bold mb-2">

Semua Homestay di Madiun

</h2>

<p class="text-gray-500 mb-8">

Temukan homestay terbaik untuk perjalananmu.

</p>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

<?php foreach($homestay_madiun as $home): ?>

<div class="bg-white rounded-2xl shadow hover:shadow-xl overflow-hidden">

<img src="<?= $home['img']; ?>"
class="w-full h-52 object-cover">

<div class="p-5">

<div class="flex justify-between">

<h3 class="font-bold text-lg">

<?= $home['nama']; ?>

</h3>

<span class="bg-yellow-400 text-white px-2 rounded">

⭐ <?= $home['rating']; ?>

</span>

</div>

<p class="text-gray-500 mt-2">

<i class="fa-solid fa-location-dot text-red-500"></i>

<?= $home['jarak']; ?>

</p>

<p class="text-gray-600 mt-3">

<?= $home['desc']; ?>

</p>

<p class="text-teal-600 font-bold mt-4">

<?= $home['harga']; ?>

<span class="text-gray-400 text-sm">/ malam</span>

</p>

<div class="flex gap-2 mt-5">

<a href="detail_homestay.php"
class="w-1/2 border border-teal-600 text-teal-600 text-center py-2 rounded-lg hover:bg-teal-600 hover:text-white">

Detail

</a>

<a href="booking_homestay.php"
class="w-1/2 bg-orange-500 hover:bg-orange-600 text-white text-center py-2 rounded-lg">

Booking

</a>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</section>

</body>
</html>