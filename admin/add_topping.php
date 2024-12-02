<?php
// Include your database connection file
include('../connection.php');

// Handle adding a new topping
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_topping'])) {
    $topping_name = mysqli_real_escape_string($conn, $_POST['topping_name']);
    $additional_price = mysqli_real_escape_string($conn, $_POST['additional_price']);
    
    $sql = "INSERT INTO toppings (topping_name, additional_price) VALUES ('$topping_name', '$additional_price')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Topping added successfully!');</script>";
        echo "<script>window.location.href='manage_toppings.php';</script>";
    } else {
        echo "<script>alert('Error adding topping: " . mysqli_error($conn) . "');</script>";
    }
}

// Handle pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 3;
$offset = ($page - 1) * $limit;

// Fetch toppings with pagination
$sql_toppings = "SELECT * FROM toppings LIMIT $limit OFFSET $offset";
$result_toppings = mysqli_query($conn, $sql_toppings);

// Count total toppings for pagination
$sql_count = "SELECT COUNT(*) AS total FROM toppings";
$total_result = mysqli_query($conn, $sql_count);
$total_row = mysqli_fetch_assoc($total_result);
$total_toppings = $total_row['total'];
$total_pages = ceil($total_toppings / $limit);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Toppings - Paparazzi</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        #content {
            background: linear-gradient(135deg, #f9e5d9, #c3e7c4, #ffefbb);
        }

        .list-group-item {
            margin-bottom: 15px;
        }

        .list-group-item strong {
            font-size: 16px;
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
                  <div class="row d-flex justify-content-center">
                      <!-- Left Side: Add Topping Form -->
                      <div class="col-md-6">
                          <div class="card">
                              <div class="card-body" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.5); border-radius: 10px;">
                                  <form method="POST" action="add_topping.php">
                              <div class="form-group">
                                  <label for="toppingName">Topping Name</label>
                                  <input type="text" class="form-control" id="toppingName" name="topping_name" placeholder="Enter topping name" required>
                              </div>
                              <div class="form-group">
                                  <label for="additionalPrice">Additional Price</label>
                                  <input type="number" class="form-control" id="additionalPrice" name="additional_price" required>
                              </div>
                              <button type="submit" name="add_topping" class="btn btn-block mt-2" style="background: #FF204E; color: white;">Add Topping</button>
                          </form>
                      </div>
                  </div>
              </div>
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
