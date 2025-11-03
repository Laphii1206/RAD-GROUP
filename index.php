<?php
include __DIR__ . '/auth/db_connect.php';
session_start();
<<<<<<< Updated upstream
?>

=======

if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE id = '$userId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}

?>


>>>>>>> Stashed changes
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
  <script src="/js/script.js"></script>
</head>


<body>
  <nav class="navTop">
    <a href="index.php">WongKokSeng Wholesale</a>
    <ul>
      <li><a href="index.php" class="active">Home</a></li>
      <li><a href="pages/product.php">Product</a></li>
      <li><a href="pages/contact.php">Contact</a></li>
      <li><a href="pages/preorder.php">Preorder</a></li>
      <li><a href="admin/adminPanel.php">Admin</a></li>
    </ul>
     <?php if (isset($_SESSION['username'])): ?>
      <span class="welcome-message">Welcome, <?php echo $_SESSION['username']; ?>!</span>
      <a class="logout" href="auth/logout.php">Logout</a>
    <?php else: ?>
      <a class="login" href="auth/login.php">Login / Register</a>
    <?php endif; ?>
  </nav>
<<<<<<< Updated upstream
=======

  <?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-<?php echo $_SESSION['message_type'] === 'success' ? 'success' : 'danger'; ?> text-center">
        <?php
        echo $_SESSION['message'];
        unset($_SESSION['message']); 
        unset($_SESSION['message_type']);
        ?>
    </div>
  <?php endif; ?>

  </nav>

>>>>>>> Stashed changes
</body>

</html>