<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Database connection
include('../connection.php');

// Check if product_id is passed
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];
    $user_id = $_SESSION['user_id'];

    // Prepare SQL to delete item from cart
    $query = "DELETE FROM cart WHERE product_id = ? AND user_id = ?";

    // Prepare and execute query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ii", $product_id, $user_id);  // Bind parameters to the query
        $stmt->execute();

        // Check if the item was deleted
        if ($stmt->affected_rows > 0) {
            header("Location: cart.php?msg=Item removed successfully.");
            exit();
        } else {
            header("Location: cart.php?msg=Item not found in your cart.");
            exit();
        }
    } else {
        header("Location: cart.php?msg=Error occurred while removing item.");
        exit();
    }
} elseif (isset($_GET['cart_id'])) {
    $cart_id = $_GET['cart_id'];
    $user_id = $_SESSION['user_id'];

    // Prepare SQL to delete item from cart using cart_id
    $query = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";

    // Prepare and execute query
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("ii", $cart_id, $user_id);  // Bind parameters to the query
        $stmt->execute();

        // Check if the item was deleted
        if ($stmt->affected_rows > 0) {
            header("Location: cart.php?msg=Item removed successfully.");
            exit();
        } else {
            header("Location: cart.php?msg=Item not found in your cart.");
            exit();
        }
    } else {
        header("Location: cart.php?msg=Error occurred while removing item.");
        exit();
    }
} else {
    // If no valid parameter is provided
    header("Location: cart.php?msg=Invalid request.");
    exit();
}
?>
