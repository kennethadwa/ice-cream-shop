<?php
include('../connection.php');

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Fetch all cancelled transactions including order type, ordered by the transaction ID in descending order
$query = "
    SELECT 
        t.transaction_id,
        CONCAT(u.first_name, ' ', u.last_name) AS full_name, 
        u.address AS delivery_address, 
        p.name AS product_name, 
        t.total_amount, 
        ot.order_type,  -- Fetch order type from order_types table
        t.pickup_time, 
        t.status
    FROM 
        transactions t
    JOIN 
        users u ON t.user_id = u.user_id
    JOIN 
        transaction_items ti ON t.transaction_id = ti.transaction_id
    JOIN 
        products p ON ti.product_id = p.product_id
    JOIN 
        order_types ot ON t.order_id = ot.order_id  -- Join the order_types table
    WHERE 
        t.status = 'Cancelled'
    ORDER BY 
        t.transaction_id DESC  -- Arrange results in descending order by transaction_id
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cancelled Orders</title>
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                    <div class="card mb-4" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.5);">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Cancelled Orders</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive mt-3">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Delivery Address</th>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th>Order Type</th>  <!-- Add column for order type -->
                                            <th>Pickup Time</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>{$row['full_name']}</td>";
                                                echo "<td>{$row['delivery_address']}</td>";
                                                echo "<td>{$row['product_name']}</td>";
                                                echo "<td>₱" . number_format($row['total_amount'], 2) . "</td>";
                                                echo "<td>{$row['order_type']}</td>";
                                                echo "<td>{$row['pickup_time']}</td>";
                                                echo "<td><span class='badge badge-danger'>{$row['status']}</span></td>";
                                                echo "<td>
                                                    <a href='delete_cancelled_order.php?transaction_id={$row['transaction_id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Are you sure you want to delete this order permanently?');\">
                                                        <i class='bi bi-trash'></i> Delete
                                                    </a>
                                                </td>";

                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>No cancelled orders found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Close the database connection
$conn->close();
?>
