<?php
// Include the connection file
require '../connection.php';

session_start();

// Check if the user is logged in and has appropriate access
if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Check if the 'id' is provided in the URL
if (isset($_GET['id'])) {
    $topping_id = (int)$_GET['id'];

    // Prepare the DELETE query
    $query = "DELETE FROM toppings WHERE topping_id = $topping_id";
    
    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect to view_toppings.php with a success message
        header('Location: manage_toppings.php?status=deleted');
    } else {
        // If the query failed, show an error message
        echo "<script>alert('Error deleting topping. Please try again.');</script>";
        header('Location: manage_toppings.php');
    }
} else {
    // If no ID is provided, redirect back to the view_toppings page
    header('Location: view_toppings.php');
}

?>
