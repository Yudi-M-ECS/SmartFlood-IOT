<?php
// getLimits.php

// Tambahkan header CORS
header("Access-Control-Allow-Origin: *"); // Ganti '*' dengan origin spesifik jika perlu
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Handle preflight request
    exit(0);
}

header('Content-Type: application/json');

// Sertakan koneksi ke database
include('koneksi.php'); // Pastikan koneksi.php mengatur koneksi ke database

// Mengambil data
$sql = "SELECT limitDown, limitUp, limitMax FROM limits WHERE id = 1";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    $limits = $result->fetch_assoc();
    echo json_encode($limits);
} else {
    echo json_encode(["error" => "Limits not set"]);
}

$koneksi->close();
?>