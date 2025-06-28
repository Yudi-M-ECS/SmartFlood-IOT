<?php
// File: process_login.php

include('koneksi.php');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validasi input
    if (empty($email) || empty($password)) {
        echo "<script>
                alert('Silakan isi semua field.');
                window.location.href = '../login.php';
              </script>";
        exit();
    }

    // Menyiapkan prepared statement untuk SELECT
    $stmt = $koneksi->prepare("SELECT * FROM registrasi WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password (pastikan Anda menggunakan password_hash saat registrasi)
        if (password_verify($password, $user['password'])) {
            // Simpan data pengguna di session
            $_SESSION['user_id'] = $user['id']; // Pastikan ada kolom `id` di tabel
            $_SESSION['fullname'] = $user['fullname'];  
            // Redirect ke halaman profil atau dashboard
            header("Location: ../index.php");
            exit();
        } else {
            echo "<script>
                    alert('Password salah!');
                    window.location.href = '../login.php';
                  </script>";
            exit();
        }
    } else {
        echo "<script>
                alert('Email tidak terdaftar!');
                window.location.href = '../login.php';
              </script>";
        exit();
    }

    $stmt->close();
    $koneksi->close();
} else {
    header("Location: ../login.php");
    exit();
}
?>