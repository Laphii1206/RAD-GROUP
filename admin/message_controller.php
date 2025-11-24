<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\admin\viewMessages.php
session_start();
include '../auth/db_connect.php';

// Fetch all messages from the database
$sql = "SELECT message_id, name, email, subject, created_at FROM contactmessage ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
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
                        <a class="nav-link custom-nav-text" href="order_controller.php">Show Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-text-active" href="message_controller.php">Show Contacts
                            Message</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <div class="container mt-5">
        <h1 class="text-center">Messages</h1>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Message ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['message_id']) ?></td>
                            <td><?= htmlspecialchars($row['name']) ?></td>
                            <td><?= htmlspecialchars($row['email']) ?></td>
                            <td><?= htmlspecialchars($row['subject']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <a href="viewMessageDetails.php?id=<?= $row['message_id'] ?>"
                                    class="btn btn-primary btn-sm">View Message</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No messages found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>