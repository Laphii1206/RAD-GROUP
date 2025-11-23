<?php
session_start();
include '../auth/db_connect.php';
include '../cart/calculate_item.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $subject = $_POST["subject"];
  $message = $_POST["message"];
  if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
    //sql statement
    $sql = "INSERT INTO contactmessage (name,email,subject,message) VALUE('$name','$email','$subject','$message')";
    //execute the sql statement
    if (!mysqli_query($conn, $sql)) {
      //show error messsage
      $ErrorConnMessage = "Form submission failed Can't connect to database. Please try again.";
      echo "<script type='text/javascript'>";
      echo "alert('" . $ErrorConnMessage . "');";
      echo "</script>";
    } else {
      //show sucess message
      $SucessMessage = "Form submitted successfully!";
      echo "<script type='text/javascript'>";
      echo "alert('" . $SucessMessage . "');";
      echo "</script>";
    }
  } else {
    $ErrorMessage = "Form submission failed. Please fill in all required fields.";
    echo "<script type='text/javascript'>";
    echo "alert('" . $ErrorMessage . "');";
    echo "</script>";
  }
}

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
            <a class="nav-link custom-nav-text" href="../index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text" href="product.php">Product</a>
          </li>
          <li class="nav-item">
            <a class="nav-link custom-nav-text-active" href="contact.php">Contact</a>
          </li>
          <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
            <li class="nav-item">
              <a class="nav-link custom-nav-text" href="../admin/admin_dashboard.php">Admin</a>
            </li>
          <?php endif; ?>
        </ul>
        <div class="d-flex">
          <!-- Cart Dropdown -->
          <div class="dropdown ms-3 position-relative" id="cartDropdownContainer">
            <!-- Cart Name with Notification Badge -->
            <span class="btn btn-custom position-relative" id="cartDropdown">
              Shopping Cart
              <?php if (isset($_SESSION['total_cart_items']) && $_SESSION['total_cart_items'] > 0): ?>
                <span class="position-absolute translate-middle badge rounded-pill bg-danger"
                  style="transform: translate(-50%, -50%);">
                  <?php echo $_SESSION['total_cart_items']; ?>
                </span>
              <?php endif; ?>
            </span>
            <ul class="dropdown-menu dropdown-menu-start" aria-labelledby="cartDropdown" style="width: 300px;">
              <?php
              if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                foreach ($_SESSION['cart'] as $item) {
                  echo '<li class="dropdown-item">';
                  echo '<div class="d-flex justify-content-between">';
                  echo '<span>' . htmlspecialchars($item['product_name']) . '</span>';
                  echo '<span>RM ' . htmlspecialchars($item['product_price']) . '</span>';
                  echo '</div>';
                  echo '<div class="d-flex justify-content-between">';
                  echo '<small>Quantity: ' . htmlspecialchars($item['quantity']) . '</small>';
                  echo '<small>Total: RM ' . htmlspecialchars($item['product_price'] * $item['quantity']) . '</small>';
                  echo '</div>';
                  echo '</li>';
                }
                echo '<li><hr class="dropdown-divider"></li>';
                echo '<li class="text-center"><a href="../cart/cart.php" class="btn btn-primary btn-sm">View Cart</a></li>';
              } else {
                echo '<li class="dropdown-item text-center">Your cart is empty.</li>';
              }
              ?>
            </ul>
          </div>
          <?php if (isset($_SESSION['username'])): ?>
            <div class="dropdown">
              <button class="btn btn-custom dropdown-menu-dark dropdown-toggle" type="button" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo $_SESSION['username']; ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="show_order.php">Show Order</a></li>
                <li><a class="dropdown-item" href="../auth/logout.php">Logout</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a class="btn btn-outline-light mx-2" href="../auth/login.php">Login</a>
            <a class="btn btn-outline-light" href="../auth/register.php">Sign-Up</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </header>


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
        <form action="contact.php" method="POST">
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
          <p>Email: clasadlife@gmail.com </p>
        </li>
        <li>
          <p>Phone Number: 012-3983386</p>
        </li>
        <li>
          <p>Address:Gerai H-27, Pasar Borong Jalan Selayang Baru, Batu 8, Batu Caves, 68100 Batu Caves, Selangor, Malaysia</p>
        </li>
      </ul>
    </div>
  </div>
  <script src="../js/script.js"></script>

</body>

</html>