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

  <!-- SheetJS -->
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
            <span class="ms-2 d-none d-md-inline fs-5">Dashboard</span>
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
      <main class="content px-3 pt-1 pb-3" id="content">
        <div class="continer-content row ">
          <!-- Welcome Card -->
          <div class="col-12 col-lg-12 mb-4">
            <div class="shadow p-4 rounded-4" style="background-image: url('./img/page-title-bg.jpg')">
              <div class="header-db text-center text-white">
                <div class="mb-3">
                  <span class="text-header" style="font-size: 1.5rem; font-weight: 600;">Welcome to </span>
                  <span style="font-size: 1.5rem; font-weight: 600;">
                    <span class="logo-text" style="font-size: 1.5rem;">Smart Flood Monitor</span> Website
                  </span>
                </div>
                <div class="mb-3">
                  <p style="font-size: 1.2rem;">Tempat Anda Memonitoring Ketinggian Air</p>
                  <p style="font-size: 1.2rem;">Untuk Pencegahan Awal Terjadinya Bencana Banjir</p>
                </div>
                <!-- <div>
                  <a href="#" role="button" class="btn btn-warning">View More</a>
                </div> -->
              </div>
            </div>
          </div>

          <!-- ESP32 CAM PALACE -->
          <div class="col-12 col-lg-4 m-auto">
            <div
              class="cam-monitoring d-flex flex-column justify-content-center align-items-center shadow p-2 rounded-4"
              style="background-image: url('./img/page-title-bg.jpg'); height: auto;">
              <span class="text-white fs-6 fst-italic pb-2">ESP32 CAM MONITORING</span>
              <a href="cameraESP32Cam.php" class="btn btn-warning">Click Here To View</a>
            </div>
          </div>

          <!-- Charts -->
          <!-- Charts -->
          <div class="charts my-4">
            <div class="row g-4">
              <div class="col-12 col-lg-12 mb-3">
                <div class="shadow p-3 rounded-4 bg-white">
                  <canvas id="lineChart" style="height: 300px; width: 100%;"></canvas>
                </div>
              </div>

              <!-- <div class="col-12 col-lg-6 mb-3">
                <div class="shadow p-3 rounded-4 bg-white">
                  <canvas id="barChart" style="height: 300px;"></canvas>
                </div>
              </div> -->
            </div>
          </div>


          <!-- Data Table -->
          <div class="data">
            <div class="container-data border shadow rounded-4 bg-white p-0">
              <div class="table-header d-flex align-items-center justify-content-between mb-3 px-4"
                style="background-color: #11009e; padding: .5rem; border-radius: 0.5rem 0.5rem 0rem 0rem ">
                <div class="text-white fs-5 d-flex align-items-center">
                  <i class="lni lni-layout me-2"></i>
                  <span class="fs-6">Data Sensor</span>
                </div>
                <button class="btn btn-success btn-export" onclick="exportToExcel()">Export to Excel</button>
              </div>
              <div id="printableArea" class="container-table px-2 table-responsive">
                <table id="datatables_Simple" class="table table-striped" style="width: 100%">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Waktu</th>
                      <th>Tanggal</th>
                      <th>Hari</th>
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
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
  <!-- Chart.js v4 -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


  <!-- JavaScript untuk Auto Refresh DataTable -->
  <script>
  $(document).ready(function() {
    let table = $("#datatables_Simple").DataTable({
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
          data: 'hari'
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
    var table = document.getElementById('datatables_Simple');

    // Buat instance Workbook dari SheetJS
    var workbook = XLSX.utils.table_to_book(table, {
      sheet: "Sheet1"
    });

    // Simpan file Excel
    XLSX.writeFile(workbook, 'data_sensor.xlsx');
  }
  </script>


  <!-- Custom Scripts -->
  <script src="./script/script.js"></script>
  <script src="./script/datatable.js"></script>
  <!-- <script src="./demo/lineChart.js"></script> -->
  <!-- <script src="./demo/barChart.js"></script> -->

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    // Mengambil data dari server menggunakan fetch API
    fetch('database/getAverageData.php') // Sesuaikan path jika lokasi berbeda
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          console.error('Error:', data.error);
          return;
        }

        // Set default font family dan warna
        Chart.defaults.font.family =
          '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
        Chart.defaults.color = "#292b2c";

        // Konfigurasi Line Chart
        const ctx = document.getElementById('lineChart').getContext('2d');
        const myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: data.labels, // Hari
            datasets: [{
              label: 'Rata-rata Tinggi Air (cm)',
              data: data.data, // Rata-rata tinggi_air
              fill: false,
              borderColor: 'rgba(75, 192, 192, 1)',
              backgroundColor: 'rgba(75, 192, 192, 0.2)',
              tension: 0.1
            }]
          },
          options: {
            responsive: true,

            plugins: {
              legend: {
                position: 'top',
              },
              title: {
                display: true,
                text: 'Rata-Rata Tinggi Air per Hari',
                font: {
                  size: 18
                }
              },
              tooltip: {
                enabled: true,
                callbacks: {
                  label: function(context) {
                    let label = context.dataset.label || '';
                    let value = context.parsed.y || 0;
                    return `${label}: ${value} cm`;
                  }
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                title: {
                  display: true,
                  text: 'Tinggi Air (cm)'
                }
              },
              x: {
                title: {
                  display: true,
                  text: 'Hari'
                }
              }
            }
          }
        });
      })
      .catch(error => {
        console.error('Error fetching data:', error);
      });
  });
  </script>

  <script>
  // demo/barChart.js

  document.addEventListener("DOMContentLoaded", function() {
    // Mengambil data dari server menggunakan fetch API (sesuaikan jika diperlukan)
    // fetch('demo/getBarData.php')
    //     .then(response => response.json())
    //     .then(data => {
    //         // Definisikan chart sesuai data
    //     })
    //     .catch(error => {
    //         console.error('Error fetching data:', error);
    //     });

    // Contoh data statis
    const data = {
      labels: ["Tegangan"],
      datasets: [{
        label: "Tegangan (Voltage)",
        data: [5],
        backgroundColor: "rgba(2,117,216,1)",
        borderColor: "rgba(2,117,216,1)",
        borderWidth: 1,
      }, ],
    };

    const config = {
      type: "bar",
      data: data,
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true,
          },
          title: {
            display: true,
            text: "Jumlah Tegangan",
            font: {
              size: 18,
            },
          },
          tooltip: {
            enabled: true,
            callbacks: {
              label: function(context) {
                let label = context.dataset.label || "";
                let value = context.parsed.y || 0;
                return `${label}: ${value} V`;
              },
            },
          },
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 12,
            ticks: {
              stepSize: 2,
            },
            title: {
              display: true,
              text: "Tegangan (V)",
            },
          },
          x: {
            title: {
              display: true,
              text: "Kategori",
            },
          },
        },
      },
    };

    const ctx = document.getElementById("barChart").getContext("2d");
    const myBarChart = new Chart(ctx, config);
  });
  </script>
</body>

</html>