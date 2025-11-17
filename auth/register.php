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
<link rel="stylesheet" href="../css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</head>

<body>
    <header class="navbar navbar-expand-lg sticky-top custom-nav-bg px-5">
    <div class="container-fluid">
      <a class="navbar-brand custom-nav-text" href="../index.php">WongKokSeng Wholesale</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
            <a class="nav-link custom-nav-text-active" href="../pages/contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="../pages/preorder.php">Preorder</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="../admin/adminPanel.php">Admin</a>
          </li>
        </ul>
        <div class="d-flex">
          <?php if (isset($_SESSION['username'])): ?>
            <div class="dropdown">
              <button class="btn btn-custom dropdown-menu-dark dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                Welcome, <?php echo $_SESSION['username']; ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="show_order.php">Show Order</a></li>
                <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a class="btn btn-outline-primary mx-2" href="../auth/login.php">Login</a>
            <a class="btn btn-outline-primary" href="../auth/login.php">Sign-Up</a>
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

  <form class="login-form" action="register.php" method="POST">
      <div class="login-container">
          <a>Username</a>
          <input type="text" name="username" placeholder="Username" required>
          <a>Phone Number</a>
          <input type="text" name="phone" placeholder="Phone Number" required>
          <a>Password</a>
          <input type="password" name="password" placeholder="Password" required>
          <a>Confirm Password</a>
          <input type="password" name="confirm_password" placeholder="Confirm Password" required>
          <button type="submit">Register</button>
          <a>Already have an account? <a href="login.php">Login Here</a></a>
      </div>
  </form>
</body>

</html>