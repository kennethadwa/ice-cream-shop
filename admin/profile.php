<?php
include('../connection.php');

session_start();


if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id']; // Get the logged-in user's ID

// Debugging: Check if the session is set
error_log("User ID from session: " . $user_id);

// Fetch current user data
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Debugging: Check the result
if ($user) {
    error_log("User data fetched: " . print_r($user, true));
} else {
    error_log("No data found for user ID: " . $user_id);
}

$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Log $_POST array to check values
    error_log(print_r($_POST, true));

    // Assign values from POST or use current user values if not set
    $address = isset($_POST['address']) && !empty($_POST['address']) ? htmlspecialchars($_POST['address']) : $user['address'];
    $email = isset($_POST['email']) && !empty($_POST['email']) ? htmlspecialchars($_POST['email']) : $user['email'];
    $password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';
    
    // Debugging: Log variables to check final values
    error_log("Address: $address, Email: $email, Password: " . (empty($password) ? "Not Updated" : "Updated"));

    // Handle profile picture upload
    $profile_img = null;
    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
        $img_name = basename($_FILES['profile_img']['name']);
        $img_temp = $_FILES['profile_img']['tmp_name'];
        $upload_dir = "../assets/profile/";
        $profile_img = $upload_dir . $img_name;

        if (!move_uploaded_file($img_temp, $profile_img)) {
            die("Error uploading the profile image.");
        }
    }

    // Update the database
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "UPDATE users SET password = ?, address = ?, email = ?, img = IFNULL(?, img) WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $hashed_password, $address, $email, $profile_img, $user_id);
    } else {
        $query = "UPDATE users SET address = ?, email = ?, img = IFNULL(?, img) WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $address, $email, $profile_img, $user_id);
    }

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<p class='text-danger'>Error updating profile: " . $stmt->error . "</p>";
    }
    $stmt->close();
    $conn->close();
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
    <title>Admin Accounts</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #fbe9e7;
        }
        h1 {
            font-family: 'Pacifico', cursive;
            color: #ff6b81;
            margin-bottom: 20px;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }
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

        <!--NAVBAR-->
         <?php include ('navbar.php'); ?>

         <!-- Main Content -->
        <div id="content">

        <div class="container my-5" style="padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);">
        <form action="profile.php" method="post" enctype="multipart/form-data">
            <div class="text-center">
                <img src="<?= htmlspecialchars($user['img'] ? $user['img'] : 'https://via.placeholder.com/150') ?>" alt="Profile Picture" class="profile-pic">
            </div>
            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" 
                        placeholder="<?= isset($user['first_name']) ? htmlspecialchars($user['first_name']) : 'Enter first name' ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" 
                        placeholder="<?= isset($user['last_name']) ? htmlspecialchars($user['last_name']) : 'Enter last name' ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact_no" class="form-label">Contact No.</label>
                    <input type="text" class="form-control" id="contact_no" name="contact_no" 
                        placeholder="<?= isset($user['contact']) ? htmlspecialchars($user['contact']) : 'Enter contact no' ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" 
                        value="<?= isset($user['address']) ? htmlspecialchars($user['address']) : '' ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" 
                        value="<?= isset($user['email']) ? htmlspecialchars($user['email']) : '' ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="profile_img" class="form-label">Upload New Profile Picture</label>
                <input type="file" class="form-control" id="profile_img" name="profile_img" accept="image/*">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success mt-3">
                    <i class="bi bi-save"></i> Update Profile
                </button>
            </div>
        </form>
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
