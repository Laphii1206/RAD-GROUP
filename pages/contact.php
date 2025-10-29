<?php
include __DIR__ . '/../auth/db_connect.php';
session_start();
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
    <a href="index.php">WongKokSeng Wholesale</a>
    <ul>
      <li><a href="../index.php" >Home</a></li>
      <li><a href="product.php">Product</a></li>
      <li><a href="contact.php" class="active">Contact</a></li>
      <li><a href="preorder.php">Preorder</a></li>
      <li><a href="adminPanel.php">Admin</a></li>
    </ul>
     <?php if (isset($_SESSION['username'])): ?>
      <span class="welcome-message">Welcome, <?php echo $_SESSION['username']; ?>!</span>
      <a class="logout" href="../auth/logout.php">Logout</a>
    <?php else: ?>
      <a class="login" href="../auth/login.php">Login / Register</a>
    <?php endif; ?>
  </nav>
</body>

</html>