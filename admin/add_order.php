<?php
include('../connection.php');
session_start();

// Check if user is logged in and has permission
if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $user_id = intval($_POST['user_id']); // Dropdown selection now provides user_id directly
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $order_type = intval($_POST['order_type']);
    $pickup_time = mysqli_real_escape_string($conn, $_POST['pickup_time']);
    $status = "Pending";

    // Check if products are selected
    if (!isset($_POST['products']) || !is_array($_POST['products'])) {
        $_SESSION['error'] = "Please select at least one product.";
        header('Location: add_order.php');
        exit();
    }

    // Calculate total amount based on selected products
    $selected_products = $_POST['products']; // Array of product IDs
    $product_ids = implode(",", $selected_products); // Convert array to comma-separated string
    $query = "SELECT SUM(price) AS total_amount FROM products WHERE product_id IN ($product_ids)";
    $result = $conn->query($query);

    if ($result && $row = $result->fetch_assoc()) {
        $total_amount = $row['total_amount'];

        // Insert transaction record
        $insertTransaction = "INSERT INTO transactions (user_id, total_amount, order_id, pickup_time, status) 
                              VALUES ('$user_id', '$total_amount', '$order_type', '$pickup_time', '$status')";

        if ($conn->query($insertTransaction) === TRUE) {
            $transaction_id = $conn->insert_id; // Get the newly inserted transaction ID

            // Insert products into the transactions_table
            foreach ($selected_products as $product_id) {
                // Get product price (and any additional price if necessary)
                $productQuery = "SELECT price FROM products WHERE product_id = $product_id";
                $productResult = $conn->query($productQuery);
                $product = $productResult->fetch_assoc();
                $additional_price = $product['price']; // Assuming additional price is the same as product price (adjust if necessary)

                $insertTransactionItem = "INSERT INTO transaction_items(transaction_id, product_id, additional_price) 
                                           VALUES ('$transaction_id', '$product_id', '$additional_price')";
                if (!$conn->query($insertTransactionItem)) {
                    $_SESSION['error'] = "Failed to add order items: " . $conn->error;
                    header('Location: add_order.php');
                    exit();
                }
            }

            $_SESSION['message'] = "Order added successfully!";
            header('Location: pending_orders.php');
            exit();
        } else {
            $_SESSION['error'] = "Failed to add order: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Failed to calculate total amount.";
    }
}

// Handle AJAX request to fetch the delivery address
if (isset($_GET['user_id'])) {
    $user_id = intval($_GET['user_id']);
    $query = "SELECT address FROM users WHERE user_id = $user_id";
    $result = $conn->query($query);
    if ($result && $row = $result->fetch_assoc()) {
        echo $row['address'];
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Order</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include('navbar.php'); ?>
            <div id="content">
                <div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="p-4" style="box-shadow: 2px 2px 10px rgba(0,0,0,0.3);">
                                <h5 class="text-center font-weight-bold">Add New Order</h5>
                                <?php
                                if (isset($_SESSION['error'])) {
                                    echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
                                    unset($_SESSION['error']);
                                }
                                ?>
                                <form action="" method="POST">
                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">Full Name</label>
                                        <select class="form-control" id="user_id" name="user_id" required>
                                            <option value="">Select a User</option>
                                            <?php
                                            $user_query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS full_name FROM users";
                                            $user_result = $conn->query($user_query);
                                            if ($user_result->num_rows > 0) {
                                                while ($user = $user_result->fetch_assoc()) {
                                                    echo "<option value='{$user['user_id']}'>{$user['full_name']}</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No users available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Delivery Address</label>
                                        <input type="text" class="form-control" id="address" name="address" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="products" class="form-label">Select Products</label>
                                        <?php
                                        $product_query = "SELECT product_id, name FROM products";
                                        $product_result = $conn->query($product_query);
                                        if ($product_result->num_rows > 0) {
                                            while ($product = $product_result->fetch_assoc()) {
                                                echo "<div class='form-check'>
                                                        <input class='form-check-input' type='checkbox' name='products[]' value='{$product['product_id']}' id='product_{$product['product_id']}'>
                                                        <label class='form-check-label' for='product_{$product['product_id']}'>{$product['name']}</label>
                                                      </div>";
                                            }
                                        } else {
                                            echo "<p>No products available.</p>";
                                        }
                                        ?>
                                    </div>
                                    <div class="mb-3">
                                        <label for="order_type" class="form-label">Order Type</label>
                                        <select class="form-control" id="order_type" name="order_type" required>
                                            <?php
                                            $order_type_query = "SELECT order_id, order_type FROM order_types";
                                            $order_type_result = $conn->query($order_type_query);
                                            if ($order_type_result->num_rows > 0) {
                                                while ($order_type = $order_type_result->fetch_assoc()) {
                                                    echo "<option value='{$order_type['order_id']}'>{$order_type['order_type']}</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No order types available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pickup_time" class="form-label">Pickup Time (if applicable)</label>
                                        <input type="time" class="form-control" id="pickup_time" name="pickup_time">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Order</button>
                                    <a href="pending_orders.php" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#user_id').change(function() {
            var user_id = $(this).val(); // Get selected user ID
            if (user_id) {
                $.ajax({
                    url: 'add_order.php', // AJAX request to get the user's address
                    type: 'GET',
                    data: { user_id: user_id },
                    success: function(response) {
                        $('#address').val(response); // Populate address field with user's address
                    }
                });
            }
        });
    });
</script>
</body>
</html>
