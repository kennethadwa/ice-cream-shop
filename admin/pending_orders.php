<?php

include('../connection.php');

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

$query = "
    SELECT 
        t.transaction_id,
        CONCAT(u.first_name, ' ', u.last_name) AS full_name, 
        u.address AS delivery_address, 
        t.product_name, 
        t.payment_method, 
        t.order_type, 
        t.total_amount, 
        t.pickup_time, 
        t.status
    FROM 
        transactions t
    JOIN 
        users u ON t.user_id = u.user_id
    WHERE 
        t.status = 'pending'
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pending Orders</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include('sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Navbar -->
            <?php include('navbar.php'); ?>

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid mt-5">
                    <!-- DataTable Example -->
                    <div class="card mb-4" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.5);">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Admin Account List</h6>
                            <a href="add_order.php" class="btn btn-primary btn-sm">Add New Order</a>
                        </div>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pending Orders</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Delivery Address</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Order Type</th>
                                            <th>Pickup Time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Delivery Address</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Order Type</th>
                                            <th>Pickup Time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        // Check if any pending orders exist
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>{$row['full_name']}</td>";
                                                echo "<td>{$row['delivery_address']}</td>";
                                                echo "<td>{$row['product_name']}</td>";
                                                echo "<td>₱" . number_format($row['total_amount'], 2) . "</td>";
                                                echo "<td><span class='badge badge-" . ($row['order_type'] == 'For Delivery' ? 'success' : 'primary') . "'>{$row['order_type']}</span></td>";
                                                echo "<td>{$row['pickup_time']}</td>";
                                                echo "<td><span class='badge badge-danger'>{$row['status']}</span></td>";
                                                echo "<td><a href='edit_pending_order.php?id={$row['transaction_id']}' class='btn btn-primary btn-sm'>Update</a></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>No pending orders found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End of Page Content -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages -->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
