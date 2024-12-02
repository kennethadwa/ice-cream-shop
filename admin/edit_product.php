<?php
// Include the connection file
require '../connection.php';

session_start();

// Check user access permissions
if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Fetch product details based on product ID
$product = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = intval($_GET['id']);
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

// Handle form submission for updating the product
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);
    $productName = trim($_POST['productName']);
    $price = intval($_POST['price']);
    $description = trim($_POST['description']);
    $imageUrl = $product['image_url']; 

    // Handle image upload if a new file is provided
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === 0) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageName = $_FILES['productImage']['name'];
        $imageTmp = $_FILES['productImage']['tmp_name'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (in_array($imageExtension, $allowedExtensions)) {
            $imageUrl = '../assets/img/' . uniqid() . '.' . $imageExtension;
            move_uploaded_file($imageTmp, $imageUrl);
        } else {
            die("Invalid image format. Please upload a valid image.");
        }
    }

    // Update the product details in the database
    $updateQuery = "UPDATE products SET name = ?, price = ?, description = ?, image_url = ?, updated_at = NOW() WHERE product_id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sissi", $productName, $price, $description, $imageUrl, $productId);

    if ($stmt->execute()) {
        echo "<script>alert('Product Updated Successfully')</script>";
        header('Location: manage_products.php?msg=Product updated successfully');
        exit();
    } else {
        echo "Failed to update product: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Ice Cream - Paparazzi</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include('navbar.php'); ?>
            <div id="content">
                <div class="container-fluid mt-3">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">Edit Ice Cream</h5>
                                    <?php if ($product): ?>
                                    <form method="POST" enctype="multipart/form-data">
                                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                        <div class="form-group">
                                            <label for="editProductName">Product Name</label>
                                            <input type="text" class="form-control" id="editProductName" name="productName" value="<?= $product['name'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="editPrice">Price</label>
                                            <input type="number" class="form-control" id="editPrice" name="price" value="<?=$product['price'] ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="editDescription">Description</label>
                                            <textarea class="form-control" id="editDescription" name="description" rows="3" required><?= $product['description'] ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="editProductImage">Product Image</label>
                                            <input type="file" class="form-control" id="editProductImage" name="productImage" accept="image/*">
                                            <small class="form-text text-muted">Current Image: <?= basename($product['image_url']) ?></small>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-block mt-3">Update Product</button>
                                        <a href="manage_products.php" class="btn btn-secondary btn-block mt-2">Cancel</a>
                                    </form>
                                    <?php else: ?>
                                    <p class="text-center text-danger">Product not found!</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
