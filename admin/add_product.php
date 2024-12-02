<?php
// Include the connection file
require '../connection.php';

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Fetch categories from the database
$categories = [];
$categoryQuery = "SELECT category_id, category_name FROM categories";
$result = $conn->query($categoryQuery);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Fetch order types
$orderTypes = [];
$orderTypeQuery = "SELECT order_id, order_type FROM order_types";
$result = $conn->query($orderTypeQuery);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orderTypes[] = $row;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize input
    $productName = trim($_POST['productName']);
    $price = floatval($_POST['price']);
    $description = trim($_POST['description']);
    $categoryId = intval($_POST['category']);
    $imageUrl = '';
    $orderId = intval($_POST['order_id']);

    // Validate inputs
    if (empty($productName) || $price <= 0 || $categoryId <= 0 || $orderId <= 0) {
        die("Invalid form inputs. Please fill all fields correctly.");
    }

    // Handle image upload
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $imageName = $_FILES['productImage']['name'];
        $imageTmp = $_FILES['productImage']['tmp_name'];
        $imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

        if (!in_array($imageExtension, $allowedExtensions)) {
            die("Invalid file type. Please upload an image file.");
        }

        $imageUrl = '../assets/img/' . uniqid() . '.' . $imageExtension;
        if (!move_uploaded_file($imageTmp, $imageUrl)) {
            die("Failed to upload image.");
        }
    } else {
        die("Please upload a valid product image.");
    }

    // Insert into the database
    $sql = "INSERT INTO products (name, description, price, image_url, order_id, category_id, created_at, updated_at) 
            VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsii", $productName, $description, $price, $imageUrl, $orderId, $categoryId);
    if ($stmt->execute()) {
        echo "Product added successfully!";
    } else {
        echo "Error adding product: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Ice Cream - Paparazzi</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/manage_ice_cream.css">
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include('navbar.php'); ?>
            <div id="content">
                <div class="container-fluid mt-3">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body" style="border-radius: 10px; box-shadow: 1px 1px 5px rgba(0,0,0,0.5);">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="productName">Product Name</label>
                                            <input type="text" class="form-control" name="productName" id="productName" placeholder="Enter product name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter description" required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="category">Category</label>
                                            <select class="form-control" name="category" id="category" required>
                                                <option value="" disabled selected>Select a category</option>
                                                <?php foreach ($categories as $category): ?>
                                                    <option value="<?= $category['category_id'] ?>"><?= $category['category_name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="Enter price" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="orderType">Order Type</label>
                                            <select class="form-control" name="order_id" id="orderType" required>
                                                <option value="" disabled selected>Select Order Type</option>
                                                <?php foreach ($orderTypes as $type): ?>
                                                    <option value="<?= $type['order_id'] ?>"><?= $type['order_type'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group" style="margin-bottom: 28px;">
                                            <label for="productImage">Product Image</label>
                                            <input type="file" class="form-control" name="productImage" id="productImage" accept="image/*" required>
                                        </div>
                                        <button type="submit" class="btn btn-block mt-2" style="background: #FF204E; color: white;">Add Product</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
