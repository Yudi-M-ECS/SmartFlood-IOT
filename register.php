<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registration Form</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css" />
</head>

<body>

  <body>
    <div class="container vh-100 d-flex justify-content-center align-items-center">
      <div class="row">
        <div class="col-12 col-md-8 col-lg-6">
          <div class="registration-container p-4 border rounded">
            <h3 class="text-center text-primary fw-bold py-2">Smart Flood Monitoring</h3>
            <h4 class="text-center mb-4">Register</h4>
            <form action="./database/registrasi.php" method="POST" id="registerForm">
              <div class="mb-3">
                <label for="fullname" class="form-label">Full Name</label>
                <input type="text" class="form-control" name="fullname" id="fullname" required />
              </div>
              <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" name="age" id="age" required min="1" max="120" />
              </div>
              <div class="mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-control" name="gender" id="gender" required>
                  <option value="">Select Gender</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                  <option value="Other">Other</option>
                </select>
              </div>
              <div class="mb-3">
                <label for="number_phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" name="number_phone" id="number_phone" required />
              </div>
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" required />
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" required />
              </div>
              <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required />
              </div>
              <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="terms" required />
                <label class="form-check-label" for="terms">I agree to the terms and conditions</label>
              </div>
              <button type="submit" class="btn btn-primary w-100">Register</button>
            </form>
            <p class="text-center mt-3">Already have an account? <a href="login.php">Login here</a></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>


  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>