<?php
session_start();
require_once '../connection.php'; // Include database connection

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Check if customer ID is provided
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Fetch customer details
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    // If no customer is found, redirect or show an error
    if (!$customer) {
        echo "<script>alert('Customer not found.'); window.location.href='customer_accounts.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('No customer ID provided.'); window.location.href='customer_accounts.php';</script>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $age = $_POST['age'] ?? 0;
    $contact_number = $_POST['contact_number'] ?? '';
    $address = $_POST['address'] ?? '';
    $email = $_POST['email'] ?? '';
    $profile_image = $_FILES['profile_image']['name'];

    if ($profile_image) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile_image);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file);
    } else {
        $target_file = $customer['profile_image']; // Keep the current image
    }

    $update_query = "UPDATE customers SET full_name = ?, age = ?, contact_number = ?, address = ?, email = ?, profile_image = ? WHERE customer_id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sissssi", $full_name, $age, $contact_number, $address, $email, $target_file, $customer_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Customer details updated successfully.'); window.location.href='customer_accounts.php';</script>";
    } else {
        echo "<div class='alert alert-danger'>Error updating customer details.</div>";
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
            <?php include('navbar.php'); ?>

            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container my-5">
                    <div class="row justify-content-center">
                        <div class="col-md-8 col-lg-6">
                            <div class="card">
                                <div class="card-header text-center bg-primary text-white">
                                    <h5 class="mb-0">Edit Customer Details</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="edit_customer.php?id=<?php echo $customer_id; ?>" enctype="multipart/form-data">
    <!-- Profile Picture -->
    <div class="text-center mb-4">
        <img id="imagePreview" 
             src="<?php echo !empty($customer['profile_image']) ? $customer['profile_image'] : 'https://img.icons8.com/color/96/administrator-male.png'; ?>" 
             alt="Profile Picture" 
             class="rounded-circle" 
             width="96" 
             height="96">
    </div>

    <!-- Profile Picture Upload -->
    <div class="form-group mb-3">
        <label for="profile_image" class="form-label">Upload Profile Picture</label>
        <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
    </div>

    <!-- Full Name -->
    <div class="form-group mb-3">
        <label for="full_name" class="form-label">Full Name</label>
        <input type="text" 
               class="form-control" 
               id="full_name" 
               name="full_name" 
               value="<?php echo htmlspecialchars($customer['full_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
               required>
    </div>

    <!-- Age -->
    <div class="form-group mb-3">
        <label for="age" class="form-label">Age</label>
        <input type="number" 
               class="form-control" 
               id="age" 
               name="age" 
               value="<?php echo htmlspecialchars($customer['age'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
               required>
    </div>

    <!-- Contact Number -->
    <div class="form-group mb-3">
        <label for="contact_number" class="form-label">Contact Number</label>
        <input type="text" 
               class="form-control" 
               id="contact_number" 
               name="contact_number" 
               value="<?php echo htmlspecialchars($customer['contact_number'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
               required>
    </div>

    <!-- Address -->
    <div class="form-group mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" 
               class="form-control" 
               id="address" 
               name="address" 
               value="<?php echo htmlspecialchars($customer['address'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
               required>
    </div>

    <!-- Email -->
    <div class="form-group mb-4">
        <label for="email" class="form-label">Email</label>
        <input type="email" 
               class="form-control" 
               id="email" 
               name="email" 
               value="<?php echo htmlspecialchars($customer['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" 
               required>
    </div>

    <!-- Submit Button -->
    <div class="d-flex justify-content-between">
        <a href="customer_accounts.php" class="btn btn-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Update Customer</button>
    </div>
</form>


                                </div>
                            </div>
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