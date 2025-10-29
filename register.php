<?php
include 'db_connect.php';
session_start(); // Start the session to store messages

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
            $_SESSION['message_type'] = "success"; // Store message type for styling
        } else {
            $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Passwords do not match.";
        $_SESSION['message_type'] = "error";
    }

    // Redirect to the same page to refresh
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
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</head>

<body>
  <nav class="navTop">
    <a href="index.php">WongKokSeng Wholesale</a>
    <ul>
      <li><a href="index.php" class="active">Home</a></li>
      <li><a href="product.php">Product</a></li>
      <li><a href="contact.php">Contact</a></li>
      <li><a href="preorder.php">Preorder</a></li>
      <li><a href="adminPanel.php">Admin</a></li>
    </ul>
    <a class="login" href="login.php">Login / Register</a>
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