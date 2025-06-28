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
    $success_message = '';
    $errors = [];

    // Ambil data pengguna dari database
    $query = "SELECT * FROM registrasi WHERE id = ?";
    $stmt = $koneksi->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Memproses pembaruan informasi jika form disubmit
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_email = $_POST['email'];
        $new_password = $_POST['new_password'];

        // Validasi format email
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Format email tidak valid.";
        }

        // Memperbarui email
        if (empty($errors)) {
            $query = "UPDATE registrasi SET email = ? WHERE id = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("si", $new_email, $user_id);
            $stmt->execute();
        }

        // Memperbarui password jika diberikan
        if (empty($errors) && !empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); // Hash password baru
            $query = "UPDATE registrasi SET password = ? WHERE id = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("si", $hashed_password, $user_id);
            $stmt->execute();
        }

        if (empty($errors)) {
            $success_message = "Informasi berhasil diperbarui!";
        }
    }
  ?>

  <div class="wrapper d-flex">
    <!-- Sidebar -->
    <aside id="sidebar" class="js-sidebar">
      <div class="h-100 container-sidebar">
        <div class="sidebar-logo p-4">
          <a href="index.php">Smart Flood</a>
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
            <span class="ms-2 d-none d-md-inline fs-5">Profil</span>
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
                  <li><a class="dropdown-item" href="./database/logout.php">Logout</a></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <!-- Content Area -->
      <main class="content px-4 overflow-auto" id="content" style="padding-top: 5rem; padding-bottom: 3rem">
        <div class="d-flex flex-column flex-md-row gap-5 h-100">
          <!-- Profile Card -->
          <div class="rounded-5 d-flex flex-column align-items-center p-5 shadow" style="background-color: #11009e;">
            <img src="<?php echo htmlspecialchars(str_replace('../', '', $user['profile_image'])); ?>"
              class=" img-fluid rounded-circle border border-3"
              style="width: 150px; height: 150px; object-fit: cover;" />
            <h3 class="text-white  text-center py-3"><?php echo htmlspecialchars($user['fullname']);?></h3>

            <div class="card-profil my-1 w-100">
              <a href="profil.php"
                class="d-flex align-items-center justify-content-center bg-white py-2 px-3 rounded-4 fs-6 text-decoration-none text-center"
                style="color: #11009e">
                <i class="lni lni-user me-2"></i>
                <span>Personal Information</span>
              </a>
            </div>

            <div class="card-profil my-3 w-100">
              <a href="login_n_pass.php"
                class="d-flex align-items-center justify-content-center bg-white py-2 px-3 rounded-4 fs-6 text-decoration-none text-center"
                style="color: #11009e">
                <i class="lni lni-lock-alt me-2"></i>
                <span>Login & Password</span>
              </a>
            </div>

            <div class="card-profil my-3 w-100">
              <a href="./database/logout.php"
                class="d-flex align-items-center justify-content-center bg-white py-2 px-3 rounded-4 fs-6 text-decoration-none text-center"
                style="color: #11009e">
                <i class="lni lni-exit me-2"></i>
                <span>Logout</span>
              </a>
            </div>
          </div>


          <!-- Personal Information Card -->
          <div class="container card-info flex-grow-1 p-4 bg-white shadow rounded-5">
            <h3>Login Information</h3>
            <!-- Tampilkan pesan sukses jika ada -->
            <?php if (!empty($success_message)): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <?php echo htmlspecialchars($success_message); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <!-- Tampilkan pesan error jika ada -->
            <?php if (!empty($errors)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <ul>
                <?php foreach ($errors as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>
            <form action="login_n_pass.php" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Username</label>
                <input type="text" name="email" class="form-control" id="email"
                  value="<?php echo htmlspecialchars($user['email']); ?>" required />
              </div>

              <div class="mb-3">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" name="new_password" class="form-control" id="new_password"
                  placeholder="Password Baru" />
                <small class="form-text text-muted">Leave blank to retain the current password..</small>
              </div>

              <button type="submit" class="btn btn-primary">update information</button>
            </form>
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
  <script src="./script/file_Input.js"></script>
</body>

</html>