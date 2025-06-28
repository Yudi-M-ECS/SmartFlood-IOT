<?php
header('Content-Type: application/json');

include('./database/koneksi.php');

$sql = "SELECT * FROM table_sensor ORDER BY id DESC";
$result = mysqli_query($koneksi, $sql);

$data = array();
$no = 1;
while($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'no' => $no++,
        'waktu' => $row['waktu'],
        'tanggal' => $row['tanggal'],
        'hari' => $row['hari'],
        'tinggi_air' => $row['tinggi_air'] . ' cm',
        'kadar_air' => $row['kadar_air'] . ' %',
        'status' => $row['status'],
    );
}

echo json_encode($data);
?>