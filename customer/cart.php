<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Database connection
include('../connection.php');

// Retrieve user_id from session
$user_id = $_SESSION['user_id'];

// Query to fetch cart items
$query = "SELECT 
              cart.product_id, 
              products.name AS product_name, 
              cart.quantity, 
              products.price, 
              cart.additional_price, 
              (cart.quantity * products.price + cart.additional_price) AS total_price, 
              users.address AS delivery_address, 
              dips.dip_type AS dip, 
              sizes.size_name AS size, 
              GROUP_CONCAT(toppings.topping_name SEPARATOR ', ') AS toppings
          FROM cart 
          INNER JOIN products ON cart.product_id = products.product_id 
          INNER JOIN users ON cart.user_id = users.user_id
          LEFT JOIN dips ON cart.dip_id = dips.dip_id
          LEFT JOIN sizes ON cart.size_id = sizes.size_id
          LEFT JOIN cart_toppings ON cart.cart_id = cart_toppings.cart_id
          LEFT JOIN toppings ON cart_toppings.topping_id = toppings.topping_id
          WHERE cart.user_id = ? 
          GROUP BY cart.cart_id";

// Prepare and execute query
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id); 
$stmt->execute();
$result = $stmt->get_result();

// Check if query returns results
if ($result->num_rows > 0) {
    // Initialize variables
    $cart_items = [];
    $total_amount = 0;

    // Fetch all cart items
    while ($item = $result->fetch_assoc()) {
        $cart_items[] = $item;
        $total_amount += $item['total_price']; 
    }

    // Add delivery fee to the total amount
    $delivery_fee = 80; // Fixed delivery fee
    $total_amount_with_fee = $total_amount + $delivery_fee; 

    $cart_empty = empty($cart_items);

} else {
  
    $cart_empty = true;
}

$stmt->close();
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

        <!-- If Cart is Empty -->
        <?php if ($cart_empty): ?>
            <div id="cart-empty" class="alert alert-warning text-center">
                Your cart is empty. Please add items to your cart.
            </div>
        <?php else: ?>

        <!-- Message about minimum order amount -->
        <div class="alert alert-info text-center">
            The minimum order amount is ₱129, excluding the delivery fee.
        </div>

        <!-- Cart Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="color: white; text-align: center">Product</th>
                    <th style="color: white; text-align: center">Delivery Address</th>
                    <th style="color: white; text-align: center">Dip</th>
                    <th style="color: white; text-align: center">Size</th>
                    <th style="color: white; text-align: center">Toppings</th>
                    <th style="color: white; text-align: center">Quantity</th>
                    <th style="color: white; text-align: center">Additional Price</th>
                    <th style="color: white; text-align: center">Total Price</th>
                    <th style="color: white; text-align: center;">Remove</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td class="cart-item-name"><?php echo htmlspecialchars($item['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($item['delivery_address']); ?></td>
                        <td><?php echo htmlspecialchars($item['dip']); ?></td>
                        <td><?php echo htmlspecialchars($item['size']); ?></td>
                        <td><?php echo htmlspecialchars($item['toppings']); ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>₱<?php echo number_format($item['additional_price'], 2); ?></td>
                        <td>₱<?php echo number_format($item['total_price'], 2); ?></td>
                        <td class="text-center">
                            <a href="remove_from_cart.php?product_id=<?php echo $item['product_id']; ?>" class="btn btn-danger">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <h3>Total Amount: ₱<?php echo number_format($total_amount, 2) . " + 80 Delivery/Reservation Fee"; ?></h3>
            <div>
                <label for="payment-method" style="font-weight: bold;">Select Payment Method:</label>
                <br>
                <select id="payment-method" class="form-select" style="width: 200px;">
                    <option value="cod">Cash on Delivery (COD)</option>
                </select>
                <br>
                <label for="order-type" style="font-weight: bold; margin-top: 10px;">Order Type:</label>
                <br>
                <select id="order-type" class="form-select" style="width: 200px;">
                    <option value="For Delivery">For Delivery</option>
                    <option value="For Pickup">For Pick Up</option>
                </select>

                <br>
                <!-- Pickup Time Input -->
                <div id="pickup-time-container" style="display: none; margin-top: 10px;">
                    <label for="pickup_time" style="font-weight: bold;">Pickup Time:</label>
                    <input type="time" id="pickup_time" name="pickup_time" class="form-control" style="width: 200px;" required>
                </div>
                <br>    
                <div class="d-flex justify-content-end">
                    <form action="save_transaction.php" method="POST">
                        <!-- Hidden fields to pass the necessary data -->
                        <input type="hidden" name="total_amount" value="<?php echo $total_amount_with_fee; ?>">
                        <input type="hidden" name="payment_method" value="cod">
                        <input type="hidden" name="order_type" value="For Delivery">
                        <!-- Pass the total amount without the fee for checking -->
                        <input type="hidden" id="total-amount-without-fee" value="<?php echo $total_amount; ?>">

                        <button type="submit" class="btn btn-success mt-2" id="order-now-button"><i class="bi bi-cart-check"></i> Order Now</button>
                    </form>
                </div>
            </div>
        </div>

        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Disable the "Order Now" button if total amount is not 129
        window.onload = function() {
    var totalAmount = parseFloat(document.getElementById('total-amount-without-fee').value);
    var orderButton = document.getElementById('order-now-button');
    
    // Check if total amount is at least 129 (excluding the delivery fee)
    if (totalAmount < 129) {
        orderButton.disabled = true;
        orderButton.style.backgroundColor = '#ac4756';
    } else {
        orderButton.disabled = false;
        orderButton.style.backgroundColor = ''; 
    }
};


        document.getElementById('order-type').addEventListener('change', function() {
            var pickupTimeContainer = document.getElementById('pickup-time-container');
            var orderNowButton = document.getElementById('order-now-button');
            var pickupTimeInput = document.getElementById('pickup_time');

            if (this.value === 'For Pickup') {
                pickupTimeContainer.style.display = 'block';
                orderNowButton.disabled = !pickupTimeInput.value;
            } else {
                pickupTimeContainer.style.display = 'none';
                orderNowButton.disabled = false;
            }
        });

        document.getElementById('pickup_time').addEventListener('input', function() {
            var orderNowButton = document.getElementById('order-now-button');
            var orderType = document.getElementById('order-type').value;

            if (orderType === 'For Pickup' && this.value) {
                orderNowButton.disabled = false;
            } else if (orderType === 'For Pickup') {
                orderNowButton.disabled = true;
            }
        });
    </script>
</body>
</html>
