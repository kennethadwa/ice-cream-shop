<?php
include('../connection.php');

// Check if the user is authorized (same logic as in your main file)
session_start();
if (!isset($_SESSION['user_id']) || ($_SESSION['account_type'] != 1 && $_SESSION['account_type'] != 2)) {
    header('Location: login.php');
    exit();
}

// Check if a transaction_id is provided
if (isset($_GET['transaction_id'])) {
    $transaction_id = $_GET['transaction_id'];

    // Prepare and execute the deletion query
    $query = "DELETE FROM transactions WHERE transaction_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $transaction_id);

    if ($stmt->execute()) {
        header('Location: cancelled_orders.php');
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "No transaction ID provided.";
}

$conn->close();
?>
