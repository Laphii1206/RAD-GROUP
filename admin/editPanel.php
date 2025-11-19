<?php
include "../auth/db_connect.php";

if (isset($_GET['id']) && isset($_GET['action'])) {
    $productId = $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // Fetch the old product details
        $sql = "SELECT * FROM product WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        // Handle the new image upload
        $newImage = $_FILES['product_image']['tmp_name'];
        if (!empty($newImage)) {
            // Read the binary content of the uploaded image
            $imageData = file_get_contents($newImage);
        } else {
            // If no new image is uploaded, keep the old image
            $imageData = $row['product_image'];
        }

        // Update the product details in the database
        $productName = $_POST['product_name'];
        $productWeight = $_POST['product_weight'];
        $productPrice = $_POST['product_price'];

        $sql = "UPDATE product SET 
                product_name = ?, 
                product_weight = ?, 
                product_price = ?, 
                product_image = ?
                WHERE product_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdsi", $productName, $productWeight, $productPrice, $imageData, $productId);

        if ($stmt->execute()) {
            header("Location: adminPanel.php");
            exit();
        } else {
            echo "Error updating product: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Products</h1>

        <?php
        if (isset($_GET['id'])) {
            $productId = $_GET['id'];
            $sql = "SELECT * FROM product WHERE product_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            ?>
            <form action="editPanel.php?id=<?= $row['product_id'] ?>&action=edit" method="POST"
                enctype="multipart/form-data" class="mb-4">
                <div class="mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="form-control"
                        value="<?= htmlspecialchars($row['product_name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="product_weight" class="form-label">Product Weight</label>
                    <input type="text" name="product_weight" id="product_weight" class="form-control"
                        value="<?= htmlspecialchars($row['product_weight']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="product_price" class="form-label">Product Price</label>
                    <input type="number" step="0.01" name="product_price" id="product_price" class="form-control"
                        value="<?= htmlspecialchars($row['product_price']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="product_image" class="form-label">Product Image</label>
                    <input type="file" name="product_image" id="product_image" class="form-control">
                    <small class="text-muted">Leave blank to keep the current image.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Current Image:</label>
                    <div>
                        <img src="data:image/jpeg;base64,<?= base64_encode($row['product_image']) ?>" alt="Product Image"
                            class="img-thumbnail" style="max-width: 200px;">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
            <?php
        }
        ?>
    </div>
</body>

</html>