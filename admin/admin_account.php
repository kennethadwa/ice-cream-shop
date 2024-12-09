<?php
session_start();
require_once '../connection.php'; // Include database connection

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Customer Accounts</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
                            <h6 class="m-0 font-weight-bold text-primary">Customer Account List</h6>
                            <a href="add_customer.php" class="btn btn-primary btn-sm">Add New Customer</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Contact Number</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Full Name</th>
                                            <th>Contact Number</th>
                                            <th>Address</th>
                                            <th>Email</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS full_name, contact, address, email 
                                                  FROM users WHERE account_type = ?";
                                        $stmt = $conn->prepare($query);
                                        $account_type = 2;
                                        $stmt->bind_param("i", $account_type);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>
                                                <td>{$row['full_name']}</td>
                                                <td>{$row['contact']}</td>
                                                <td>{$row['address']}</td>
                                                <td>{$row['email']}</td>
                                                <td>
                                                    <a href='edit_admin.php?id={$row['user_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                                </td>
                                            </tr>";
                                        }
                                        
                                        $stmt->close();
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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>
