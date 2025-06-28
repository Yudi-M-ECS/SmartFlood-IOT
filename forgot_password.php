<!-- forgot_password.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container h-100 ">
    <div class="row d-flex justify-content-center align-items-center h-100 ">
      <div class="col-12 col-md-6 col-lg-4 m-auto">
        <!-- Form Forgot Password -->
        <div class="shadow p-3 rounded-4 bg-white" style="margin-top: 5rem">
          <h4 class="text-center text-primary fw-bold py-2">Smart Flood Monitoring</h4>
          <h4 class="text-center">Forgot Password</h4>
          <form action="404.php" method="POST">
            <div class="mb-3">
              <label for="email" class="form-label">Enter your email</label>
              <input type="email" class="form-control" name="email" id="email" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Send Reset Link</button>
          </form>
          <p class="text-center mt-3"><a href="login.php">Back to Login</a></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>