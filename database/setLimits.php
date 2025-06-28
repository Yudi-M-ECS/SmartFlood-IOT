<?php
// setLimits.php

// Tambahkan header CORS
header("Access-Control-Allow-Origin: *"); // Ganti '*' dengan origin spesifik jika perlu
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Cek metode permintaan
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    // Handle preflight request
    exit(0);
}

// Sertakan koneksi ke database
include('koneksi.php'); // Pastikan koneksi.php mengatur koneksi ke database

// Mengambil data POST
$limitDown = isset($_POST['limitDown']) ? intval($_POST['limitDown']) : null;
$limitUp = isset($_POST['limitUp']) ? intval($_POST['limitUp']) : null;
$limitMax = isset($_POST['limitMax']) ? intval($_POST['limitMax']) : null;
$password_input = isset($_POST['password']) ? $_POST['password'] : '';

$stored_password = "1234"; 

// Validasi password
if ($password_input !== $stored_password) {
    http_response_code(403);
    echo "Unauthorized: Incorrect password.";
    exit();
}


// Validasi input
if ($limitDown === null || $limitUp === null || $limitMax === null) {
    http_response_code(400);
    echo "Missing parameters";
    exit();
}

// Cek apakah data sudah ada
$sql = "SELECT * FROM limits WHERE id = 1";
$result = $koneksi->query($sql);

if ($result->num_rows > 0) {
    // Update data
    $sql = "UPDATE limits SET limitDown = ?, limitUp = ?, limitMax = ? WHERE id = 1";
    $stmt = $koneksi->prepare($sql);
    if ($stmt === false) {
        http_response_code(500);
        echo "Prepare failed: " . $koneksi->error;
        exit();
    }
    $stmt->bind_param("iii", $limitDown, $limitUp, $limitMax);
    if ($stmt->execute()) {
        echo "Limits updated successfully!";
    } else {
        http_response_code(500);
        echo "Error updating limits.";
    }
    $stmt->close();
} else {
    // Insert data
    $sql = "INSERT INTO limits (limitDown, limitUp, limitMax) VALUES (?, ?, ?)";
    $stmt = $koneksi->prepare($sql);
    if ($stmt === false) {
        http_response_code(500);
        echo "Prepare failed: " . $koneksi->error;
        exit();
    }
    $stmt->bind_param("iii", $limitDown, $limitUp, $limitMax);
    if ($stmt->execute()) {
        echo "Limits set successfully!";
    } else {
        http_response_code(500);
        echo "Error setting limits.";
    }
    $stmt->close();
}

$koneksi->close();
?>