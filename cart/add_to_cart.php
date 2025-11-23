<?php
// filepath: c:\xampp\htdocs\RAD-GROUP\cart\add_to_cart.php
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate incoming data
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : null;
    $product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : null;
    $product_price = isset($_POST['product_price']) ? floatval($_POST['product_price']) : null;

    // Ensure all required fields are provided
    if (!$product_id || !$product_name || !$product_price) {
        echo json_encode(['success' => false, 'message' => 'Invalid product data.']);
        exit();
    }

    // Initialize the cart if it doesn't exist
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

    // Prepare the cart items for the response
    $cart_items = [];
    foreach ($_SESSION['cart'] as $item) {
        $cart_items[] = [
            'product_name' => $item['product_name'],
            'product_price' => $item['product_price'],
            'quantity' => $item['quantity'],
            'total_price' => $item['product_price'] * $item['quantity']
        ];
    }

    // Return a JSON response
    echo json_encode([
        'success' => true,
        'total_cart_items' => $_SESSION['total_cart_items'],
        'cart_items' => $cart_items
    ]);
    exit();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit();
}
?>