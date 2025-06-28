<?php
session_start();
include('database/koneksi.php');

if ($_POST['password'] !== $_POST['confirm_password']) {
    echo "Passwords do not match!";
    exit();
}

$token = $_POST['token'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

// Cek token valid
$query = "SELECT * FROM password_resets WHERE token = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $reset_data = $result->fetch_assoc();
    $user_id = $reset_data['user_id'];

    // Update password pengguna
    $query = "UPDATE registrasi SET password = ? WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("si", $password, $user_id);
    $stmt->execute();

    // Hapus token reset
    $query = "DELETE FROM password_resets WHERE token = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();

    echo "Password has been reset successfully.";
} else {
    echo "Invalid token!";
}
?>