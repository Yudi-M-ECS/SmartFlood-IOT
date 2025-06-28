<?php
// File: register.php

include('koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $age = intval($_POST["age"]);
    $gender = trim($_POST["gender"]);
    $number_phone = trim($_POST["number_phone"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Validasi input
    if (empty($fullname) || empty($age) || empty($gender) || empty($number_phone) || empty($email) || empty($password) || empty($confirm_password)) {
        echo "<script>
                alert('Silakan isi semua field.');
                window.location.href = '../register.php';
              </script>";
        exit();
    }

    if ($password !== $confirm_password) {
        echo "<script>
                alert('Password dan konfirmasi password tidak cocok!');
                window.location.href = '../register.php';
              </script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Format email tidak valid!');
                window.location.href = '../register.php';
              </script>";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Tetapkan path gambar profil default
    $profile_image = 'img/profil.jpg'; // Pastikan path ini sesuai dengan struktur direktori Anda

    // Menyiapkan prepared statement untuk INSERT termasuk profile_image
    $stmt = $koneksi->prepare("INSERT INTO registrasi (fullname, age, gender, number_phone, email, password, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssss", $fullname, $age, $gender, $number_phone, $email, $hashed_password, $profile_image);

    if ($stmt->execute()) {
        echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                window.location.href = '../login.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Registrasi gagal: " . $stmt->error . "');
                window.location.href = '../register.php';
              </script>";
        exit();
    }

    $stmt->close();
    $koneksi->close();
} else {
    header("Location: ../register.php");
    exit();
}
?>