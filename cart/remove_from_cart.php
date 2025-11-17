<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\pages\remove_from_cart.php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = $_POST['index'];

    // Remove the item from the cart
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]);
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array
    }

    // Redirect back to the cart page
    header('Location: cart.php');
    exit();
}