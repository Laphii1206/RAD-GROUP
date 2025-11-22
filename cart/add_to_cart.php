<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\pages\add_to_cart.php
session_start();
include '../auth/db_connect.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Check if the cart exists in the session
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the product is already in the cart
    if (isset($_SESSION['cart'][$product_id])) {
        // Increment the quantity if the product already exists
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        // Add the product to the cart
        $_SESSION['cart'][$product_id] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'quantity' => 1
        ];
    }

    // Update the total cart items
    $_SESSION['total_cart_items'] = array_sum(array_column($_SESSION['cart'], 'quantity'));

    // Return a JSON response
    echo json_encode([
        'success' => true,
        'total_cart_items' => $_SESSION['total_cart_items']
    ]);
    exit();
} else {
    echo json_encode(['success' => false]);
    exit();
}
?>