<?php
include('../connection.php'); // Database connection

session_start();

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 3) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch transactions based on status
function fetch_transactions($conn, $user_id, $status) {
    $query = "SELECT 
                transactions.transaction_id,
                CONCAT(users.first_name, ' ', users.last_name) AS customer,
                transactions.total_amount,
                payment.payment_method AS payment_method, 
                order_types.order_type AS order_type,
                transactions.pickup_time,
                transactions.status,
                transactions.transaction_date,
                GROUP_CONCAT(DISTINCT products.name ORDER BY transaction_items.transaction_item_id ASC) AS product_names,
                GROUP_CONCAT(DISTINCT transaction_items.additional_price ORDER BY transaction_items.transaction_item_id ASC) AS additional_prices
              FROM transactions
              INNER JOIN users ON transactions.user_id = users.user_id
              LEFT JOIN transaction_items ON transactions.transaction_id = transaction_items.transaction_id
              LEFT JOIN products ON transaction_items.product_id = products.product_id
              LEFT JOIN payment ON transactions.payment_id = payment.payment_id
              LEFT JOIN order_types ON transactions.order_id = order_types.order_id
              WHERE transactions.user_id = ? AND transactions.status = ?
              GROUP BY transactions.transaction_id
              ORDER BY transactions.transaction_date DESC";
              
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $status);
    $stmt->execute();
    return $stmt->get_result();
}


$pending_transactions = fetch_transactions($conn, $user_id, 'Pending');
$completed_transactions = fetch_transactions($conn, $user_id, 'Completed');
$cancelled_transactions = fetch_transactions($conn, $user_id, 'Cancelled');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paparazzi - Order History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #ffe4e6; 
        color: #5c2c2c;
    }

    h1 {
        color: #c2185b; 
        font-family: 'Comic Sans MS', cursive, sans-serif;
        text-shadow: 2px 2px 4px #ffccd5;
    }

    .nav-tabs .nav-link.active {
        background-color: #f8bbd0; /* Light cherry pink for active tab */
        color: #5c2c2c;
        font-family: 'Comic Sans MS', cursive, sans-serif;
        border-color: #c2185b;
    }

    .nav-tabs .nav-link {
        font-family: 'Comic Sans MS', cursive, sans-serif;
        color: #5c2c2c;
    }

    .table thead {
        background-color: #f48fb1;
        font-family: 'Comic Sans MS', cursive, sans-serif;
        color: white;
    }

    .table-bordered {
        border-color: #c2185b;
    }

    .btn {
        background-color: #f06292;
        font-family: 'Comic Sans MS', cursive, sans-serif;
        color: white;
        border: none;
    }

</style>

</head>
<body>
    <?php include('navbar.php'); ?>

    <h1 class="text-center mt-4">Order History</h1>
    <div class="container">
        <ul class="nav nav-tabs" id="orderTabs" role="tablist">
            <li class="nav-item">
                <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Pending</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="completed-tab" data-bs-toggle="tab" data-bs-target="#completed" type="button" role="tab">Completed</button>
            </li>
            <li class="nav-item">
                <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab" data-bs-target="#cancelled" type="button" role="tab">Cancelled</button>
            </li>
        </ul>
        <div class="tab-content mt-3">
            <!-- Pending Orders -->
            <div class="tab-pane fade show active" id="pending" role="tabpanel">
                <table class="table table-hover table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Products</th>
                            <th>Payment Method</th>
                            <th>Order Type</th>
                            <th>Pick Up Time</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Transaction Date</th>              
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $pending_transactions->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['transaction_id'] ?></td>
                                <td><?= $row['customer'] ?></td>
                                <td><?= $row['product_names'] ?></td>
                                <td><?= $row['payment_method'] ?></td>
                                <td><?= $row['order_type'] ?></td>
                                <td>
                                    <?php
                                    if ($row['order_type'] == 'For Delivery') {
                                        echo 'Not Applicable';
                                    } else {
                                        echo $row['pickup_time'];
                                    }
                                    ?>
                                </td>
                                <td><?= number_format($row['total_amount'], 2) ?></td>
                                <td><?= $row['status'] ?></td>
                                <td><?= $row['transaction_date'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Completed Orders -->
            <div class="tab-pane fade" id="completed" role="tabpanel">
                <table class="table table-hover table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Products</th>
                            <th>Payment Method</th>
                            <th>Order Type</th>
                            <th>Pick Up Time</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Transaction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $completed_transactions->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['transaction_id'] ?></td>
                                <td><?= $row['customer'] ?></td>
                                <td><?= $row['product_names'] ?></td>
                                <td><?= $row['payment_method'] ?></td>
                                <td><?= $row['order_type'] ?></td>
                                <td><?= number_format($row['total_amount'], 2) ?></td>
                                <td><?= $row['status'] ?></td>
                                <td><?= $row['transaction_date'] ?></td>
                                <td>
                                    <?php
                                    if ($row['order_type'] == 'Delivery') {
                                        echo 'Not Applicable';
                                    } else {
                                        echo $row['pickup_time'];
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <!-- Cancelled Orders -->
            <div class="tab-pane fade" id="cancelled" role="tabpanel">
                <table class="table table-hover table-bordered text-center">
                    <thead>
                        <tr>
                            <th>Transaction ID</th>
                            <th>Customer</th>
                            <th>Products</th>
                            <th>Payment Method</th>
                            <th>Order Type</th>
                            <th>Pick Up Time</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Transaction Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $cancelled_transactions->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['transaction_id'] ?></td>
                                <td><?= $row['customer'] ?></td>
                                <td><?= $row['product_names'] ?></td>
                                <td><?= $row['payment_method'] ?></td>
                                <td><?= $row['order_type'] ?></td>
                                <td>
                                    <?php
                                    if ($row['order_type'] == 'For Delivery') {
                                        echo 'Not Applicable';
                                    } else {
                                        echo $row['pickup_time'];
                                    }
                                    ?>
                                </td>
                                <td><?= number_format($row['total_amount'], 2) ?></td>
                                <td><?= $row['status'] ?></td>
                                <td><?= $row['transaction_date'] ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
