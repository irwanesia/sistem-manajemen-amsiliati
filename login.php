
<?php
// require_once "helpers/functions_helper.php";
// $password = password_hash('123', PASSWORD_BCRYPT);
// // Kemudian gunakan $password dalam query INSERT

// global $pdo;
// $query = "INSERT INTO users (username, `password`) VALUES ('admin', '$password')";
// $statement = $pdo->prepare($query);
// return $statement->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Sistem Informasi Pengelolaan Manajemen Amsiliati</title>
  <link rel="stylesheet" href="assets/css/main/app.css">
  <link rel="stylesheet" href="assets/css/pages/auth.css">
  <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
  <style>
    body{
      background-color: #EFE5E5;
    }

    .sidebar_bg {
      background-color: #C96673;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="row w-100 m-0">
        <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
          <div class="card col-lg-4 mx-auto" style="margin-top: 100px;">
            <h3 class="text-center mt-4">Login</h3>
            <div class="card-body px-5 pb-5">
              <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-warning mb-4" id="alert-message" role="alert">
                  <?php echo $_GET['message']; ?>
                </div>
              <?php endif; ?>
              <!-- <h3 class="card-title text-left mb-3">Login</h3> -->
              <form action="controllers/loginController.php" method="post">
                <div class="form-group">
                  <label>Username *</label>
                  <input type="text" name="username" class="form-control p_input" placeholder="username">
                </div>
                <div class="form-group">
                  <label>Password *</label>
                  <input type="password" name="password" class="form-control p_input" placeholder="********">
                </div>
                <div class="text-center mt-4">
                  <button type="submit" name="login" class="btn text-dark sidebar-bg btn-block enter-btn w-100" style="background-color: #C96673;">Login</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <script>
    // scripts.js
    document.addEventListener('DOMContentLoaded', function() {
      // Dapatkan elemen alert
      var alertElement = document.getElementById('alert-message');

      // Set timer untuk menyembunyikan alert setelah 5 detik (5000 milidetik)
      setTimeout(function() {
        alertElement.classList.add('d-none');
      }, 6000);
    });
  </script>
</body>

</html>