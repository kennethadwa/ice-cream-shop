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
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Raleway:wght@400;500&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background: #fbe9e7;
        }
        h1 {
            font-family: 'Pacifico', cursive;
            color: #f44336;
            margin-bottom: 30px;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        .table {
            background-color: #fce4ec; 
            border: 1px solid #f44336; 
        }
        .table th, .table td {
            color: #e91e63; 
        }
        .table thead {
            background-color: #f44336; 
            color: white;
        }
        .btn-success {
            background-color: #f44336; 
            border-color: #f44336;
        }
        .btn-success:hover {
            background-color: #e91e63; 
        }
        .d-flex h3 {
            font-size: 1.5rem;
            color: #f44336; 
        }
        .alert-warning {
            background-color: #ffebee; 
            color: #d32f2f;
        }
        .cart-item-name {
            font-weight: bold;
        }
    </style>
</head>
<body>

    <!-- NAVIGATION BAR -->
    <?php include('navbar.php'); ?>

    <div class="container my-4">
        <h1 class="text-center">Your Cart</h1>

        <!-- If Cart is Empty -->
        <div id="cart-empty" class="alert alert-warning text-center" style="display: none;">
            Your cart is empty. Please add items to your cart.
        </div>

        <!-- Cart Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="color: white;">Item Name</th>
                    <th style="color: white;">Quantity</th>
                    <th style="color: white;">Price per Item (₱)</th>
                    <th style="color: white;">Add-ons (₱)</th>
                    <th style="color: white;">Total (₱)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="cart-item-name">Vanilla Ice Cream</td>
                    <td>2</td>
                    <td>₱180.00</td>
                    <td>₱30.00</td>
                    <td>₱390.00</td>
                </tr>
                <tr>
                    <td class="cart-item-name">Chocolate Sundae</td>
                    <td>1</td>
                    <td>₱250.00</td>
                    <td>₱50.00</td>
                    <td>₱300.00</td>
                </tr>
                <tr>
                    <td class="cart-item-name">Strawberry Cone</td>
                    <td>3</td>
                    <td>₱150.00</td>
                    <td>₱20.00</td>
                    <td>₱510.00</td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-between">
            <h3>Total Amount: ₱1200.00</h3>
            <button class="btn btn-success">Proceed to Pay (COD)</button>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
