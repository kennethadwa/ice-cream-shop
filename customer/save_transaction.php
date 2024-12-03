<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Database connection
include('../connection.php');

// Retrieve POST data
$user_id = $_SESSION['user_id'];
$total_amount = $_POST['total_amount'];
$payment_method = $_POST['payment_method'];
$order_type = $_POST['order_type'];
$pickup_time = isset($_POST['pickup_time']) ? $_POST['pickup_time'] : null;
// Insert the transaction into the database
$query = "INSERT INTO transactions (user_id, total_amount, payment_method, order_type, pickup_time, transaction_date) 
          VALUES (?, ?, ?, ?, ?, NOW())";

$stmt = $conn->prepare($query);
$stmt->bind_param("idsss", $user_id, $total_amount, $payment_method, $order_type, $pickup_time);


// Execute the statement
if ($stmt->execute()) {
    // Clear the user's cart after successful transaction
    $clear_cart_query = "DELETE FROM cart WHERE user_id = ?";
    $clear_stmt = $conn->prepare($clear_cart_query);
    $clear_stmt->bind_param("i", $user_id);
    $clear_stmt->execute();
    $clear_stmt->close();
    
    // Redirect to confirmation or another page with a success message
    echo "<script>
            alert('Purchase successful. Thank you for your order!');
            window.location.href = 'index.php';
          </script>";
    exit();
} else {
    echo "Error saving transaction: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
