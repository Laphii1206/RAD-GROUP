<?php
// filepath: c:\xampp\htdocs\RAD-GROUP\admin\viewOrderDetails.php
session_start();
include '../auth/db_connect.php';

// Check if 'id' is provided in the URL
if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);

    // Fetch order details from the database
    $sql = "SELECT * FROM orders WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
    } else {
        $_SESSION['message'] = "Order not found.";
        header("Location: order_controller.php");
        exit;
    }

    // Fetch order items from the database
    $item_sql = "SELECT * FROM order_item WHERE order_id = ?";
    $item_stmt = $conn->prepare($item_sql);
    $item_stmt->bind_param("i", $order_id);
    $item_stmt->execute();
    $item_result = $item_stmt->get_result();
} else {
    $_SESSION['message'] = "Invalid order ID.";
    header("Location: order_controller.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Order Details</h1>
        <table class="table table-bordered">
            <tr>
                <th>Order ID</th>
                <td><?= htmlspecialchars($order['order_id']) ?></td>
            </tr>
            <tr>
                <th>Username</th>
                <td><?= htmlspecialchars($order['user_name']) ?></td>
            </tr>
            <tr>
                <th>Total Amount</th>
                <td>RM<?= htmlspecialchars($order['total_amount']) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?= htmlspecialchars($order['status']) ?></td>
            </tr>
            <tr>
                <th>Created At</th>
                <td><?= htmlspecialchars($order['created_at']) ?></td>
            </tr>
        </table>

        <h2 class="mt-4">Order Items</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($item = $item_result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['order_item_id']) ?></td>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td><?= htmlspecialchars($item['quantity']) ?></td>
                        <td>RM<?= htmlspecialchars($item['price']) ?></td>
                        <td>RM<?= htmlspecialchars($item['quantity'] * $item['price']) ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <a href="order_controller.php" class="btn btn-primary">Back to Orders</a>
    </div>
</body>

</html>