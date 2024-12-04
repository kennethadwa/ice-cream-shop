<?php
include('../connection.php');

session_start();


if (!isset($_SESSION['user_id']) || $_SESSION['account_type'] != 3) {
    header("Location: ../login.php");
    exit;
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paparazzi - My Account</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Raleway:wght@400;500&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #fbe9e7;
        }
        .container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
    </style>
</head>
<body>

    <!-- NAVIGATION BAR -->
    <?php include('navbar.php'); ?>

    <div class="container my-5">
        <h1 class="text-center">My Account</h1>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
