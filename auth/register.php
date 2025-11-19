<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $phone = $_POST['phone'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  if ($password === $confirmPassword) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, phone_number, password) VALUES ('$username', '$phone', '$hashedPassword')";
    if ($conn->query($sql) === TRUE) {
      $_SESSION['message'] = "Registration successful!";
      $_SESSION['message_type'] = "success";
    } else {
      $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
      $_SESSION['message_type'] = "error";
    }
  } else {
    $_SESSION['message'] = "Passwords do not match.";
    $_SESSION['message_type'] = "error";
  }

  header("Location: register.php");
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WongKokSeng Wholesale</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">

  <link href="../css/style.css" rel="stylesheet">
</head>

<body>
  <header class="navbar navbar-expand-lg sticky-top custom-nav-bg px-5">
    <div class="container-fluid">
      <a class="navbar-brand custom-nav-text" href="../index.php">WongKokSeng Wholesale</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="../pages/product.php">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="../pages/contact.php">Contact</a>
          </li>
        </ul>
        <div class="d-flex">
          <?php if (isset($_SESSION['username'])): ?>
            <div class="dropdown">
              <button class="btn btn-custom dropdown-menu-dark dropdown-toggle" type="button" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                Welcome, <?php echo $_SESSION['username']; ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="show_order.php">Show Order</a></li>
                <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
              </ul>
            </div>
          <?php else: ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>
  <!-- Display Message -->
  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['message_type'] === 'success' ? 'success' : 'danger'; ?> text-center">
      <?php
      echo $_SESSION['message'];
      unset($_SESSION['message']); // Clear the message after displaying
      unset($_SESSION['message_type']);
      ?>
    </div>
  <?php endif; ?>

  <section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card bg-dark text-white" style="border-radius: 1rem;">
            <div class="card-body p-5 text-center">

              <div class="mb-md-5 mt-md-4 pb-5">
                <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                <p class="text-white-50 mb-5">Please enter your details</p>

                <!-- Login Form -->
                <form action="register.php" method="POST">
                  <div class="form-outline form-white mb-4">
                    <input type="text" id="username" name="username" class="form-control form-control-lg" required />
                    <label class="form-label" for="username">Username</label>
                  </div>
                  <div class="form-outline form-white mb-4">
                    <input type="text" id="phone-number" name="phone" class="form-control form-control-lg" required />
                    <label class="form-label" for="phone-number">Phone Number</label>
                  </div>

                  <div class="form-outline form-white mb-4">
                    <input type="password" id="password" name="password" class="form-control form-control-lg"
                      required />
                    <label class="form-label" for="password">Password</label>
                  </div>

                  <div class="form-outline form-white mb-4">
                    <input type="password" id="confirm-password" name="confirm_password"
                      class="form-control form-control-lg" required />
                    <label class="form-label" for="confirm-password">Confirmed Password</label>
                  </div>

                  <button class="btn btn-outline-light btn-lg px-5" type="submit">Register</button>
                </form>
              </div>

              <div>
                <p class="mb-0">have an account? <a href="../auth/login.php" class="text-white-50 fw-bold">Log
                    In</a>
                </p>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
  <script src="../js/script.js"></script>

</body>

</html>