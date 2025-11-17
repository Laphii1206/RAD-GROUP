<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\cart\update_cart_live.php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];
    $quantity = $_POST['quantity'];

    // Ensure the quantity is at least 1
    if ($quantity < 1) {
        $quantity = 1;
    }

    // Update the quantity in the cart
    if (isset($_SESSION['cart'][$index])) {
        $_SESSION['cart'][$index]['quantity'] = $quantity;

        // Calculate the total for the updated item
        $item_total = $_SESSION['cart'][$index]['product_price'] * $quantity;

        // Return the updated total as JSON
        echo json_encode(['item_total' => $item_total]);
        exit();
    }
}