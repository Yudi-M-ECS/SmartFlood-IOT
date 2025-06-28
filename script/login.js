document.getElementById("registerForm").addEventListener("submit", function (event) {
  event.preventDefault(); // Mencegah form dari pengiriman default

  // Logika validasi sederhana (misalnya, memeriksa apakah field kosong)
  let username = document.getElementById("username").value;
  let password = document.getElementById("password").value;

  if (username === "" || password === "") {
    alert("Silakan isi semua field.");
    return; // Berhenti di sini jika validasi gagal
  }

  // Jika validasi berhasil, pindahkan ke halaman login
  window.location.href = "index.php"; // Ganti dengan nama file HTML yang diinginkan
});
