<?php
// filepath: c:\xampp\htdocs\RAD-GroupProject\admin\viewMessageDetails.php
session_start();
include '../auth/db_connect.php';

// Check if the message ID is provided
if (!isset($_GET['id'])) {
    echo "Message ID not provided.";
    exit();
}

$message_id = $_GET['id'];

// Fetch the message details from the database
$sql = "SELECT * FROM contactmessage WHERE message_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $message_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Message not found.";
    exit();
}

$message = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Message</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Message Details</h1>
        <div class="card mt-4">
            <div class="card-header">
                <h3>Message Information</h3>
            </div>
            <div class="card-body">
                <p><strong>Message ID:</strong> <?= htmlspecialchars($message['message_id']) ?></p>
                <p><strong>Name:</strong> <?= htmlspecialchars($message['name']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($message['email']) ?></p>
                <p><strong>Subject:</strong> <?= htmlspecialchars($message['subject']) ?></p>
                <p><strong>Message:</strong></p>
                <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
                <p><strong>Created At:</strong> <?= htmlspecialchars($message['created_at']) ?></p>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="viewMessages.php" class="btn btn-primary">Back to Messages</a>
        </div>
    </div>
</body>

</html>