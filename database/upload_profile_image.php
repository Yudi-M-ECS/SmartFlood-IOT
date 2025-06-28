<?php
session_start();
include('koneksi.php');

// Aktifkan error reporting untuk debugging (pastikan dimatikan di produksi)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['upload'])) {
    // Cek apakah file diunggah tanpa error
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profile_image']['tmp_name'];
        $fileName = $_FILES['profile_image']['name'];
        $fileSize = $_FILES['profile_image']['size'];
        $fileType = $_FILES['profile_image']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitasi nama file
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Ekstensi file yang diperbolehkan
        $allowedfileExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Validasi ukuran file (misalnya maksimal 2MB)
            $maxFileSize = 2 * 1024 * 1024; // 2MB
            if ($fileSize > $maxFileSize) {
                $_SESSION['error'] = "Ukuran file terlalu besar. Maksimal 2MB.";
                header("Location: ../profil.php");
                exit();
            }

            // Validasi apakah file benar-benar gambar
            $check = getimagesize($fileTmpPath);
            if($check === false){
                $_SESSION['error'] = "File yang diunggah bukan gambar.";
                header("Location: ../profil.php");
                exit();
            }

            // Validasi MIME type untuk keamanan tambahan
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $fileTmpPath);
            finfo_close($finfo);
            $allowedMimes = ['image/jpeg', 'image/png', 'image/gif'];
            if(!in_array($mime, $allowedMimes)){
                $_SESSION['error'] = "File yang diunggah bukan gambar yang valid.";
                header("Location: ../profil.php");
                exit();
            }

            // Direktori tempat menyimpan file yang diunggah
            $uploadFileDir = '../uploads/profile_images/';
            // Buat direktori jika belum ada
            if (!is_dir($uploadFileDir)) {
                if (!mkdir($uploadFileDir, 0755, true)) {
                    $_SESSION['error'] = "Gagal membuat direktori upload.";
                    header("Location: ../profil.php");
                    exit();
                }
            }
            $dest_path = $uploadFileDir . $newFileName;

            if(move_uploaded_file($fileTmpPath, $dest_path)) 
            {
                error_log("File berhasil diunggah ke: " . $dest_path);

                // Ambil path gambar lama sebelum diupdate
                $query_old = "SELECT profile_image FROM registrasi WHERE id = ?";
                $stmt_old = $koneksi->prepare($query_old);
                if(!$stmt_old){
                    $_SESSION['error'] = "Gagal menyiapkan query: " . $koneksi->error;
                    header("Location: ../profil.php");
                    exit();
                }
                $stmt_old->bind_param("i", $user_id);
                if(!$stmt_old->execute()){
                    $_SESSION['error'] = "Gagal mengeksekusi query: " . $stmt_old->error;
                    header("Location: ../profil.php");
                    exit();
                }
                $result_old = $stmt_old->get_result();
                $user_old = $result_old->fetch_assoc();

                // Update path gambar baru di basis data
                $query = "UPDATE registrasi SET profile_image = ? WHERE id = ?";
                $stmt = $koneksi->prepare($query);
                if(!$stmt){
                    $_SESSION['error'] = "Gagal menyiapkan query update: " . $koneksi->error;
                    header("Location: ../profil.php");
                    exit();
                }
                $stmt->bind_param("si", $dest_path, $user_id);
                if($stmt->execute()){
                    // Hapus gambar lama jika bukan default
                    if($user_old['profile_image'] != 'img/blank img.jpg' && file_exists($user_old['profile_image'])){
                        if(!unlink($user_old['profile_image'])){
                            error_log("Gagal menghapus gambar lama: " . $user_old['profile_image']);
                        }
                    }

                    // Redirect kembali ke halaman profil dengan pesan sukses
                    $_SESSION['message'] = "Foto profil berhasil diperbarui.";
                    header("Location: ../profil.php");
                    exit();
                } else {
                    $_SESSION['error'] = "Gagal memperbarui data di basis data: " . $stmt->error;
                }
            }
            else 
            {
                error_log("Gagal memindahkan file ke: " . $dest_path);
                $_SESSION['error'] = "Terjadi kesalahan saat memindahkan file yang diunggah.";
            }
        }
        else
        {
            $_SESSION['error'] = "Gagal mengunggah. Tipe file yang diperbolehkan: " . implode(", ", $allowedfileExtensions);
        }
    }
    else
    {
        $_SESSION['error'] = "Tidak ada file yang diunggah atau terjadi error saat unggah.";
    }

    // Redirect kembali ke halaman profil dengan pesan error
    header("Location: ../profil.php");
    exit();
}
?>