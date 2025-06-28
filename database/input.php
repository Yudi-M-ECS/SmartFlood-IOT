<?php
header('Content-Type: application/json'); // Mengatur header respons sebagai JSON
include('koneksi.php'); // Pastikan koneksi.php mengatur koneksi ke database

$response = array(); // Array untuk menyimpan respons

// Memeriksa apakah semua parameter yang diperlukan ada
if (isset($_POST['jarak']) && isset($_POST['sensorValue']) && isset($_POST['status'])) {

    // Mengambil data dari POST
    $tinggi_air = $_POST['jarak'];
    $kadar_air = $_POST['sensorValue'];
    $status = $_POST['status'];

    // Mengatur zona waktu
    date_default_timezone_set('Asia/Makassar');
    $waktu = date("H:i:s");
    $tanggal = date("Y-m-d");

    // Mendapatkan hari dalam format bahasa Indonesia
    $hari = date("l");
    switch ($hari) {
        case 'Sunday':
            $hari = 'Minggu';
            break;
        case 'Monday':
            $hari = 'Senin';
            break;
        case 'Tuesday':
            $hari = 'Selasa';
            break;
        case 'Wednesday':
            $hari = 'Rabu';
            break;
        case 'Thursday':
            $hari = 'Kamis';
            break;
        case 'Friday':
            $hari = 'Jumat';
            break;
        case 'Saturday':
            $hari = 'Sabtu';
            break;
    }

    // Menyiapkan dan mengeksekusi query menggunakan prepared statements
    $stmt = $koneksi->prepare("INSERT INTO table_sensor (waktu, tanggal, hari, tinggi_air, kadar_air, status) VALUES (?, ?, ?, ?, ?, ?)");
    
    if ($stmt) {
        // Mengikat parameter ke query
        $stmt->bind_param("sssiss", $waktu, $tanggal, $hari, $tinggi_air, $kadar_air, $status);

        // Menjalankan query
        if ($stmt->execute()) {
            // Jika berhasil, mengembalikan respons sukses
            $response['status'] = 'success';
            $response['message'] = "Data berhasil disimpan: Jarak = $tinggi_air, SensorValue = $kadar_air, Status = $status, Hari = $hari";
        } else {
            // Jika gagal menjalankan query, mengembalikan respons error
            $response['status'] = 'error';
            $response['message'] = "Gagal Input: " . $stmt->error;
        }

        // Menutup statement
        $stmt->close();
    } else {
        // Jika gagal menyiapkan statement, mengembalikan respons error
        $response['status'] = 'error';
        $response['message'] = "Prepare failed: " . $koneksi->error;
    }

} else {
    // Jika parameter tidak lengkap, mengembalikan respons error
    $response['status'] = 'error';
    $response['message'] = "No data or missing parameters";
}

// Mengembalikan respons dalam format JSON
echo json_encode($response);
?>