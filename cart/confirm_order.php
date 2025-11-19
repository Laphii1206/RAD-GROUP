<?php
session_start();
include '../auth/db_connect.php';

// Get the user ID
$user_id = $_SESSION['user_id'];

// Get the form data
$preorder_date = $_POST['preorder_date'];
$pickup_time = $_POST['pickup_time'];

// Calculate the total amount
$total_amount = 0;
if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $item) {
        $total_amount += $item['product_price'] * $item['quantity'];
    }
} else {
    $_SESSION['message'] = "Your cart is empty.";
    header("Location: checkout.php");
    exit();
}

// Insert the order into the `order` table
$status = 'pending'; // Default status
$sql = "INSERT INTO `orders` (user_id, total_amount, status, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ids", $user_id, $total_amount, $status);
$stmt->execute();

// Get the last inserted order ID
$order_id = $stmt->insert_id;

// Insert each item into the `order_item` table
$sql = "INSERT INTO `order_item` (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

foreach ($_SESSION['cart'] as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $price = $item['product_price'];
    $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
    $stmt->execute();
}

// Clear the cart
unset($_SESSION['cart']);
unset($_SESSION['total_cart_items']);

// Redirect to a confirmation page
$_SESSION['message'] = "Your order has been placed successfully!";
header("Location: order_confirmation.php");
exit();
?>