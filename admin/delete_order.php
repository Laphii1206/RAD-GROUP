<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\admin\delete_order.php
session_start();
include '../auth/db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];

    // Delete related order items first (if applicable)
    $sql = "DELETE FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // Delete the order
    $sql = "DELETE FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Order deleted successfully.";
    } else {
        $_SESSION['message'] = "Failed to delete order.";
    }

    // Redirect back to the admin dashboard
    header("Location: order_controller.php");
    exit();
}
?>