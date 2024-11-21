<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Edit Customer Accounts</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
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

                    <!-- Edit Form -->
                    <div class="card mb-4" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.5);">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Customer Details</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="edit_customer.php" enctype="multipart/form-data">
                                <!-- Image Holder Above Full Name with Online Image -->
                                <div class="form-group text-center mb-4">
                                    <img width="88" height="88" src="https://img.icons8.com/color/48/administrator-male-skin-type-7.png" alt="administrator-male-skin-type-7" style="border: 1px solid black; padding: 10px; border-radius: 50%;"/>
                                </div>

                                <!-- Full Name Input -->
                                <div class="form-group">
                                    <label for="full_name">Full Name</label>
                                    <input type="text" class="form-control" id="full_name" name="full_name" required>
                                </div>

                                <!-- Age Input -->
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="number" class="form-control" id="age" name="age" required>
                                </div>

                                <!-- Contact Number Input -->
                                <div class="form-group">
                                    <label for="contact_number">Contact Number</label>
                                    <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                                </div>

                                <!-- Address Input -->
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" required>
                                </div>

                                <!-- Email Input -->
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>

                                <!-- Image Upload Input -->
                                <div class="form-group">
                                    <label for="profile_image">Upload Profile Picture</label>
                                    <input type="file" class="form-control-file" id="profile_image" name="profile_image" accept="image/*">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Update Customer</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- End of Page Content -->
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

    <!-- Image Preview Script -->
    <script>
        document.getElementById('profile_image').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();
            
            reader.onload = function() {
                document.getElementById('imagePreview').src = reader.result;
            };
            
            if (file) {
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>

</html>
