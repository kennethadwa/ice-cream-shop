<?php
session_start();
include('../connection.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items based on user_id
$query = "SELECT 
            cart.cart_id,
            cart.product_id,
            products.name AS product_name,
            cart.quantity,
            cart.additional_price,
            cart.total_price,
            dips.dip_type AS dip,
            sizes.size_name AS size,
            GROUP_CONCAT(toppings.topping_name SEPARATOR ', ') AS toppings
        FROM cart
        INNER JOIN products ON cart.product_id = products.product_id
        LEFT JOIN dips ON cart.dip_id = dips.dip_id
        LEFT JOIN sizes ON cart.size_id = sizes.size_id
        LEFT JOIN cart_toppings ON cart.cart_id = cart_toppings.cart_id
        LEFT JOIN toppings ON cart_toppings.topping_id = toppings.topping_id
        WHERE cart.user_id = ?
        GROUP BY cart.cart_id";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$cart_items = [];
$total_amount = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cart_items[] = $row;
        $total_amount += $row['total_price'];
    }
}
$stmt->close();

$delivery_fee = 100;
$total_amount_with_fee = $total_amount + $delivery_fee;

// Fetch payment methods
$payment_query = "SELECT payment_id, payment_method FROM payment";
$payment_result = $conn->query($payment_query);
$payment_methods = [];

if ($payment_result->num_rows > 0) {
    while ($method = $payment_result->fetch_assoc()) {
        $payment_methods[] = $method;
    }
}

// Fetch order types from the order_types table
$order_types_query = "SELECT order_id, order_type FROM order_types";
$order_types_result = $conn->query($order_types_query);
$order_types = [];

if ($order_types_result->num_rows > 0) {
    while ($order = $order_types_result->fetch_assoc()) {
        $order_types[] = $order;
    }
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $payment_method = $_POST['payment_method'];
    $order_type = $_POST['order_type'];
    $pickup_time = isset($_POST['pickup_time']) ? $_POST['pickup_time'] : null;  // Get pickup time if set
    $status = 'Pending';
    $transaction_date = date('Y-m-d H:i:s');

    // Insert into transactions table
    $insert_transaction_query = "INSERT INTO transactions (user_id, total_amount, payment_id, order_id, pickup_time, status, transaction_date)
                                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_transaction_query);
    
    // Correct the parameter types: "iisiss" for int, string, int, int, string, string, string
    $stmt->bind_param("iisisss", $user_id, $total_amount_with_fee, $payment_method, $order_type, $pickup_time, $status, $transaction_date);
    $stmt->execute();
    $transaction_id = $stmt->insert_id; // Get the last inserted transaction ID
    $stmt->close();

    // Insert into transaction_items table
    foreach ($cart_items as $item) {
        // Debug: Check if product_id exists
        if (empty($item['product_id'])) {
            echo "<script>alert('Missing product_id for item: " . htmlspecialchars($item['product_name']) . "');</script>";
            continue; // Skip this iteration if product_id is missing
        }

        $insert_transaction_items_query = "INSERT INTO transaction_items (transaction_id, product_id, additional_price)
                                            VALUES (?, ?, ?)";
        $stmt = $conn->prepare($insert_transaction_items_query);

        // Bind the parameters for inserting into transaction_items
        $stmt->bind_param("iis", $transaction_id, $item['product_id'], $item['additional_price']);
        $stmt->execute();
        $stmt->close();
    }

    // Empty the cart after successful order
    $delete_cart_query = "DELETE FROM cart WHERE user_id = ?";
    $stmt = $conn->prepare($delete_cart_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Display success alert
    echo "<script>alert('Purchase successful. Thank you for ordering!');</script>";

    // Redirect to a confirmation page or thank you page
    header("Location: cart.php");
    exit();
}


// Place $conn->close(); here at the end of the script, after all queries are executed
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paparazzi - Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="./css/cart.css">
</head>
<body>

    <!-- NAVIGATION BAR -->
    <?php include('navbar.php'); ?>

    <div class="container my-4">
        <h1 class="text-center">Your Cart</h1>

        <?php if (empty($cart_items)): ?>
            <div id="cart-empty" class="alert alert-warning text-center">
                Your cart is empty. Please add items to your cart.
            </div>
        <?php else: ?>

        <div class="alert alert-info text-center">
            The minimum order amount is ₱129, excluding the delivery fee.
        </div>

        <form method="POST" action="">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="color: white; text-align: center">Product</th>
                        <th style="color: white; text-align: center">Dip</th>
                        <th style="color: white; text-align: center">Size</th>
                        <th style="color: white; text-align: center">Toppings</th>
                        <th style="color: white; text-align: center">Quantity</th>
                        <th style="color: white; text-align: center">Additional Price</th>
                        <th style="color: white; text-align: center">Total Price</th>
                        <th style="color: white; text-align: center">Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($item['dip']); ?></td>
                            <td><?php echo htmlspecialchars($item['size']); ?></td>
                            <td><?php echo htmlspecialchars($item['toppings']); ?></td>
                            <td><?php echo $item['quantity']; ?></td>
                            <td>₱<?php echo number_format($item['additional_price'], 2); ?></td>
                            <td>₱<?php echo number_format($item['total_price'], 2); ?></td>
                            <td class="text-center">
                                <a href="remove_from_cart.php?cart_id=<?php echo $item['cart_id']; ?>" class="btn btn-danger">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <h3>Total Amount: ₱<?php echo number_format($total_amount, 2); ?> + ₱<?php echo number_format($delivery_fee, 2); ?> Fee</h3>
                <div>
                    <label for="payment-method" style="font-weight: bold;">Select Payment Method:</label>
                    <br>
                    <select id="payment-method" name="payment_method" class="form-select" style="width: 200px;">
                        <?php foreach ($payment_methods as $method): ?>
                            <option value="<?php echo $method['payment_id']; ?>">
                                <?php echo htmlspecialchars($method['payment_method']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <br>
                    <label for="order-type" style="font-weight: bold; margin-top: 10px;">Order Type:</label>
                    <br>
                    <select id="order-type" name="order_type" class="form-select" style="width: 200px;">
                        <?php foreach ($order_types as $order_type): ?>
                            <option value="<?php echo $order_type['order_id']; ?>">
                                <?php echo htmlspecialchars($order_type['order_type']); ?>
                            </option>

                        <?php endforeach; ?>
                    </select>

                    <br>
                    <div id="pickup-time-container" style="display: none;">
                        <label for="pickup-time" style="font-weight: bold; margin-top: 10px;">Pick-up Time:</label>
                        <input type="time" id="pickup-time" name="pickup_time" class="form-control" style="width: 200px;">
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-success btn-block">Place Order</button>
        </form>

        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="./js/cart.js"></script>

    <script>
       document.getElementById('order-type').addEventListener('change', function () {
    var orderType = this.value;
    var pickupTimeContainer = document.getElementById('pickup-time-container');

    // Check for the correct order type ID for "Pick-Up" (update the value below to match your database)
    if (orderType == '2') { // Assuming '2' is the ID for 'Pick-Up' order type in the database
        pickupTimeContainer.style.display = 'block';
    } else {
        pickupTimeContainer.style.display = 'none';
        }
    });

    </script>
</body>
</html>
