<?php
session_start();
include '../auth/db_connect.php';
include '../cart/calculate_item.php';

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
            <a class="nav-link custom-nav-text-active" href="product.php">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="contact.php">Contact</a>
          </li>
          <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
            <li class="nav-item">
              <a class="nav-link custom-nav-text" href="../admin/admin_dashboard.php">Admin</a>
            </li>
          <?php endif; ?>
        </ul>
        <div class="d-flex">
          <!-- Cart Dropdown -->
          <div class="dropdown ms-3 position-relative" id="cartDropdownContainer">
            <button class="btn btn-custom dropdown-toggle" type="button" id="cartDropdown" data-bs-toggle="dropdown"
              aria-expanded="false">
              Shopping Cart
              <?php if (isset($_SESSION['total_cart_items']) && $_SESSION['total_cart_items'] > 0): ?>
                <span class="position-absolute translate-middle badge rounded-pill bg-danger">
                  <?php echo $_SESSION['total_cart_items']; ?>
                </span>
              <?php endif; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="cartDropdown">
              <?php
              if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                foreach ($_SESSION['cart'] as $item) {
                  echo '<li class="dropdown-item">';
                  echo '<div class="d-flex justify-content-between">';
                  echo '<span>' . htmlspecialchars($item['product_name']) . '</span>';
                  echo '<span>RM ' . htmlspecialchars($item['product_price']) . '</span>';
                  echo '</div>';
                  echo '<div class="d-flex justify-content-between">';
                  echo '<small>Quantity: ' . htmlspecialchars($item['quantity']) . '</small>';
                  echo '<small>Total: RM ' . htmlspecialchars($item['product_price'] * $item['quantity']) . '</small>';
                  echo '</div>';
                  echo '</li>';
                }
                echo '<li><hr class="dropdown-divider"></li>';
                echo '<li class="text-center"><a href="../cart/cart.php" class="btn btn-primary btn-sm">View Cart</a></li>';
              } else {
                echo '<li class="dropdown-item text-center">Your cart is empty.</li>';
              }
              ?>
            </ul>
          </div>

          <!-- Profile Dropdown -->
          <?php if (isset($_SESSION['username'])): ?>
            <div class="dropdown">
              <button class="btn btn-custom dropdown-menu-dark dropdown-toggle" type="button" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $_SESSION['username']; ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="show_order.php">Show Order</a></li>
                <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a class="btn btn-outline-light mx-2" href="../auth/login.php">Login</a>
            <a class="btn btn-outline-light" href="../auth/register.php">Sign-Up</a>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </header>

  <article class="preorder-cover">
    <h1>Products</h1>
    <p>Explore our exclusive range of products available for preorder.</p>
  </article>
  <br>

  <div class="container">
    <?php
    $sql = "SELECT * FROM product"; // Fetch products from the database
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      echo '<div class="card-group" style="padding-left: 5rem;">';
      while ($row = $result->fetch_assoc()) {
        $imageData = base64_encode($row['product_image']);
        $imageSrc = 'data:image/jpeg;base64,' . $imageData;

        echo '<div class="card" style="width: 18rem; margin: 1rem;">';
        echo '<img src="' . $imageSrc . '" class="card-img-top img-thumbnail" alt="' . htmlspecialchars($row['product_name']) . '">';
        echo '<div class="card-body">';
        echo '<h4 class="card-title text-center">' . htmlspecialchars($row['product_name']) . '</h4>';
        echo '<p class="card-text text-center">Weight: ' . htmlspecialchars($row['product_weight']) . 'g Price: RM' . htmlspecialchars($row['product_price']) . '</p>';
        echo '<div class="text-center">';

        // Check if the user is logged in
        if (isset($_SESSION['username'])) {
          // Show the Add to Cart button with quantity selector if logged in
          echo '<form class="add-to-cart-form" method="POST">';
          echo "<input type='hidden' name='product_id' value='" . htmlspecialchars($row['product_id']) . "'>";
          echo "<input type='hidden' name='product_name' value='" . htmlspecialchars($row['product_name']) . "'>";
          echo "<input type='hidden' name='product_price' value='" . htmlspecialchars($row['product_price']) . "'>";
          echo '<div class="d-flex justify-content-center align-items-center mb-3">';
          echo '<button type="button" class="btn btn-secondary btn-sm quantity-decrease">-</button>';
          echo '<input type="number" name="quantity" value="1" min="1" class="form-control text-center mx-2 quantity-input" style="width: 60px;">';
          echo '<button type="button" class="btn btn-secondary btn-sm quantity-increase">+</button>';
          echo '</div>';
          echo '<button type="button" class="btn btn-primary add-to-cart-btn">Add to Cart</button>';
          echo '</form>';
        } else {
          // Redirect to login page if not logged in
          echo '<a href="../auth/login.php" class="btn btn-warning">Please Login First</a>';
        }

        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      echo '</div>';
    } else {
      echo '<p class="text-center">No products available.</p>';
    }
    ?>
  </div>
  <script src="../js/script.js"></script>

</body>

</html>