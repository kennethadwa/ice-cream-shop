<?php
include('../connection.php');

session_start();

if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

$customer_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($customer_id === 0) {
    die("Invalid customer ID.");
}

// Fetch customer data based on ID
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $profile_img = null;
    $first_name = htmlspecialchars($_POST['first_name']);
    $last_name = htmlspecialchars($_POST['last_name']);
    $contact = htmlspecialchars($_POST['contact']);

    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
        $img_name = basename($_FILES['profile_img']['name']);
        $img_temp = $_FILES['profile_img']['tmp_name'];
        $upload_dir = "../assets/profile/";
        $profile_img = $upload_dir . $img_name;

        if (!move_uploaded_file($img_temp, $profile_img)) {
            die("Error uploading the profile image.");
        }
    }

    $query = $password 
    ? "UPDATE users SET first_name = ?, last_name = ?, contact = ?, password = ?, address = ?, email = ?, img = IFNULL(?, img) WHERE user_id = ?"
    : "UPDATE users SET first_name = ?, last_name = ?, contact = ?, address = ?, email = ?, img = IFNULL(?, img) WHERE user_id = ?";

$stmt = $conn->prepare($query);

if ($password) {
    $stmt->bind_param("sssssssi", $first_name, $last_name, $contact, $password, $address, $email, $profile_img, $user_id);
} else {
    $stmt->bind_param("ssssssi", $first_name, $last_name, $contact, $address, $email, $profile_img, $user_id);
}

    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!');</script>";
    } else {
        echo "<p class='text-danger'>Error updating profile: " . $stmt->error . "</p>";
    }

    $stmt->close();
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
    <div id="wrapper">
        <?php include('sidebar.php'); ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include('navbar.php'); ?>
            <div id="content">
                <div class="container my-5" style="padding: 30px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);">
                    <form action="edit_customer.php" method="post" enctype="multipart/form-data">
                        <div class="text-center">
                            <img src="<?= htmlspecialchars($user['img'] ? $user['img'] : 'https://via.placeholder.com/150') ?>" alt="Profile Picture" class="profile-pic">
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                    value="<?= htmlspecialchars($user['first_name']) ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                    value="<?= htmlspecialchars($user['last_name']) ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact" class="form-label">Contact</label>
                                <input type="text" class="form-control" id="contact" name="contact" 
                                    value="<?= htmlspecialchars($user['contact']) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" 
                                    value="<?= htmlspecialchars($user['address']) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                    value="<?= htmlspecialchars($user['email']) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="profile_img" class="form-label">Upload New Profile Picture</label>
                                <input type="file" class="form-control" id="profile_img" name="profile_img" accept="image/*">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success mt-3">Update Customer</button>
                        </div>
                    </form>
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


