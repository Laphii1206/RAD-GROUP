<?php
include '../auth/db_connect.php';
$sql = "SELECT * FROM product";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $productWeight = $_POST['product_weight'];
    $productPrice = $_POST['product_price'];
    $productImage = $_FILES['product_image']['name'];

    $targetDir = "../images/";
    $targetFile = $targetDir . basename($productImage);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile);

    $sql = "INSERT INTO product (product_name, product_weight, product_price, product_image) 
            VALUES ('$productName', '$productWeight', '$productPrice', '$productImage')";
    $conn->query($sql);
    header("Location: adminPanel.php");

}


if (isset($_GET['id']) && isset($_GET['action'])) {
    $productId = $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'delete') {

        $sql = "SELECT product_image FROM product WHERE product_id = $productId";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $imageFile = $row['product_image'];

            $imagePath = __DIR__ . "/../images/" . $imageFile;
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }


        $sql = "DELETE FROM product WHERE product_id = $productId";
        $conn->query($sql);
        header("Location: adminPanel.php");
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
</head>

<body>
    <a href="../index.php">WongKokSeng Wholesale</a>
    <div class="container mt-5">
        <h1>Manage Products</h1>

        <form action="adminPanel.php" method="POST" enctype="multipart/form-data" class="mb-4">
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
                        <td><?= ($row['product_id']) ?></td>
                        <td><?= ($row['product_name']) ?></td>
                        <td><?= ($row['product_weight']) ?></td>
                        <td>RM<?= ($row['product_price']) ?></td>
                        <td><img src="../images/<?= ($row['product_image']) ?>" alt="<?= ($row['product_name']) ?>"
                                style="width: 100px;"></td>
                        <td>
                            <a href="editPanel.php?id=<?= $row['product_id'] ?>"
                                class="btn btn-warning btn-sm">Edit</a>
                            <a href="adminPanel.php?id=<?= $row['product_id'] ?>&action=delete"
                                class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>

</html>