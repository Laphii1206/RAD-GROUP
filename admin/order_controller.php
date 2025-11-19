<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\admin\admin_dashboard.php
session_start();
include '../auth/db_connect.php';

// Handle order status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_order_status'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $sql = "UPDATE `orders` SET `status` = ? WHERE `order_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Order status updated successfully.";
    } else {
        $_SESSION['message'] = "Failed to update order status.";
    }
}

// Fetch all orders
$order_sql = "SELECT * FROM orders ORDER BY created_at DESC";
$order_result = $conn->query($order_sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>

<body>
    <header class="navbar navbar-expand-lg sticky-top custom-nav-bg px-5">
        <div class="container-fluid">
            <a class="navbar-brand custom-nav-text" href="../index.php">WongKokSeng Wholesale</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 text-white">
                    <li class="nav-item">
                        <a class="nav-link custom-nav-text" href="admin_dashboard.php">Manage Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-text-active" href="order_controller.php">Show Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-text" href="message_controller.php">Show Contacts Message</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <h1 class="text-center">Admin Dashboard</h1>

        <!-- Display Orders -->
        <div class="mt-5">
            <h2>Orders</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Username</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $order_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['order_id']) ?></td>
                            <td><?= htmlspecialchars($row['user_name']) ?></td>
                            <td>RM<?= htmlspecialchars($row['total_amount']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <!-- Update Order Status -->
                                <form action="order_controller.php" method="POST" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                    <select name="status" class="form-select form-select-sm d-inline w-auto">
                                        <option value="pending" <?= $row['status'] === 'pending' ? 'selected' : '' ?>>Pending
                                        </option>
                                        <option value="completed" <?= $row['status'] === 'completed' ? 'selected' : '' ?>>
                                            Completed</option>
                                        <option value="cancelled" <?= $row['status'] === 'cancelled' ? 'selected' : '' ?>>
                                            Cancelled</option>
                                    </select>
                                    <button type="submit" name="update_order_status"
                                        class="btn btn-success btn-sm">Update</button>
                                </form>
                                <a href="viewOrderDetails.php?id=<?= $row['order_id'] ?>"
                                    class="btn btn-info btn-sm">View</a>
                                <!-- Delete Order Button -->
                                <form action="delete_order.php" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
</body>

</html>