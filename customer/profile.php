<?php
session_start();
include('../connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user data from the database
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();  // Fetch user data as associative array
$stmt->close();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Check if a profile picture is uploaded
    $profile_img = null;
    if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === UPLOAD_ERR_OK) {
        $img_name = basename($_FILES['profile_img']['name']);
        $img_temp = $_FILES['profile_img']['tmp_name'];
        $upload_dir = "../assets/profile/";
        $profile_img = $upload_dir . $img_name;

        // Move the uploaded file to the destination directory
        if (!move_uploaded_file($img_temp, $profile_img)) {
            die("Error uploading the profile image.");
        }
    }

    // Check if password is provided and hash it if not empty
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE users SET address = ?, email = ?, password = ?, img = IFNULL(?, img) WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $address, $email, $hashed_password, $profile_img, $user_id);
    } else {
        // Skip password update if it's empty
        $query = "UPDATE users SET address = ?, email = ?, img = IFNULL(?, img) WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $address, $email, $profile_img, $user_id);
    }

    // Execute the update query
    if ($stmt) {
        if ($stmt->execute()) {
            echo "<script>alert('Profile updated successfully!');</script>";
        } else {
            echo "<p class='text-danger'>Error updating profile: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        die("<p class='text-danger'>Error preparing the query: " . $conn->error . "</p>");
    }
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
                <img src="<?= htmlspecialchars($user['img'] ? $user['img'] : 'https://via.placeholder.com/150') ?>" alt="Profile Picture" class="profile-pic" id="profilePreview">
            </div>
            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($user['first_name']) ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($user['last_name']) ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="contact_no" class="form-label">Contact No.</label>
                    <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?= htmlspecialchars($user['contact']) ?>" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($user['address']) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value="">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="profile_img" class="form-label">Upload New Profile Picture</label>
                <input type="file" class="form-control" id="profile_img" name="profile_img" accept="image/*" onchange="previewImage(event)">
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
    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('profilePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
