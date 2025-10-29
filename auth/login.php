<?php
include 'db_connect.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['message'] = "Login successful!";
            $_SESSION['message_type'] = "success";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['message'] = "Invalid password.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "No user found with that username.";
        $_SESSION['message_type'] = "error";
    }

    header("Location: login.php");
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
  <nav class="navTop">
    <a href="../index.php">WongKokSeng Wholesale</a>
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="../pages/product.php">Product</a></li>
      <li><a href="../pages/contact.php">Contact</a></li>
      <li><a href="../pages/preorder.php">Preorder</a></li>
      <li><a href="../admin/adminPanel.php">Admin</a></li>
    </ul>
    <a class="login-active" href="../auth/login.php">Login / Register</a>
  </nav>

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

  <form class="login-form" method="POST" action="login.php">
      <div class="login-container">
          <a>Username</a>
          <input type="text" name="username" placeholder="Username" required>
          <a>Password</a>
          <input type="password" name="password" placeholder="Password" required>
          <button type="submit">Login</button>
          <a>Haven't signed in? <a href="register.php">Register Here</a></a>
      </div>
  </form>
</body>

</html>