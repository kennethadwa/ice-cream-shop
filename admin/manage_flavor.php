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
                    <div class="row">

                        <!-- Left Side: Add Flavor Form -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.5); border-radius: 10px;">
                                    <form>
                                        <div class="form-group">
                                            <label for="flavorName">Flavor Name</label>
                                            <input type="text" class="form-control" id="flavorName"
                                                placeholder="Enter flavor name (e.g., Vanilla, Chocolate)">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" rows="3"
                                                placeholder="Enter description for this flavor"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-block mt-2"
                                            style="background: #FF204E; color: white;">Add Flavor</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Display All Flavors -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.5); border-radius: 10px">
                                    <ul class="list-group" id="flavor-list">
                                        <!-- Flavor Item -->
                                        <li class="list-group-item">
                                            <strong>Vanilla</strong><br>
                                            <p>Description: Classic and creamy.</p>
                                            <button class="btn btn-sm" style="background: green; color: white;">Edit</button>
                                            <button class="btn btn-sm" style="background: red; color: white;">Delete</button>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Chocolate</strong><br>
                                            <p>Description: Rich and smooth.</p>
                                            <button class="btn btn-sm" style="background: green; color: white;">Edit</button>
                                            <button class="btn btn-sm" style="background: red; color: white;">Delete</button>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Strawberry</strong><br>
                                            <p>Description: Sweet and fruity.</p>
                                            <button class="btn btn-sm" style="background: green; color: white;">Edit</button>
                                            <button class="btn btn-sm" style="background: red; color: white;">Delete</button>
                                        </li>
                                    </ul>
                                    <!-- Pagination controls -->
                                    <nav>
                                        <ul class="pagination justify-content-center">
                                            <li class="page-item active">
                                                <a class="page-link" href="#">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a class="page-link" href="#">3</a>
                                            </li>
                                        </ul>
                                    </nav>
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
