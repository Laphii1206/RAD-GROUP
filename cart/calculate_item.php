<?php
$sql = "SELECT * FROM product";
$result = $conn->query($sql);

// Calculate the total number of items in the cart
$_SESSION['total_cart_items'] = 0; // Initialize the session variable
if (isset($_SESSION['cart'])) {
  foreach ($_SESSION['cart'] as $item) {
    $_SESSION['total_cart_items'] += $item['quantity'];
  }
}
?>