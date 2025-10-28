<?php
$conn = new mysqli("localhost", "laphii", "laphii123", "wks");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT * FROM product";
$result = $conn->query($sql);



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
    <a href="index.html">WongKokSeng Wholesale</a>
    <ul>
      <li><a href="index.html">Home</a></li>
      <li><a href="product.php" class="active ">Product</a></li>
      <li><a href="contact.html">Contact</a></li>
      <li><a href="preorder.html">Preorder</a></li>
    </ul>
    <a class="login" href="login.html">Login / Register</a>

  </nav>

  <article class="preorder-cover">
    <h1>Preorder Products</h1>
    <p>Explore our exclusive range of products available for preorder.</p>
  </article>
  <br>

  <div class="card-group" style="width: 18rem;">
   <?php if ($result->num_rows > 0): ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <div class="card" style="width: 18rem;">
          <img src="./images/<?php echo htmlspecialchars($row['product_image']); ?>" class="card-img-top" alt="Product Image">
          <div class="card-body">
            <h4 class="card-title text-center"><?php echo htmlspecialchars($row['product_name']); ?></h4>
            <p class="card-text text-center">Size: <?php echo htmlspecialchars($row['product_weight']); ?> Price: RM<?php echo htmlspecialchars($row['product_price']); ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="text-center">No products available.</p>
    <?php endif; ?>
    <?php $conn->close(); ?>
  </div>
</div>


</body>

</html>