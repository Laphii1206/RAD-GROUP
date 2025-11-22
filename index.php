<?php
session_start();
include 'auth/db_connect.php';
include 'cart/calculate_item.php';

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
  <script src="/js/script.js"></script>
</head>

<body>
  <header class="navbar navbar-expand-lg sticky-top custom-nav-bg px-5">
    <div class="container-fluid">
      <a class="navbar-brand custom-nav-text" href="index.php">WongKokSeng Wholesale</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
          <li class="nav-item">
            <a class="nav-link custom-nav-text-active" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="pages/product.php">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="pages/contact.php">Contact</a>
          </li>
          <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
            <li class="nav-item">
              <a class="nav-link custom-nav-text" href="admin/admin_dashboard.php">Admin</a>
            </li>
          <?php endif; ?>
        </ul>
        <div class="d-flex">
          <!-- Cart Dropdown -->
          <div class="dropdown ms-3 position-relative" id="cartDropdownContainer">
            <!-- Cart Name with Notification Badge -->
            <span class="btn btn-custom position-relative" id="cartDropdown">
              Shopping Cart
              <?php if (isset($_SESSION['total_cart_items']) && $_SESSION['total_cart_items'] > 0): ?>
                <span class="position-absolute translate-middle badge rounded-pill bg-danger"
                  style="transform: translate(-50%, -50%);">
                  <?php echo $_SESSION['total_cart_items']; ?>
                </span>
              <?php endif; ?>
            </span>
            <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="cartDropdown" style="width: 300px;">
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
                echo '<li class="text-center"><a href="cart/cart.php" class="btn btn-primary btn-sm">View Cart</a></li>';
              } else {
                echo '<li class="dropdown-item text-center">Your cart is empty.</li>';
              }
              ?>
            </ul>
          </div>
          <?php if (isset($_SESSION['username'])): ?>
            <div class="dropdown">
              <button class="btn btn-custom dropdown-menu-dark dropdown-toggle" type="button" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $_SESSION['username']; ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="pages/show_order.php">Show Order</a></li>
                <li><a class="dropdown-item" href="auth/logout.php">Logout</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a class="btn btn-outline-light mx-2" href="auth/login.php">Login</a>
            <a class="btn btn-outline-light" href="auth/login.php">Sign-Up</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>


  <div class="container main-layout">
    <div class="welcome-box">
      <h2>Welcome to WongKokSeng Wholesale!</h2>
      <p>We make wholesale preordering simple, fast, and reliable. Explore our product, place orders in just a few
        clicks, and enjoy a seamless experience.</p>
      <p>Get start now to browse our latest items.</p>

      <a class="welcome-btn" href="pages/product.php">Preorder Now</a>
    </div>

    <div class="right-section">
      <div class="top-banner">
        <img src="https://arisu.s-ul.eu/j9jTV2gK" alt="Store Image">
      </div>

      <div class="products-container">


        <?php
        // Fetch 2 random products from the database
        $sql = "SELECT * FROM product ORDER BY RAND() LIMIT 2";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $imageData = base64_encode($row['product_image']);
            $imageSrc = 'data:image/jpeg;base64,' . $imageData;
            ?>
            <a href="pages/product.php" class="product-box">
              <img src="<?= $imageSrc ?>" alt="Product Image">
              <h3><?= htmlspecialchars($row['product_name']) ?></h3>
              <p class="price">RM <?= htmlspecialchars($row['product_price']) ?> /
                <?= htmlspecialchars($row['product_weight']) ?>g
              </p>
            </a>
            <?php
          }
        }
        ?>

      </div>
    </div>
  </div>
  <script src="js/script.js"></script>

</body>

</html>