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
$totalQuery = "SELECT COUNT(*) AS total FROM dips";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalRow['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch paginated dips
$query = "SELECT dip_id, dip_type, additional_price FROM dips LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

// Check for successful deletion
if (isset($_GET['status']) && $_GET['status'] == 'deleted') {
    echo "<script>alert('Dip deleted successfully');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dips - Paparazzi</title>
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
                                   <h6 class="m-0 font-weight-bold text-primary">Dips List</h6>
                                   <a href="add_dip.php" class="btn btn-primary btn-sm">
                                       <i class="fas fa-plus"></i> Add New Dip
                                   </a>
                               </div>
                               <div class="card-body">
                                   <div class="table-responsive">
                                       <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                           <thead>
                                               <tr>
                                                   <th>Dip ID</th>
                                                   <th>Dip Type</th>
                                                   <th>Additional Price</th>
                                                   <th class='d-flex justify-content-center'>Actions</th>
                                               </tr>
                                           </thead>
                                           <tbody>
                                                  <?php
                                                  if (mysqli_num_rows($result) > 0) {
                                                      while ($row = mysqli_fetch_assoc($result)) {
                                                          echo "<tr>";
                                                          echo "<td>" . htmlspecialchars($row['dip_id']) . "</td>";
                                                          echo "<td>" . htmlspecialchars($row['dip_type']) . "</td>";
                                                          echo "<td>" . htmlspecialchars(number_format($row['additional_price'], 2)) . "</td>";
                                                          echo "<td class='d-flex justify-content-center'>
                                                                  <a href='edit_dip.php?dip_id=" . $row['dip_id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                                                                  &nbsp;
                                                                  <a href='delete_dip.php?id=" . $row['dip_id'] . "' class='btn btn-danger btn-sm'>Delete</a>
                                                                </td>";
                                                          echo "</tr>";
                                                      }
                                                  } else {
                                                      echo "<tr><td colspan='4' class='text-center'>No dips found</td></tr>";
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
                                                   <a class="page-link" href="view_dips.php?page=<?php echo $i; ?>">
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

    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
