document.getElementById("registerForm").addEventListener("submit", function (event) {
  event.preventDefault(); // Mencegah form dari pengiriman default

  // Logika lain seperti validasi bisa ditambahkan di sini

  // Pindahkan ke halaman lain setelah tombol diklik
  window.location.href = "login.php"; // Ganti dengan nama file HTML yang diinginkan
});
