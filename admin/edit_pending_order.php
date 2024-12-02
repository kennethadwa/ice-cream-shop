<?php
// Database connection
include('../connection.php');

// Function to get order details by transaction_id
function getOrderDetails($transaction_id, $conn)
{
    $query = "SELECT t.*, CONCAT(u.first_name, ' ', u.last_name) AS customer_name
              FROM transactions t
              JOIN users u ON t.user_id = u.user_id
              WHERE t.transaction_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $transaction_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


// Function to update order details
function updateOrder($data, $conn)
{
    $query = "UPDATE transactions SET product_name = ?, payment_method = ?, order_type = ?, total_amount = ?, pickup_time = ?, status = ? WHERE transaction_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "ssssssi",
        $data['product_name'],
        $data['payment_method'],
        $data['order_type'],
        $data['total_amount'],
        $data['pickup_time'],
        $data['status'],
        $data['transaction_id']
    );
    return $stmt->execute();
}

// Check if transaction_id is passed and fetch the details
if (isset($_GET['transaction_id'])) {
    $transaction_id = intval($_GET['transaction_id']);
    $orderDetails = getOrderDetails($transaction_id, $conn);

    if (!$orderDetails) {
        echo "<script>alert('Order not found.'); window.location.href = 'pending_orders.php';</script>";
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'transaction_id' => $_POST['transaction_id'],
        'product_name' => $_POST['product_name'],
        'payment_method' => $_POST['payment_method'],
        'order_type' => $_POST['order_type'],
        'total_amount' => $_POST['total_amount'],
        'pickup_time' => $_POST['pickup_time'],
        'status' => $_POST['status'],
    ];

    if (updateOrder($data, $conn)) {
        echo "<script>alert('Order updated successfully.'); window.location.href = 'pending_orders.php';</script>";
    } else {
        echo "<script>alert('Failed to update order. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Pending Order</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        #content {
            background: linear-gradient(135deg, #f9e5d9, #c3e7c4, #ffefbb);
        }
    </style>
</head>
<body id="page-top">
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include('navbar.php'); ?>
            <div id="content">
                <div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="card shadow">
                                <div class="card-header text-center">
                                    <h5 class="m-0 font-weight-bold">Edit Pending Order</h5>
                                </div>
                                <div class="card-body">
                                    <form action="edit_pending_order.php" method="POST">
                                        <input type="hidden" name="transaction_id" value="<?php echo $orderDetails['transaction_id']; ?>">

                                        <div class="mb-3">
                                            <label for="customer_name" class="form-label">Customer Name</label>
                                            <input type="text" name="customer_name" class="form-control" id="customer_name" 
                                                   value="<?php echo htmlspecialchars($orderDetails['customer_name']); ?>" readonly>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="product_name" class="form-label">Product Name</label>
                                            <input type="text" name="product_name" class="form-control" id="product_name" value="<?php echo htmlspecialchars($orderDetails['product_name']); ?>" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label for="payment_method" class="form-label">Payment Method</label>
                                            <input type="text" name="payment_method" class="form-control" id="payment_method" value="<?php echo htmlspecialchars($orderDetails['payment_method']); ?>" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label for="order_type" class="form-label">Order Type</label>
                                            <select name="order_type" class="form-control" id="order_type">
                                                <option value="For Delivery" <?php echo $orderDetails['order_type'] == 'For Delivery' ? 'selected' : ''; ?>>For Delivery</option>
                                                <option value="For Pickup" <?php echo $orderDetails['order_type'] == 'For Pickup' ? 'selected' : ''; ?>>For Pickup</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="total_amount" class="form-label">Total Amount</label>
                                            <input type="text" name="total_amount" class="form-control" id="total_amount" value="<?php echo htmlspecialchars($orderDetails['total_amount']); ?>" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label for="pickup_time" class="form-label">Pickup Time</label>
                                            <input type="text" name="pickup_time" class="form-control" id="pickup_time" value="<?php echo htmlspecialchars($orderDetails['pickup_time']); ?>">
                                        </div>

                                        <div class="mb-3">
                                            <label for="status" class="form-label">Status</label>
                                            <select name="status" class="form-control" id="status">
                                                <option value="Pending" <?php echo $orderDetails['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Completed" <?php echo $orderDetails['status'] == 'Completed' ? 'selected' : ''; ?>>Completed</option>
                                                <option value="Cancelled" <?php echo $orderDetails['status'] == 'Cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                            </select>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Update Order</button>
                                        </div>
                                    </form>
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
