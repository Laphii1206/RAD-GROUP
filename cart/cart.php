<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\cart\cart.php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shopping Cart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
</head>

<body>
  <div class="container mt-5">
    <h1 class="text-center">Your Cart</h1>
    <table class="table table-bordered mt-4">
      <thead>
        <tr>
          <th style="width: 30%;">Product Name</th>
          <th style="width: 15%;">Price</th>
          <th style="width: 15%;">Quantity</th>
          <th style="width: 20%;">Total</th>
          <th style="width: 20%;">Action</th>
        </tr>
      </thead>
      <tbody id="cart-items">
        <?php
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            foreach ($_SESSION['cart'] as $index => $item) {
                echo '<tr data-index="' . $index . '">';
                echo '<td style="width: 30%;">' . $item['product_name'] . '</td>';
                echo '<td style="width: 15%;">RM ' . $item['product_price'] . '</td>';
                echo '<td style="width: 15%;">';
                echo '<input type="number" name="quantity" value="' . $item['quantity'] . '" min="1" class="form-control quantity-input" style="width: 80px;" data-index="' . $index . '">';
                echo '</td>';
                echo '<td class="item-total" style="width: 20%;">RM ' . ($item['product_price'] * $item['quantity']) . '</td>';
                echo '<td style="width: 20%;">';
                echo '<form action="remove_from_cart.php" method="POST" style="display:inline;">';
                echo '<input type="hidden" name="index" value="' . $index . '">';
                echo '<button type="submit" class="btn btn-danger btn-sm">Remove</button>';
                echo '</form>';
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5" class="text-center">Your cart is empty.</td></tr>';
        }
        ?>
      </tbody>
    </table>
    <div class="text-center mt-4">
      <a href="../pages/product.php" class="btn btn-primary">Continue Shopping</a>
        <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      // Listen for changes in the quantity input
      $('.quantity-input').on('input', function () {
        const index = $(this).data('index'); // Get the product index
        const quantity = $(this).val(); // Get the new quantity

        // Send an AJAX request to update the cart
        $.ajax({
          url: 'update_cart.php', // The server-side script to handle the update
          method: 'POST',
          data: { index: index, quantity: quantity },
          success: function (response) {
            // Parse the JSON response
            const data = JSON.parse(response);

            // Update the total for the item
            $(`tr[data-index="${index}"] .item-total`).text('RM ' + data.item_total);

            // Optionally, you can update other parts of the cart (e.g., grand total)
          },
          error: function () {
            alert('Failed to update the cart. Please try again.');
          }
        });
      });
    });
  </script>
</body>

</html>