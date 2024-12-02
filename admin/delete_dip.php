<?php
// Include the connection file
require '../connection.php';

session_start();

// Check if user is logged in and authorized
if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Get the dip ID to delete
if (isset($_GET['id'])) {
    $dip_id = (int)$_GET['id'];

    // Delete query
    $query = "DELETE FROM dips WHERE dip_id = $dip_id";
    if (mysqli_query($conn, $query)) {
        header('Location: manage_dips.php?status=deleted');
    } else {
        echo "<script>alert('Error deleting dip.');</script>";
    }
} else {
    echo "<script>alert('Invalid dip ID.');</script>";
}
?>
