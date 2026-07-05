<?php
session_start();
require_once 'koneksi.php';
/*
=====================================================
DATA DESTINASI
(Salin array $wisata_madiun yang ada di landingpage)
=====================================================
*/

$wisata_madiun = [

    [
        "nama"=>"Pahlawan Street Center (PSC)",
        "lokasi"=>"Kartoharjo",
        "rating"=>"4.8",
        "harga"=>"Rp 10.000",
        "img"=>"https://assets-a1.kompasiana.com/items/album/2024/12/12/img-0113-675a6be334777c25d2352533.jpeg",
        "desc"=>"Malioboro-nya Kota Madiun."
    ],

    [
        "nama"=>"Taman Sumber Umis",
        "lokasi"=>"Manguharjo",
        "rating"=>"4.7",
        "harga"=>"Rp 15.000",
        "img"=>"https://lh3.googleusercontent.com/gps-cs-s/APNQkAH8uUwWANvaY_KcCc_DOCFanpBPe5Sn2-35TARv1y8vM2jR3gkRkGiqO3fMKHXbccYp-6BUTWPF5vIggnb5Ami70_Cp3RGjqIXl3AGoR0kRWbG6oKpkYc4NGZXu3vlgmQLXR_4U=s680-w680-h510-rw",
        "desc"=>"Taman kota yang indah."
    ],

    [
        "nama"=>"Alun-Alun Kota Madiun",
        "lokasi"=>"Manguharjo",
        "rating"=>"4.9",
        "harga"=>"Rp 10.000",
        "img"=>"https://i.pinimg.com/736x/38/0e/4e/380e4ee1282c408ecc7ea699bbfed5f7.jpg",
        "desc"=>"Pusat aktivitas warga."
    ],

    [
        "nama"=>"Taman Bantaran Kali Madiun",
        "lokasi"=>"Manguharjo",
        "rating"=>"4.6",
        "harga"=>"Rp 15.000",
        "img"=>"https://i.pinimg.com/736x/48/d3/1c/48d31cfe40c5fbbf57aae4657076c328.jpg",
        "desc"=>"Wisata pinggir sungai."
    ],

    [
        "nama"=>"Monumen Kresek",
        "lokasi"=>"Wungu",
        "rating"=>"4.5",
        "harga"=>"Rp 5.000",
        "img"=>"https://i.pinimg.com/736x/e1/7f/3d/e17f3d23eb9e1ebaf93a0a110e042856.jpg",
        "desc"=>"Wisata sejarah."
    ],

    [
        "nama"=>"Madiun Umbul Square",
        "lokasi"=>"Dolopo",
        "rating"=>"4.7",
        "harga"=>"Rp 30.000",
        "img"=>"https://images.unsplash.com/photo-1534447677768-be436bb09401?q=80&w=800",
        "desc"=>"Wisata keluarga."
    ],

    [
        "nama"=>"Waduk Bening Widas",
        "lokasi"=>"Saradan",
        "rating"=>"4.6",
        "harga"=>"Rp 10.000",
        "img"=>"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTQPN1tWAOQZVv-zr1HOZUONGea7I93Af8RVg&s",
        "desc"=>"Wisata alam."
    ],

    [
        "nama"=>"Desa Wisata Brumbun",
        "lokasi"=>"Wungu",
        "rating"=>"4.4",
        "harga"=>"Rp 15.000",
        "img"=>"https://images.unsplash.com/photo-1530866495561-507c9faab2ed?q=80&w=800",
        "desc"=>"River tubing."
    ],

    [
        "nama"=>"Ngrowo Bening Edupark",
        "lokasi"=>"Taman",
        "rating"=>"4.7",
        "harga"=>"Rp 10.000",
        "img"=>"https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRV1kaTQ4BcEAhSbmwe6UaDPV17HGbXQ5MUKw&s",
        "desc"=>"Agrowisata."
    ],

    [
        "nama"=>"Hutan Pinus Nongko Ijo",
        "lokasi"=>"Kare",
        "rating"=>"4.8",
        "harga"=>"Rp 10.000",
        "img"=>"https://indonesiatraveler.id/wp-content/uploads/2020/10/Madiun-Nongko-Ijo3-e1602582835404.jpg",
        "desc"=>"Wisata alam."
    ]

];

?>

<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Semua Destinasi Wisata</title>

<script src="https://cdn.tailwindcss.com"></script>

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

</head>

<body class="bg-gray-100">

<!-- HEADER -->

<header class="bg-white shadow">

<div class="max-w-7xl mx-auto px-6 py-5 flex justify-between items-center">

<h1 class="text-2xl font-bold text-teal-700">

<i class="fa-solid fa-location-dot"></i>

MadiunTrack

</h1>

<a href="dashboard_user.php"

class="bg-orange-500 text-white px-5 py-2 rounded-lg">

Kembali

</a>

</div>

</header>

<!-- JUDUL -->

<section class="max-w-7xl mx-auto px-6 py-10">

<h2 class="text-3xl font-bold mb-2">

Semua Destinasi Wisata Madiun

</h2>

<p class="text-gray-500 mb-8">

Temukan seluruh destinasi wisata yang tersedia.

</p>

<!-- CARD -->

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

<?php foreach($wisata_madiun as $wisata): ?>

<div class="bg-white rounded-2xl shadow hover:shadow-xl duration-300 overflow-hidden">

<img src="<?= $wisata['img']; ?>"

class="w-full h-52 object-cover">

<div class="p-5">

<div class="flex justify-between items-center">

<h3 class="font-bold text-lg">

<?= $wisata['nama']; ?>

</h3>

<span class="bg-yellow-400 text-white px-2 rounded">

⭐ <?= $wisata['rating']; ?>

</span>

</div>

<p class="text-gray-500 mt-2">

<i class="fa-solid fa-location-dot text-red-500"></i>

<?= $wisata['lokasi']; ?>

</p>

<p class="text-gray-600 mt-3">

<?= $wisata['desc']; ?>

</p>

<p class="font-bold text-teal-600 mt-3">

<?= $wisata['harga']; ?>

</p>

<div class="flex gap-2 mt-5">

<a href="informasi_destinasi.php"

class="w-1/2 text-center border border-teal-600 text-teal-600 py-2 rounded-lg hover:bg-teal-600 hover:text-white">

Detail

</a>

<a href="beli_tiket.php"

class="w-1/2 text-center bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600">

Beli Tiket

</a>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</section>

</body>
</html>