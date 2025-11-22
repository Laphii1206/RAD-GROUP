<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\pages\order_confirmation.php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Order Confirmation</h1>
        <div class="alert alert-success text-center mt-4">
            <?php
            if (isset($_SESSION['message'])) {
                echo htmlspecialchars($_SESSION['message']);
                unset($_SESSION['message']);
            } else {
                echo "Your order has been placed successfully! We will contact you soon.";
            }
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="../pages/product.php" class="btn btn-primary">Continue Shopping</a>
        </div>
    </div>
</body>

</html>