<?php
// Include the connection file
require '../connection.php';

session_start();

// Check if the user is authorized
if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Check if the size_id is provided
if (isset($_GET['size_id'])) {
    $size_id = $_GET['size_id'];

    // Prepare and execute the delete query
    $deleteQuery = "DELETE FROM sizes WHERE size_id = ?";
    $stmt = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmt, 'i', $size_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to the view page after successful deletion
        header('Location: manage_sizes.php');
        exit();
    } else {
        echo "Error deleting size.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
