<?php
// Include database connection
include('../connection.php');

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Add a new dip
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dip_type'], $_POST['additional_price'])) {
    $dip_type = $_POST['dip_type'];
    $additional_price = $_POST['additional_price'];

    $query = "INSERT INTO dips (dip_type, additional_price) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sd", $dip_type, $additional_price);

    if ($stmt->execute()) {
        echo "<script>alert('Dip added successfully!'); window.location.href = 'manage_dips.php';</script>";
    } else {
        echo "<script>alert('Failed to add dip.');</script>";
    }
}

// Delete a dip
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    $query = "DELETE FROM dips WHERE dip_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<script>alert('Dip deleted successfully!'); window.location.href = 'manage_dips.php';</script>";
    } else {
        echo "<script>alert('Failed to delete dip.');</script>";
    }
}

// Pagination variables
$items_per_page = 3;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $items_per_page;

// Fetch dips for current page
$query = "SELECT * FROM dips LIMIT ?, ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $offset, $items_per_page);
$stmt->execute();
$result = $stmt->get_result();
$dips = $result->fetch_all(MYSQLI_ASSOC);

// Fetch total number of dips for pagination
$query_total = "SELECT COUNT(*) as total FROM dips";
$total_result = $conn->query($query_total);
$total_row = $total_result->fetch_assoc();
$total_items = $total_row['total'];
$total_pages = ceil($total_items / $items_per_page);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Flavors - Paparazzi</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
      #content{
          background: linear-gradient(135deg, #f9e5d9, #c3e7c4, #ffefbb);
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

            <!-- Main Content -->
            <div id="content">

             <!--NAVBAR-->
         <?php include ('navbar.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid mt-5">

                    <!-- Row for Form and Flavors Display -->
                    <div class="row d-flex justify-content-center">

                        <!-- Left Side: Add Flavor Form -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.5); border-radius: 10px;">
                                    <form method="POST">
                                        <div class="form-group">
                                            <label for="dipName">Dip Name</label>
                                            <input type="text" class="form-control" id="dipName" name="dip_type" placeholder="Enter dip name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="additionalPrice">Additional Price</label>
                                            <input type="number" step="0.01" class="form-control" id="additionalPrice" name="additional_price" placeholder="Enter additional price" required>
                                        </div>
                                        <button type="submit" class="btn btn-block mt-2" style="background: #FF204E; color: white;">Add Dip</button>
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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
