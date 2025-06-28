<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>

  <!-- LineIcons -->
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />

  <!-- Bootstrap5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- CSS -->
  <link rel="stylesheet" href="style.css" />
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
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
            <span class="ms-2 d-none d-md-inline fs-5">Data Per Month</span>
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
      <main class="content px-3" id="content" style="padding-top: 7rem; padding-bottom: 3rem">
        <!-- Charts -->
        <div class="charts w-100 mb-5">
          <div class="row g-4 justify-content-center w-100 m-auto shadow rounded-4">
            <div class="col-12 col-lg-6">
              <div class="p-3">
                <h3 class="text-center py-3">Total Ketinggian Air/Bulan</h3>
                <canvas id="pie-chart" width="400" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="title mx-auto mb-3 text-center rounded-2 py-2 w-25" style="background-color: #11009e">
            <h3 class="text-white">Data Sensor per Bulan</h3>
          </div> -->
        <div class="container-data border shadow rounded-4 bg-white my-3">
          <div class="table-header d-flex align-items-center justify-content-between mb-3"
            style="background-color: #11009e; padding: 0.5rem; border-radius: 0.5rem">
            <div class="text-white fs-5 d-flex align-items-center">
              <i class="lni lni-layout me-2"></i>
              <span>Data Sensor Bulan Januari</span>
            </div>
            <button class="btn btn-warning fs-6" onclick="printTable()">Cetak Data</button>
          </div>
          <div id="printableArea" class="container-table px-5 table-responsive">
            <table id="datatablesSimple" class="table table-striped" style="width: 100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Waktu</th>
                  <th>Tanggal</th>
                  <th>Tinggi Air</th>
                  <th>Kadar Air</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="container-data border shadow rounded-4 bg-white my-3">
          <div class="table-header d-flex align-items-center justify-content-between mb-3"
            style="background-color: #11009e; padding: 0.5rem; border-radius: 0.5rem">
            <div class="text-white fs-5 d-flex align-items-center">
              <i class="lni lni-layout me-2"></i>
              <span>Data Sensor Bulan Januari</span>
            </div>
            <button class="btn btn-warning fs-6" onclick="printTable()">Cetak Data</button>
          </div>
          <div id="printableArea" class="container-table px-5 table-responsive">
            <table id="datatablesSimple" class="table table-striped" style="width: 100%">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Waktu</th>
                  <th>Tanggal</th>
                  <th>Tinggi Air</th>
                  <th>Kadar Air</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>0:0:0</td>
                  <td>29-09-2024</td>
                  <td>2 cm</td>
                  <td>10 %</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
  <script src="./script/datatable.js"></script>
  <script src="./script/script.js"></script>
  <script src="./demo/pieChart.js"></script>
  <script src="./demo/lineChart.js"></script>
  <script>
  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = "#292b2c";

  // Bar Chart Example
  var ctx = document.getElementById("pie-chart");
  var myLineChart = new Chart(ctx, {
    type: "pie",
    data: {
      labels: ["Januari", "Februari", "Maret", "April", "Mei"],
      datasets: [{
        data: [12.21, 15.58, 11.25, 8.32, 8.32],
        backgroundColor: ["#007bff", "#dc3545", "#ffc107", "#28a745", "#284745"],
      }, ],
    },
  });
  </script>
</body>

</html>