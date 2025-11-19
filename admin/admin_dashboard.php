<?php
include '../auth/db_connect.php';

// Fetch all products from the database
$sql = "SELECT * FROM product";
$result = $conn->query($sql);

// Handle adding a new product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $productWeight = $_POST['product_weight'];
    $productPrice = $_POST['product_price'];

    // Handle the uploaded image
    $productImage = file_get_contents($_FILES['product_image']['tmp_name']); // Read the binary data

    // Insert the product into the database
    $sql = "INSERT INTO product (product_name, product_weight, product_price, product_image) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdds", $productName, $productWeight, $productPrice, $productImage);
    $stmt->execute();

    header("Location: admin_dashboard.php");
    exit();
}

// Handle deleting a product
if (isset($_GET['id']) && isset($_GET['action'])) {
    $productId = $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'delete') {
        // Delete the product from the database
        $sql = "DELETE FROM product WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();

        header("Location: admin_dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Products</title>
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
                        <a class="nav-link custom-nav-text-active" href="admin_dashboard.php">Manage Product</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-text" href="order_controller.php">Show Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link custom-nav-text" href="message_controller.php">Show Contacts Message</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container mt-5">
        <h1>Manage Products</h1>

        <!-- Add Product Form -->
        <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="product_weight" class="form-label">Product Weight</label>
                <input type="text" name="product_weight" id="product_weight" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="number" step="0.01" name="product_price" id="product_price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="product_image" class="form-label">Product Image</label>
                <input type="file" name="product_image" id="product_image" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>

        <!-- Product List -->
        <h2>Product List</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Weight</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['product_id']) ?></td>
                        <td><?= htmlspecialchars($row['product_name']) ?></td>
                        <td><?= htmlspecialchars($row['product_weight']) ?></td>
                        <td>RM<?= htmlspecialchars($row['product_price']) ?></td>
                        <td>
                            <?php
                            // Display the image from the LONGBLOB
                            $imageData = base64_encode($row['product_image']);
                            $imageSrc = 'data:image/jpeg;base64,' . $imageData;
                            ?>
                            <img src="<?= $imageSrc ?>" alt="<?= htmlspecialchars($row['product_name']) ?>"
                                style="width: 100px;">
                        </td>
                        <td>
                            <a href="editPanel.php?id=<?= $row['product_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin_dashboard.php?id=<?= $row['product_id'] ?>&action=delete"
                                class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>