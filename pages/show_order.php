<?php
session_start();
include '../auth/db_connect.php';
include '../cart/calculate_item.php';

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
  header("Location: ../auth/login.php");
  exit();
}

// Fetch user orders from the database
$username = $_SESSION['username'];
$sql = "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Order History - WongKokSeng Wholesale</title>
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
            <a class="nav-link custom-nav-text" href="product.php">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="contact.php">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="preorder.php">Preorder</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="../admin/admin_dashboard.php">Admin</a>
          </li>
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

  <div class="container mt-5">
    <h1 class="text-center">Order History</h1>
    <div class="accordion mt-4" id="orderAccordion">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <div class="accordion-item">
            <h2 class="accordion-header" id="heading<?php echo $row['order_id']; ?>">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                data-bs-target="#collapse<?php echo $row['order_id']; ?>" aria-expanded="false"
                aria-controls="collapse<?php echo $row['order_id']; ?>">
                Order #<?php echo $row['order_id']; ?> - <?php echo $row['order_date']; ?>
              </button>
            </h2>
            <div id="collapse<?php echo $row['order_id']; ?>" class="accordion-collapse collapse"
              aria-labelledby="heading<?php echo $row['order_id']; ?>" data-bs-parent="#orderAccordion">
              <div class="accordion-body">
                <p><strong>Order ID:</strong> <?php echo $row['order_id']; ?></p>
                <p><strong>Date:</strong> <?php echo $row['order_date']; ?></p>
                <p><strong>Total Amount:</strong> RM <?php echo $row['total_amount']; ?></p>
                <p><strong>Status:</strong> <?php echo $row['status']; ?></p>
                <hr>
                <h5>Items:</h5>
                <ul>
                  <?php
                  $order_id = $row['order_id'];
                  $item_sql = "SELECT * FROM order_items WHERE order_id = ?";
                  $item_stmt = $conn->prepare($item_sql);
                  $item_stmt->bind_param("i", $order_id);
                  $item_stmt->execute();
                  $item_result = $item_stmt->get_result();
                  while ($item = $item_result->fetch_assoc()) {
                    echo '<li>' . htmlspecialchars($item['product_name']) . ' - Quantity: ' . $item['quantity'] . ' - Price: RM ' . $item['price'] . '</li>';
                  }
                  ?>
                </ul>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center">You have no orders.</p>
      <?php endif; ?>
    </div>
  </div>
  <script src="../js/script.js"></script>
</body>

</html>