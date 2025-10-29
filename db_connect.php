<?php
$conn = new mysqli("localhost", "laphii", "laphii123", "wks");

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>