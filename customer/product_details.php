<?php

include('../connection.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if product_id is passed in the URL
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Fetch product details based on the product_id
    $query = "SELECT p.product_id, p.name, p.price, p.image_url, p.order_id, p.description, 
                 c.category_name, ot.order_type
          FROM products p
          INNER JOIN categories c ON p.category_id = c.category_id
          INNER JOIN order_types ot ON p.order_id = ot.order_id
          WHERE p.product_id = $product_id";

    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
        exit;
    }

    // Fetch dip, topping, and size options
    $dip_query = "SELECT * FROM dips";
    $dip_result = mysqli_query($conn, $dip_query);
    $topping_query = "SELECT * FROM toppings"; 
    $topping_result = mysqli_query($conn, $topping_query);
    $size_query = "SELECT * FROM sizes"; 
    $size_result = mysqli_query($conn, $size_query);

} else {
    echo "No product selected.";
    exit;
}

// Handle add to cart action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $size_id = $_POST['size'] ?? null;
    $dip_id = $_POST['dip'] ?? 'noDip';
    $toppings = $_POST['toppings'] ?? [];
    $quantity = $_POST['quantity'] ?? 1;

    // Calculate additional prices for size, dip, and toppings
    $additional_price = 0;

    if ($size_id) {
        $size_query = "SELECT * FROM sizes WHERE size_id = $size_id";
        $size_result = mysqli_query($conn, $size_query);
        if ($size = mysqli_fetch_assoc($size_result)) {
            $additional_price += $size['additional_price'];
        }
    }

    if ($dip_id != 'noDip') {
        $dip_query = "SELECT * FROM dips WHERE dip_id = $dip_id";
        $dip_result = mysqli_query($conn, $dip_query);
        if ($dip = mysqli_fetch_assoc($dip_result)) {
            $additional_price += $dip['additional_price'];
        }
    }

    foreach ($toppings as $topping_id) {
        $topping_query = "SELECT * FROM toppings WHERE topping_id = $topping_id";
        $topping_result = mysqli_query($conn, $topping_query);
        if ($topping = mysqli_fetch_assoc($topping_result)) {
            $additional_price += $topping['additional_price'];
        }
    }

    $total_price = ($product['price'] + $additional_price) * $quantity;

    // Insert into the cart table first (without toppings)
    $insert_query = "INSERT INTO cart (user_id, product_id, dip_id, size_id, quantity, additional_price, total_price)
                     VALUES ($user_id, $product_id, '$dip_id', $size_id, $quantity, $additional_price, $total_price)";

    if (mysqli_query($conn, $insert_query)) {
        // Get the last inserted cart_id
        $cart_id = mysqli_insert_id($conn);

        // Insert each topping into the cart_toppings table
        foreach ($toppings as $topping_id) {
            $topping_query = "INSERT INTO cart_toppings (cart_id, topping_id)
                              VALUES ($cart_id, $topping_id)";
            mysqli_query($conn, $topping_query);
        }

        header('Location: cart.php'); // Redirect to the cart page
        exit;
    } else {
        echo "Error adding to cart: " . mysqli_error($conn);
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paparazzi - Ice Cream Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/product_details.css">
</head>
<body>

    <!-- NAVIGATION BAR -->
    <?php include('navbar.php'); ?>

    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6">
                    <img class="card-img-top mb-5 mb-md-0" src="<?php echo $product['image_url']; ?>" alt="..." />
                </div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder" style="font-family:'Times New Roman', Times, serif;"><?php echo $product['name']; ?></h1>
                    <p class="fw-bold">₱<?php echo number_format($product['price'], 2); ?></p>
                    <p><strong>Category:</strong> <?php echo $product['category_name']; ?></p>
                    <p><strong>Description:</strong> <?php echo nl2br($product['description']); ?></p>

                    <!-- Dip Options -->
                    <form action="product_details.php?product_id=<?php echo $product['product_id']; ?>" method="POST">
                    <div class="mb-3">
                        <strong>Select Dip:</strong>
                        <br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="dip" id="noDip" value="1" checked>
                            <label class="form-check-label" for="noDip">No Dip</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="dip" id="withDip" value="2">
                            <label class="form-check-label" for="withDip">With Dip</label>
                        </div>
                    </div>

                    <!-- Topping Options -->
                    <div class="mb-3">
                          <strong>Select Toppings:</strong>
                          <br>
                          <?php while ($topping = mysqli_fetch_assoc($topping_result)) { ?>
                              <div class="form-check form-check-inline">
                                  <input class="form-check-input" type="checkbox" name="toppings[]" id="topping<?php echo $topping['topping_id']; ?>" value="<?php echo $topping['topping_id']; ?>">
                                  <label class="form-check-label" for="topping<?php echo $topping['topping_id']; ?>"><?php echo $topping['topping_name']; ?></label>
                              </div>
                          <?php } ?>
                    </div>

                    <!-- Size Options -->
                    <div class="mb-3">
                        <strong>Select Size:</strong>
                        <br>
                        <?php while ($size = mysqli_fetch_assoc($size_result)) { ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="size" id="size<?php echo $size['size_id']; ?>" value="<?php echo $size['size_id']; ?>" required>
                                <label class="form-check-label" for="size<?php echo $size['size_id']; ?>"><?php echo $size['size_name']; ?></label>
                            </div>
                        <?php } ?>
                    </div>

                    <!-- Quantity Input -->
                      <div class="mb-3">
                          <label for="quantity" class="form-label">Quantity:</label>
                          <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
                      </div>

                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>
</html>
