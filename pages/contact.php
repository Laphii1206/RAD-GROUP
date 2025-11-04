<?php
include '../auth/db_connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Contact-Us</title>
  <link rel="stylesheet" href="../css/style.css">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>WongKokSeng Wholesale</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
  <script src="js/script.js"></script>
</head>



<body>
  <nav class="navTop">
    <a href="index.php">WongKokSeng Wholesale</a>
    <ul>
      <li><a href="../index.php">Home</a></li>
      <li><a href="product.php">Product</a></li>
      <li><a href="contact.php" class="active">Contact</a></li>
      <li><a href="preorder.php">Preorder</a></li>
      <li><a href="adminPanel.php">Admin</a></li>
    </ul>
    <?php if (isset($_SESSION['username'])): ?>
      <span class="welcome-message">Welcome,
        <?php echo $_SESSION['username']; ?>!
      </span>
      <a class="logout" href="../auth/logout.php">Logout</a>
    <?php else: ?>
      <a class="login" href="../auth/login.php">Login / Register</a>
    <?php endif; ?>
  </nav>


  <div class="contact-header">
    <h2>Contact Us</h2>
  </div>
  <div class="contact-container" style="max-width: 100%;">
    <div class="contact-formbox">
      <div class="contact-form-welcome-message-box">
        <div class="contact-form-welcome-message">
          <h3>We would love to hear from you!</h3>
          <p>If you have any questions, suggestions, or feedback, please feel free to reach out to us using the form
            below.
            Our team is here to assist you and ensure you have the best experience with WongKokSeng Wholesale.</p>
        </div>
      </div>
      <div class="contact-form">
        <form action="submit_form.php" method="POST">
          <div>
            <label>Name:</label>
            <input type="text" id="name" name="name" required>
          </div>

          <div>
            <label>Email:</label>
            <input type="email" id="email" name="email" required>
          </div>

          <div>
            <label>Subject:</label>
            <input type="text" id="subject" name="subject">
          </div>
          <div>
            <label>Message:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
          </div>
          <div>
            <button type="submit">Send Message</button>
          </div>
        </form>
      </div>
    </div>
    <div class="contact-info">
      <ul style="text-align: center;">
        <li>
          <p>Email: Wong@gmail.com </p>
        </li>
        <li>
          <p>Phone Number: 01499899898</p>
        </li>
        <li>
          <p>Address: 1, Jalan PJU 1a/48, Pusat Perdagangan Dana 1, 47301 Petaling Jaya, Selangor</p>
        </li>
      </ul>
    </div>
  </div>
</body>

</html>