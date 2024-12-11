<?php
// Include the connection file
require '../connection.php';

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Pagination logic
$limit = 8; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch total records count
$totalQuery = "SELECT COUNT(*) AS total FROM toppings";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch paginated toppings
$query = "SELECT topping_id, topping_name, additional_price FROM toppings LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

// Check for successful deletion
if (isset($_GET['status']) && $_GET['status'] == 'deleted') {
    echo "<script>alert('Topping deleted successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Toppings - Paparazzi</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
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
                <div class="container-fluid mt-3">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-12">
                           <div class="card shadow mb-4">
                               <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                   <h6 class="m-0 font-weight-bold text-primary">Toppings List</h6>
                                   <a href="add_topping.php" class="btn btn-primary btn-sm">
                                       <i class="fas fa-plus"></i> Add New Topping
                                   </a>
                               </div>
                               <div class="card-body">
                                   <div class="table-responsive">
                                       <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                           <thead>
                                               <tr>
                                                   <th>Topping ID</th>
                                                   <th>Topping Name</th>
                                                   <th>Additional Price</th>
                                                   <th class='d-flex justify-content-center'>Actions</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                              <?php
                                              if (mysqli_num_rows($result) > 0) {
                                                  while ($row = mysqli_fetch_assoc($result)) {
                                                      echo "<tr>";
                                                      echo "<td>" . htmlspecialchars($row['topping_id']) . "</td>";
                                                      echo "<td>" . htmlspecialchars($row['topping_name']) . "</td>";
                                                      echo "<td>" . htmlspecialchars(number_format($row['additional_price'], 2)) . "</td>";
                                                      echo "<td class='d-flex justify-content-center'>
                                                              <a href='edit_topping.php?topping_id=" . $row['topping_id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                                              &nbsp;
                                                              <a href='delete_topping.php?id=" . $row['topping_id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                                                           </td>";
                                                      echo "</tr>";
                                                  }
                                              } else {
                                                  echo "<tr><td colspan='4' class='text-center'>No toppings found</td></tr>";
                                              }
                                              ?>
                                          </tbody>
                                       </table>
                                   </div>
                               </div>
                               <div class="card-footer">
                                   <nav>
                                       <ul class="pagination justify-content-center">
                                           <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                               <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                                   <a class="page-link" href="view_toppings.php?page=<?php echo $i; ?>">
                                                       <?php echo $i; ?>
                                                   </a>
                                               </li>
                                           <?php endfor; ?>
                                       </ul>
                                   </nav>
                               </div>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <i class="fas fa-angle-up"></i>
    </a>

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
