<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Form</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" /> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="stylesheet" href="style.css" />
</head>

<body>
  <div class="container h-80 ">
    <div class="row d-flex justify-content-center align-items-center h-80 ">
      <div class="col-10 col-md-6 col-lg-4 m-auto">
        <!-- Membatasi lebar form pada ukuran layar tertentu -->
        <div class="login-container shadow p-3 rounded-4 bg-white" style="margin-top: 5rem">
          <h4 class="text-center text-primary fw-bold py-2">Smart Flood Monitoring</h4>
          <h4 class="text-center">Login</h4>
          <form action="./database/login.php" method="POST" id="loginForm">
            <div class="mb-3">
              <label for="email" class="form-label">Email address</label>
              <input type="email" class="form-control" name="email" id="email" required />
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="password" required />
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="rememberMe" />
              <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
          </form>
          <!-- <p class="text-center mt-3">
            <a href="forgot_password.php">Forgot your password?</a>
          </p> -->
          <p class="text-center p-3">Don't have an account? <a href="register.php">Sign up</a></p>
        </div>
      </div>
    </div>
  </div>
  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>