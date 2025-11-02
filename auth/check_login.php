<?php
include __DIR__ . '/auth/db_connect.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT * FROM user WHERE id = '$userId'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}
?>