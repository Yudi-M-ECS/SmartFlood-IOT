<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Limit Setting</title>

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
    <div class="flex-grow-1">
      <!-- Navbar -->
      <nav class="navbar navbar-expand px-3 border-bottom navbar-light bg-light fixed-top" id="navbar">
        <div class="container-fluid">
          <button class="btn" id="sidebar-toggle" type="button">
            <i class="lni lni-menu"></i>
            <span class="ms-2 d-none d-md-inline fs-5">Settings</span>
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
      <main class="content px-3" id="content" style="padding-top: 8rem">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
              <div class="card shadow p-4">
                <h3 class="text-center text-primary fw-bold mb-4">LIMIT SETTING</h3>
                <form id="limitForm">
                  <div class="mb-3">
                    <label for="limitDown" class="form-label">Limit Down (cm)</label>
                    <input type="number" class="form-control bg-secondary-subtle" id="limitDown" name="limitDown"
                      required>
                  </div>
                  <div class="mb-3">
                    <label for="limitUp" class="form-label">Limit Up (cm)</label>
                    <input type="number" class="form-control bg-secondary-subtle" id="limitUp" name="limitUp" required>
                  </div>
                  <div class="mb-3">
                    <label for="limitMax" class="form-label">Limit Max (cm)</label>
                    <input type="number" class="form-control bg-secondary-subtle" id="limitMax" name="limitMax"
                      required>
                  </div>
                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control bg-secondary-subtle" id="password" name="password"
                      required>
                  </div>
                  <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Save</button>
                  </div>
                </form>
              </div>
            </div>
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
  <script src="./demo/barChart.js"></script>
  <script src="./script/reload.js"></script>

  <!-- Tambahkan script di bagian bawah sebelum tag </body> -->
  <script>
  document.getElementById('limitForm').onsubmit = function(event) {
    event.preventDefault(); // Mencegah form dari pengiriman default

    // Mengambil nilai dari input
    const limitDown = document.getElementById('limitDown').value;
    const limitUp = document.getElementById('limitUp').value;
    const limitMax = document.getElementById('limitMax').value;
    const password = document.getElementById('password').value;

    // Membuat data untuk dikirim
    const formData = new FormData();
    formData.append('limitDown', limitDown);
    formData.append('limitUp', limitUp);
    formData.append('limitMax', limitMax);
    formData.append('password', password);

    // Mengirim data ke server
    fetch('http://192.168.189.186/SmartFlood/database/setLimits.php', { // Ganti dengan URL yang sesuai
        method: 'POST',
        body: formData
      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.text();
      })
      .then(data => {
        alert("Data berhasil disimpan!"); // Tambahkan alert ini
        fetchLimits(); // Panggil fetchLimits untuk memperbarui tampilan
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Failed to set limits: ' + error.message);
      });
  };


  function fetchLimits() {
    fetch('http://192.168.189.186/SmartFlood/database/getLimits.php') // Ganti dengan URL yang sesuai
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          console.error('Error:', data.error);
        } else {
          document.getElementById('limitDown').value = data.limitDown;
          document.getElementById('limitUp').value = data.limitUp;
          document.getElementById('limitMax').value = data.limitMax;
        }
      })
      .catch(error => {
        console.error('Error:', error);
      });
  }

  // Panggil fetchLimits saat halaman dimuat
  window.onload = fetchLimits;
  </script>



</body>

</html>