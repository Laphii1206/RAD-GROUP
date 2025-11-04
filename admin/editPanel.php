<?php
include "../auth/db_connect.php";

if (isset($_GET['id']) && isset($_GET['action'])) {
    $productId = $_GET['id'];
    $action = $_GET['action'];

    if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $sql = "SELECT * FROM product WHERE product_id = $productId";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        $oldImage = $row['product_image'];

        $newImage = $_FILES['product_image']['name'];
        if (!empty($newImage)) {
            $targetDir = "../images/";
            $targetFile = $targetDir . basename($newImage);

            if (move_uploaded_file($_FILES['product_image']['tmp_name'], $targetFile)) {
                $oldImagePath = "../images/" . $oldImage;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            } else {
                echo "Error uploading the new image.";
                exit();
            }
        } else {
            $newImage = $oldImage;
        }

        $productName = $_POST['product_name'];
        $productWeight = $_POST['product_weight'];
        $productPrice = $_POST['product_price'];

        $sql = "UPDATE product SET 
                product_name = '$productName', 
                product_weight = '$productWeight', 
                product_price = '$productPrice', 
                product_image = '$newImage'
                WHERE product_id = $productId";

        if ($conn->query($sql)) {
            header("Location: adminPanel.php");
            exit();
        } else {
            echo "Error updating product: " . $conn->error;
        }
    }
}
?>

<html>

<head>

    <title>
        Edit Panel
    </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <table class="table table-bordered ">
   
        <tbody>
            <?php
            if (isset($_GET['id'])) {
                $productId = $_GET['id'];
                $sql = "SELECT * FROM product WHERE product_id = $productId";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                ?>
               <div class="container mt-5">
        <h1>Edit Products</h1>

        <form action="editPanel.php?id=<?= $row['product_id'] ?>&action=edit" method="POST" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="product_name" class="form-label">Product Name</label>
                <input type="text" name="product_name" id="product_name" class="form-control" value="<?= $row['product_name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_weight" class="form-label">Product Weight</label>
                <input type="text" name="product_weight" id="product_weight" class="form-control" value="<?= $row['product_weight'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="number" step="0.01" name="product_price" id="product_price" class="form-control" value="<?= $row['product_price'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_image" class="form-label">Product Image</label>
                <input type="file" name="product_image" id="product_image" class="form-control" value="<?= $row['product_image'] ?>">
            </div>
            <button type="edit" class="btn btn-primary">Update Product</button>
        </form>
            <?php
            }
        ?>
        </tbody>
</body>

</html>