<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smart Flood Monitor</title>

  <!-- LineIcons -->
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

  <!-- Bootstrap5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- DataTables CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet">

  <!-- CSS -->
  <link rel="stylesheet" href="style.css" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

</head>

<body>
  <?php
session_start();
include('./database/koneksi.php');

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ./database/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Ambil data profil pengguna dari database
$query = "SELECT * FROM registrasi WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>
  <div class="wrapper d-flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="js-sidebar">
      <div class="h-100 container-sidebar">
        <div class="sidebar-logo p-4">
          <a href="#">Smart Flood</a>
        </div>
        <ul class="sidebar-nav list-unstyled">
          <li class="sidebar-header px-4 py-2">Elements</li>
          <li class="sidebar-item text-white">
            <a href="index.php" class="sidebar-link">
              <i class="lni lni-grid-alt"></i>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="profil.php" class="sidebar-link">
              <i class="lni lni-user"></i>
              <span>Profil</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="table.php" class="sidebar-link">
              <i class="lni lni-layout"></i>
              <span>Data</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="settings.php" class="sidebar-link">
              <i class="lni lni-cog"></i>
              <span>Settings</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="cameraESP32Cam.php" class="sidebar-link">
              <i class="lni lni-video"></i>
              <span>Camera</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="dataperDay.php" class="sidebar-link">
              <i class="lni lni-layers"></i>
              <span>History</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="bar_chart.php" class="sidebar-link">
              <i class="lni lni-graph"></i>
              <span>Charts</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-target="#auth" data-bs-toggle="collapse"
              aria-expanded="false">
              <i class="lni lni-protection"></i>
              <span>Auth</span>
            </a>
            <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
              <li class="sidebar-item">
                <a href="login.php" class="sidebar-link">Login</a>
              </li>
              <li class="sidebar-item">
                <a href="register.php" class="sidebar-link">Register</a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="main flex-grow-1">
      <!-- Navbar -->
      <nav class="navbar navbar-expand px-3 border-bottom navbar-light bg-light fixed-top" id="navbar">
        <div class="container-fluid">
          <button class="btn" id="sidebar-toggle" type="button">
            <i class="lni lni-menu"></i>
            <span class="ms-2 d-none d-md-inline fs-5">Monitoring</span>
          </button>
          <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
              <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..."
                aria-describedby="btnNavbarSearch" />
              <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i
                  class="lni lni-search-alt"></i></button>
            </div>
          </form>
          <div class="ms-auto">
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" role="button"
                  data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="<?php echo htmlspecialchars(str_replace('../', '', $user['profile_image'])); ?>"
                    class="avatar img-fluid rounded-circle" alt="User Avatar" />
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                  <li><a class="dropdown-item" href="profil.php">Profile</a></li>
                  <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                  <li>
                    <hr class="dropdown-divider" />
                  </li>
                  <li><a class="dropdown-item" href="login.php">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Content Area -->
      <main class="content px-3 py-2" id="content">
        <div class="continer-content row g-3">
          <!-- ESP32 CAM PALACE -->
          <div class="col-12 col-lg-12">
            <div
              class="cam-monitoring d-flex flex-column justify-content-center align-items-center shadow p-2 m-4 rounded-4"
              style="background-color: #11009e; height: auto;">
              <span class="text-white fs-6 fst-italic">ESP32CAM STREAMING </span>
              <img src="http://192.168.189.56/stream" alt="Streaming from ESP32 CAM"
                style="width: 100%; height: auto; border-radius: 10px; margin-top: 10px;" />
            </div>
          </div>


          <!-- Data Table -->
          <div class="data">
            <div class="container-data border shadow rounded-4 bg-white">
              <div class="table-header d-flex align-items-center justify-content-between mb-3 px-4"
                style="background-color: #11009e; padding: .5rem; border-radius: 0.5rem 0.5rem 0rem 0rem ">
                <div class="text-white fs-5 d-flex align-items-center">
                  <i class="lni lni-layout me-2"></i>
                  <span class="fs-6">Data Sensor</span>
                </div>
                <button class="btn btn-success btn-export" onclick="exportToExcel()">Export to Excel</button>
              </div>
              <div id="printableArea" class="container-table px-2 table-responsive">
                <table id="datatablesSimple2" class="table table-striped" style="width: 100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Waktu</th>
                      <th>Tanggal</th>
                      <th>Tinggi Air</th>
                      <th>Kadar Air</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Data akan diisi oleh DataTables melalui AJAX -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </main>
    </div>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>

  <!-- Chart.js -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

  <!-- JavaScript untuk Auto Refresh DataTable -->
  <script>
  $(document).ready(function() {
    let table = $("#datatablesSimple2").DataTable({
      responsive: true,
      ordering: true,
      paging: true,
      info: true,
      autoWidth: true,
      searching: true,
      ajax: {
        url: "getData.php",
        type: "GET",
        dataSrc: "" // Asumsikan respons adalah array
      },
      columns: [{
          data: 'no'
        },
        {
          data: 'waktu'
        },
        {
          data: 'tanggal'
        },
        {
          data: 'tinggi_air'
        },
        {
          data: 'kadar_air'
        },
        {
          data: 'status'
        }
      ]
    });

    // Set interval untuk me-refresh tabel setiap 10 detik
    setInterval(function() {
      table.ajax.reload(null, false); // false agar tetap berada di halaman yang sama
    }, 10000); // 10000 ms = 10 detik
  });
  </script>

  <script>
  function exportToExcel() {
    // Ambil data dari tabel
    var table = document.getElementById('datatablesSimple2');

    // Buat instance Workbook dari SheetJS
    var workbook = XLSX.utils.table_to_book(table, {
      sheet: "Sheet1"
    });

    // Simpan file Excel
    XLSX.writeFile(workbook, 'data_sensor.xlsx');
  }
  </script>

  <script>
  document.getElementById('flashOn').addEventListener('click', function() {
    fetch('http://192.168.91.132/flash?state=on') // Pastikan http, bukan https
      .then(response => response.text())
      .then(data => {
        console.log(data);
        alert('Flash turned ON');
      })
      .catch(error => console.error('Error:', error));
  });

  document.getElementById('flashOff').addEventListener('click', function() {
    fetch('http://192.168.91.132/flash?state=off') // Pastikan http, bukan https
      .then(response => response.text())
      .then(data => {
        console.log(data);
        alert('Flash turned OFF');
      })
      .catch(error => console.error('Error:', error));
  });
  </script>

  <!-- Custom Scripts -->
  <script src="./script/script.js"></script>
  <script src="./script/datatable.js"></script>
  <script src="./demo/pieChart.js"></script>
  <script src="./demo/lineChart.js"></script>
  <script src="./demo/barChart.js"></script>
</body>

</html>