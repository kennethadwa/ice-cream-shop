<?php
// Database connection
include('../connection.php');

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Check if dip_id is set
if (isset($_GET['dip_id'])) {
    $dip_id = $_GET['dip_id'];

    // Fetch dip details
    $query = "SELECT * FROM dips WHERE dip_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $dip_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $dip = $result->fetch_assoc();
    } else {
        echo "Dip not found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dip_id = $_POST['dip_id'];
    $dip_type = $_POST['dip_type'];
    $additional_price = $_POST['additional_price'];

    // Update dip details in the database
    $update_query = "UPDATE dips SET dip_type = ?, additional_price = ? WHERE dip_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sdi", $dip_type, $additional_price, $dip_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Dip updated successfully!'); window.location.href='manage_dips.php';</script>";
    } else {
        echo "<script>alert('Error updating dip.');</script>";
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

    <title>Edit Dip - Paparazzi</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <div id="wrapper">

        <?php include('sidebar.php'); ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <?php include('navbar.php'); ?>

                <div class="container-fluid mt-5">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.5); border-radius: 10px;">
                                    <form action="" method="POST">
                                        <div class="form-group">
                                            <label for="dipType">Dip Type</label>
                                            <input type="text" class="form-control" id="dipType" name="dip_type" 
                                                placeholder="Enter dip type" value="<?php echo htmlspecialchars($dip['dip_type']); ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="additionalPrice">Additional Price</label>
                                            <input type="number" step="0.01" class="form-control" id="additionalPrice" name="additional_price" 
                                                placeholder="Enter additional price" value="<?php echo htmlspecialchars($dip['additional_price']); ?>" required>
                                        </div>
                                        <input type="hidden" name="dip_id" value="<?php echo $dip['dip_id']; ?>">
                                        <button type="submit" class="btn btn-block mt-2" style="background: #FF204E; color: white;">Update Dip</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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
