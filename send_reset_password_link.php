<?php
session_start();
include('database/koneksi.php');

// Ambil email dari form
$email = $_POST['email'];

// Cek apakah email terdaftar
$query = "SELECT * FROM registrasi WHERE email = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Buat token unik untuk reset password
    $token = bin2hex(random_bytes(50));
    $user = $result->fetch_assoc();
    $user_id = $user['id'];

    // Simpan token ke database
    $query = "INSERT INTO password_resets (user_id, token) VALUES (?, ?)";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("is", $user_id, $token);
    $stmt->execute();

    // Buat tautan reset password
    $reset_link = "http://localhost/SmartFlood/reset_password.php/reset_password.php?token=$token";


    // Kirim email ke pengguna
    $subject = "Reset Your Password";
    $message = "Click on this link to reset your password: " . $reset_link;
    $headers = "From: no-reply@yourwebsite.com";

    mail($email, $subject, $message, $headers);

    echo "A password reset link has been sent to your email address.";
} else {
    echo "Email not found!";
}
?>