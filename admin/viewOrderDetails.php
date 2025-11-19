<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\admin\viewOrderDetails.php
session_start();
include '../auth/db_connect.php';

// Check if the order ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['message'] = "No order ID provided.";
    header("Location: show_order.php");
    exit();
}

$order_id = $_GET['id'];

// Fetch the order details
$sql = "SELECT o.order_id, o.user_name, o.total_amount, o.status, o.created_at, u.username 
        FROM `orders` o
        JOIN `user` u ON o.user_name = u.user_id
        WHERE o.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order_result = $stmt->get_result();

if ($order_result->num_rows === 0) {
    $_SESSION['message'] = "Order not found.";
    header("Location: show_order.php");
    exit();
}

$order = $order_result->fetch_assoc();

// Fetch the items in the order
$sql = "SELECT oi.order_item_id, p.product_name, oi.quantity, oi.price 
        FROM `order_item` oi
        JOIN `product` p ON oi.product_id = p.product_id
        WHERE oi.order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$items_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Order Details</h1>

        <!-- Order Information -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Order Information</h3>
            </div>
            <div class="card-body">
                <p><strong>Order ID:</strong> <?= htmlspecialchars($order['order_id']) ?></p>
                <p><strong>User ID:</strong> <?= htmlspecialchars($order['user_name']) ?></p>
                <p><strong>Username:</strong> <?= htmlspecialchars($order['username']) ?></p>
                <p><strong>Total Amount:</strong> RM<?= htmlspecialchars($order['total_amount']) ?></p>
                <p><strong>Created At:</strong> <?= htmlspecialchars($order['created_at']) ?></p>

                <!-- Order Status Dropdown -->
                <form action="update_order_status.php" method="POST" class="mt-3">
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                    <div class="mb-3">
                        <label for="status" class="form-label"><strong>Status:</strong></label>
                        <select name="status" id="status" class="form-select">
                            <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Pending
                            </option>
                            <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Cancelled
                            </option>
                            <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Completed
                            </option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Update Status</button>
                </form>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card mt-4">
            <div class="card-header">
                <h3>Order Items</h3>
            </div>
            <div class="card-body">
                <?php if ($items_result->num_rows > 0): ?>
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
                            <?php while ($item = $items_result->fetch_assoc()): ?>
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
                <?php else: ?>
                    <p>No items found for this order.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="order_controller.php" class="btn btn-primary">Back to Orders</a>
        </div>
    </div>
</body>
</html>