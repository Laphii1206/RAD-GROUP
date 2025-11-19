<?php
include '../auth/db_connect.php';

// Fetch all orders from the database
$sql = "SELECT * FROM orders ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
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
                        <a class="nav-link custom-nav-text" href="admin_dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-text" href="display_order.php">Show Orders</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <h1>Order List</h1>
        <table class=" table table-bordered">
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
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td>
                        <?= htmlspecialchars($row['order_id']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($row['user_name']) ?>
                    </td>
                    <td>RM
                        <?= htmlspecialchars($row['total_amount']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($row['status']) ?>
                    </td>
                    <td>
                        <?= htmlspecialchars($row['created_at']) ?>
                    </td>
                    <td>
                        <a href="viewOrderDetails.php?id=<?= $row['order_id'] ?>" class="btn btn-info btn-sm">View</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
        </table>
    </div>
</body>

</html>