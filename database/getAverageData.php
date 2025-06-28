<?php
header('Content-Type: application/json'); // Mengatur header respons sebagai JSON
include('koneksi.php'); // Pastikan koneksi.php mengatur koneksi ke database

$response = array(); // Array untuk menyimpan respons

try {
    // Query untuk mengambil rata-rata tinggi_air per hari
    $stmt = $koneksi->prepare("
    SELECT 
        hari, 
        AVG(tinggi_air) AS rata_rata_tinggi_air 
    FROM 
        table_sensor 
    WHERE 
        WEEKOFYEAR(tanggal) = WEEKOFYEAR(CURDATE())  -- Hanya ambil data minggu ini
    GROUP BY 
        hari 
    ORDER BY 
        FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')
");

    $stmt->execute();
    $result = $stmt->get_result();

    $labels = [];
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $labels[] = $row['hari'];
        $data[] = round(floatval($row['rata_rata_tinggi_air']), 2); // Pembulatan ke 2 desimal
    }

    $response = [
        'labels' => $labels,
        'data' => $data
    ];

} catch (Exception $e) {
    // Menangani kesalahan
    $response = [
        'error' => $e->getMessage()
    ];
}

// Mengembalikan respons dalam format JSON
echo json_encode($response);
?>