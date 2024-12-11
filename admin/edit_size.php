<?php
// Include database connection
include('../connection.php');

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Check if size_id is set in the URL or form
if (isset($_GET['size_id']) || isset($_POST['size_id'])) {
    $size_id = isset($_GET['size_id']) ? $_GET['size_id'] : $_POST['size_id'];

    // Fetch size details from the database
    $query = "SELECT * FROM sizes WHERE size_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $size_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the row data
        $size_data = $result->fetch_assoc();
        $size_name = $size_data['size_name'];
        $additional_price = $size_data['additional_price'];
    } else {
        // If no size is found, redirect or show an error message
        echo "Size not found.";
        exit;
    }
}

// Handle form submission to update the size
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $size_name = $_POST['sizeName'];
    $additional_price = $_POST['additionalPrice'];

    // Update the size in the database
    $update_query = "UPDATE sizes SET size_name = ?, additional_price = ? WHERE size_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sdi", $size_name, $additional_price, $size_id);

    if ($update_stmt->execute()) {
        // Success message
        echo "<script>alert('Size updated successfully!'); window.location.href='manage_size.php';</script>";
    } else {
        // Error message
        echo "<script>alert('Error updating size. Please try again.');</script>";
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

    <title>Edit Size - Paparazzi</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .card {
            box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.5);
            border-radius: 10px;
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

                    <!-- Edit Size Form -->
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mb-4">Edit Size</h4>
                                    <form action="edit_size.php" method="POST">
                                        <div class="form-group">
                                            <label for="sizeName">Size</label>
                                            <input type="text" class="form-control" id="sizeName" name="sizeName"
                                                placeholder="Enter size name" value="<?php echo $size_name; ?>" required>
                                        </div>
                                        <div class="form-group mt-3">
                                            <label for="additionalPrice">Additional Price</label>
                                            <input type="number" class="form-control" id="additionalPrice" name="additionalPrice" value="<?php echo $additional_price; ?>" required>
                                        </div>
                                        <input type="hidden" name="size_id" value="<?php echo $size_id; ?>">
                                        <button type="submit" class="btn btn-block mt-3" style="background: #FF204E; color: white;">Update Size</button>
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
