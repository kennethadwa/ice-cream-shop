<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Treats - Order History</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Raleway:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Raleway', sans-serif;
            background-color: #fff5f8;
        }

        h1 {
            font-family: 'Pacifico', cursive;
            color: #ff6b81;
            text-align: center;
            margin: 20px 0;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }

        .order-table {
            margin: 20px auto;
            max-width: 90%;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(255, 105, 135, 0.2);
            overflow: hidden;
            border: 3px solid #ff6b81;
        }

        .table th {
            background-color: #ffe9ee;
            color: #ff6b81;
        }

        .table td {
            background-color: #fffdfd;
            color: #555;
        }

        .btn-info {
            background-color: #ff6b81;
            border-color: #ff6b81;
        }

        .btn-info:hover {
            background-color: #ff4c61;
            border-color: #ff4c61;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .cherry-icon {
            font-size: 1.5rem;
            color: #ff6b81;
            margin-right: 5px;
        }
    </style>
</head>
<body>

    <!-- NAVIGATION BAR -->
    <?php include('navbar.php'); ?>

    <!-- Order History Section -->
    <h1>
        <i class="bi bi-basket2-fill cherry-icon"></i>
        Order History
    </h1>
    <div class="table-responsive order-table">
        <table class="table table-hover table-bordered text-center">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Ice Cream Name</th>
                    <th>Add Ons</th>
                    <th>Sizes</th>
                    <th>Price</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

                <!-- Example Data -->
                <tr>
                    <td>Jane Doe</td>
                    <td>123 Sweet St, Candyville</td>
                    <td>Chocolate Sundae</td>
                    <td>Sprinkles, Cherry</td>
                    <td>Large</td>
                    <td>$5.99</td>
                    <td style="font-weight: bold; color: red;">Pending</td>
                </tr>
                <tr>
                    <td>Jane Doe</td>
                    <td>123 Sweet St, Candyville</td>
                    <td>Vanilla Delight</td>
                    <td>Caramel Drizzle</td>
                    <td>Medium</td>
                    <td>$4.49</td>
                    <td style="font-weight: bold; color: green;">Our For Delivery</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
