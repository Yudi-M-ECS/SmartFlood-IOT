$(document).ready(function () {
  // Inisialisasi DataTable
  let table = $("#datatablesSimple").DataTable({
    ordering: true,
    paging: true,
    info: true,
    autoWidth: false,
    searching: true,
  });

  // Fungsi untuk me-refresh tabel dengan data terbaru dari server
  function refreshTable() {
    $.ajax({
      url: "getData.php", // Ganti dengan script server Anda
      type: "GET",
      success: function (data) {
        // Log response untuk debugging
        console.log("Data received from getData.php:", data);

        // Menghapus data lama di dalam tabel
        table.clear();

        // Memasukkan data baru
        $("#data22").html(data);

        // Menambahkan data ke DataTable dan merender ulang
        table.rows.add($("#data22 tr")).draw(false); // draw(false) agar tidak reset ke halaman pertama
      },
      error: function () {
        console.error("Error fetching data");
      },
    });
  }

  // Panggil fungsi refresh pertama kali saat halaman dimuat
  refreshTable();

  // Set interval untuk me-refresh tabel setiap 10 detik
  setInterval(refreshTable, 500);
});
