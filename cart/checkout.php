<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\cart\checkout.php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Checkout</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>

<body>
  <div class="container mt-5">
    <h1 class="text-center">Checkout</h1>
    <div class="row mt-4">
      <!-- Left Column: Preorder Date and Pickup Time -->
      <div class="col-md-6">
        <h3>Preorder Date & Pickup Time</h3>
        <form action="confirm_order.php" method="POST" class="mt-4">
          <div class="mb-3">
            <label for="preorderDate" class="form-label">Preorder Date</label>
            <input type="date" name="preorder_date" id="preorderDate" class="form-control" required>
          </div>
          <div class="mb-3">
            <label for="pickupTime" class="form-label">Pickup Time</label>
            <input type="time" name="pickup_time" id="pickupTime" class="form-control" required>
          </div>
          <div class="text-center mt-4 ">
            <button type="submit" class="btn btn-success">Confirm Order</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='../pages/product.php'">Cancel</button>
          </div>
        </form>
      </div>

      <!-- Right Column: Confirmation List -->
      <div class="col-md-6">
        <h3>Order Summary</h3>
        <table class="table table-bordered mt-4">
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                foreach ($_SESSION['cart'] as $item) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($item['product_name']) . '</td>';
                    echo '<td>' . htmlspecialchars($item['quantity']) . '</td>';
                    echo '<td>RM ' . htmlspecialchars($item['product_price'] * $item['quantity']) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3" class="text-center">Your cart is empty.</td></tr>';
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>