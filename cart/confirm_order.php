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

// Fetch the user_name from the database
$sql_user = "SELECT username FROM user WHERE user_id = ?";
$stmt_user = $conn->prepare($sql_user);
$stmt_user->bind_param("i", $user_id);
$stmt_user->execute();
$result_user = $stmt_user->get_result();
$user = $result_user->fetch_assoc();
$user_name = $user['username'];

// Insert the order into the `orders` table
$sql = "INSERT INTO `orders` (user_id, user_name, total_amount, created_at) VALUES (?, ?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isd", $user_id, $user_name, $total_amount);
$stmt->execute();

// Get the last inserted order ID
$order_id = $stmt->insert_id;

// Insert each item into the `order_item` table
$sql = "INSERT INTO `order_item` (order_id, product_id, product_name, quantity, price) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

foreach ($_SESSION['cart'] as $item) {
    $product_id = $item['product_id'];
    $quantity = $item['quantity'];
    $price = $item['product_price'];

    // Fetch the product name from the database
    $sql_product = "SELECT product_name FROM product WHERE product_id = ?";
    $stmt_product = $conn->prepare($sql_product);
    $stmt_product->bind_param("i", $product_id);
    $stmt_product->execute();
    $result_product = $stmt_product->get_result();
    $product = $result_product->fetch_assoc();
    $product_name = $product['product_name'];

    // Insert the item into the `order_item` table
    $stmt->bind_param("iisis", $order_id, $product_id, $product_name, $quantity, $price);
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