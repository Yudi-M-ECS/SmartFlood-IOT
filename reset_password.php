<!-- reset_password.php -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
  <div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-6 col-lg-4 m-auto">
        <!-- Form Reset Password -->
        <div class="shadow p-3 rounded-4 bg-white" style="margin-top: 5rem">
          <h4 class="text-center">Reset Password</h4>
          <form action="process_reset.php" method="POST">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>" />
            <div class="mb-3">
              <label for="password" class="form-label">New Password</label>
              <input type="password" class="form-control" name="password" id="password" required />
            </div>
            <div class="mb-3">
              <label for="confirm_password" class="form-label">Confirm New Password</label>
              <input type="password" class="form-control" name="confirm_password" id="confirm_password" required />
            </div>
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>