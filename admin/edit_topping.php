<?php
// Database connection
include('../connection.php');

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Check if topping_id is provided in the URL
if (isset($_GET['topping_id'])) {
    $topping_id = $_GET['topping_id'];

    // Fetch the current topping details
    $query = "SELECT * FROM toppings WHERE topping_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $topping_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $topping = $result->fetch_assoc();

    if (!$topping) {
        echo "<script>alert('Topping not found!'); window.location.href='manage_toppings.php';</script>";
        exit;
    }
} else {
    echo "<script>alert('No topping selected!'); window.location.href='manage_toppings.php';</script>";
    exit;
}

// Update the topping on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $topping_name = $_POST['topping_name'];
    $additional_price = $_POST['additional_price'];

    // Update query
    $update_query = "UPDATE toppings SET topping_name = ?, additional_price = ? WHERE topping_id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sdi", $topping_name, $additional_price, $topping_id);

    if ($stmt->execute()) {
        echo "<script>alert('Topping updated successfully!'); window.location.href='manage_toppings.php';</script>";
    } else {
        echo "<script>alert('Failed to update topping!');</script>";
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

    <title>Edit Topping - Paparazzi</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
     
        #content {
            background: linear-gradient(135deg, #f9e5d9, #c3e7c4, #ffefbb);
        }
  
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fc;
        }

        .card {
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .btn-update {
            background-color: #FF204E;
            color: white;
        }

        .btn-update:hover {
            background-color: #cc1a3d;
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
          <?php include('navbar.php'); ?>

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid mt-5">

                    <!-- Row for Edit Topping Form -->
                    <div class="row justify-content-center">

                        <!-- Edit Topping Form -->
                        <div class="container mt-2">
                               <div class="row justify-content-center">
                                   <div class="col-md-6">
                                       <div class="card p-4">
                                           <h4 class="text-center mb-4">Edit Topping</h4>
                                           <form method="POST">
                                             <div class="mb-3">
                                                 <label for="toppingName" class="form-label">Topping Name</label>
                                                 <input type="text" class="form-control" id="toppingName" name="topping_name" 
                                                     value="<?php echo htmlspecialchars($topping['topping_name']); ?>" required>
                                             </div>
                                             <div class="mb-3">
                                                 <label for="additionalPrice" class="form-label">Additional Price</label>
                                                 <input type="number" step="0.01" class="form-control" id="additionalPrice" name="additional_price" 
                                                     value="<?php echo htmlspecialchars($topping['additional_price']); ?>" required>
                                             </div>
                                             <button type="submit" class="btn btn-update btn-block">Update Topping</button>
                                         </form>
                                       </div>
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
