const sidebarToggle = document.querySelector("#sidebar-toggle");
sidebarToggle.addEventListener("click", function () {
  document.querySelector("#sidebar").classList.toggle("expand");
  document.querySelector("#navbar").classList.toggle("expand");
});

function printTable() {
  // Simpan elemen yang ingin dicetak
  var printContents = document.getElementById("printableArea").innerHTML;

  // Buat window baru untuk mencetak
  var printWindow = window.open("", "", "height=500,width=800");

  // Tambahkan gaya CSS dari halaman utama agar tetap tampil dengan baik saat dicetak
  printWindow.document.write("<html><head><title>Print Table</title>");
  printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />');
  printWindow.document.write("</head><body>");

  // Masukkan konten yang ingin dicetak
  printWindow.document.write(printContents);
  printWindow.document.write("</body></html>");

  // Tunggu hingga halaman siap untuk dicetak
  printWindow.document.close();
  printWindow.focus();

  // Cetak halaman
  printWindow.print();

  // Tutup window setelah cetak
  printWindow.close();
}
