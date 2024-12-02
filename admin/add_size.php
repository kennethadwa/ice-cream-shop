<?php
// Include your database connection file
include('../connection.php');

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Handle adding a new size
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_size'])) {
    $size_name = mysqli_real_escape_string($conn, $_POST['size_name']);
    $additional_price = mysqli_real_escape_string($conn, $_POST['additional_price']);
    
    // Insert new size into the sizes table
    $sql = "INSERT INTO sizes (size_name, additional_price) VALUES ('$size_name', '$additional_price')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Size added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding size: " . mysqli_error($conn) . "');</script>";
    }
}

// Fetch all sizes
$sql_sizes = "SELECT * FROM sizes";
$result_sizes = mysqli_query($conn, $sql_sizes);

// Pagination setup
$records_per_page = 3; // Number of records per page
$page = isset($_GET['page']) ? $_GET['page'] : 1; // Get current page or default to 1
$start_from = ($page - 1) * $records_per_page; // Calculate the starting point

// Fetch sizes with LIMIT for pagination
$sql_sizes = "SELECT * FROM sizes LIMIT $start_from, $records_per_page";
$result_sizes = mysqli_query($conn, $sql_sizes);

// Get total number of records for pagination
$sql_count = "SELECT COUNT(*) FROM sizes";
$result_count = mysqli_query($conn, $sql_count);
$row_count = mysqli_fetch_array($result_count);
$total_records = $row_count[0];
$total_pages = ceil($total_records / $records_per_page);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Manage Sizes - Paparazzi</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>

        #content{
          background: linear-gradient(135deg, #f9e5d9, #c3e7c4, #ffefbb);
        }
        
        .list-group-item img {
            width: 100px;
            height: 100px;
            float: left;
            margin-right: 15px;
        }
    </style>
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include('sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!--NAVBAR-->
            <?php include ('navbar.php'); ?>

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid mt-5">
                    <!-- Row for Form and Sizes Display -->
                    <div class="row d-flex justify-content-center">
                        <!-- Left Side: Add Size Form -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.5); border-radius: 10px;">
                                    <form method="POST" action="manage_size.php">
                                        <div class="form-group">
                                            <label for="sizeName">Size</label>
                                            <input type="text" class="form-control" id="sizeName" name="size_name"
                                                placeholder="Enter size name (e.g., Small, Medium, Large)" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="additionalPrice">Additional Price</label>
                                            <input type="number" class="form-control" name="additional_price" required>
                                        </div>
                                        <button type="submit" name="add_size" class="btn btn-block mt-2" style="background: #FF204E; color: white;">Add Size</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
