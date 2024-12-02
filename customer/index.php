<?php

include('../connection.php');

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch products with category "Ice Cream"
$query_ice_cream = "SELECT p.product_id, p.name, p.price, p.image_url, ot.order_type
                    FROM products p
                    INNER JOIN categories c ON p.category_id = c.category_id
                    LEFT JOIN order_types ot ON p.order_id = ot.order_id
                    WHERE c.category_name = 'Ice Cream'";

$result_ice_cream = mysqli_query($conn, $query_ice_cream);

// Fetch products with category "Floats"
$query_floats = "SELECT p.product_id, p.name, p.price, p.image_url, ot.order_type
                 FROM products p
                 INNER JOIN categories c ON p.category_id = c.category_id
                 LEFT JOIN order_types ot ON p.order_id = ot.order_id
                 WHERE c.category_name = 'Floats'";

$result_floats = mysqli_query($conn, $query_floats);


// Fetch products with category "Sugar Bowl"
$query_sugar_bowl = "SELECT p.product_id, p.name, p.price, p.image_url, ot.order_type
                     FROM products p
                     INNER JOIN categories c ON p.category_id = c.category_id
                     LEFT JOIN order_types ot ON p.order_id = ot.order_id
                     WHERE c.category_name = 'Sugar Bowl'";

$result_sugar_bowl = mysqli_query($conn, $query_sugar_bowl);

$query = "SELECT p.product_id, p.name, p.price, p.image_url, ot.order_type
          FROM products p
          LEFT JOIN order_types ot ON p.order_id = ot.order_id
          WHERE p.best_seller = 1
          LIMIT 3";
$result = $conn->query($query);


if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-success text-center'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);  // Clear the message after displaying
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paparazzi - Ice Cream Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>

    <!-- NAVIGATION BAR -->
     <?php include('navbar.php'); ?>

    <!-- Header -->
    <header id="home" class="py-5 text-white text-center" style="background-color: #ffb6c1;">
        <div class="container">
            <h1 class="display-3 fw-bolder" style="font-family: 'Pacifico', cursive; text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);">Welcome to Paparazzi Ice Cream Station</h1>
            <br>
            <p class="lead fw-normal" style="text-shadow: 1px 1px 8px black;">Delicious ice cream made just for you!</p>
        </div>
    </header>

    <!-- Best Sellers Section -->
<section id="best-sellers" class="py-5">
    <div class="container">
        <h2 class="text-center">Best Sellers</h2>
        <div class="row mt-4">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="<?= htmlspecialchars($row['image_url']) ?>" class="card-img-top" alt="<?= htmlspecialchars($row['name']) ?>">
                        <div class="card-body text-center">
                            <h5 class="card-title fw-bolder" style="color:#ff4c61;"><?= htmlspecialchars($row['name']) ?></h5>
                            <small class="badge badge-primary text-dark" style="background: pink;"><?= htmlspecialchars($row['order_type']) ?></small><br>
                            <p class="card-text fw-bold">₱<?= number_format($row['price'], 2) ?></p>
                            <a href="product_details.php?product_id=<?= $row['product_id'] ?>" class="ice-cream-btn">View</a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>


<!-- Menu Section -->
<section id="menu" class="py-5">
    <div class="container">
        <h2 class="text-center" style="font-family: 'Cookie', cursive; color: #ff69b4;">Our Menu</h2>
        
        <!-- Ice Cream Section -->
            <?php
            if (mysqli_num_rows($result_ice_cream) > 0) {
                echo '<section id="ice-cream">
                          <h4 class="text-center fw-bold">Ice Cream</h4>
                          <div class="row mt-4" style="margin-bottom: 50px;">';             
                while ($row = mysqli_fetch_assoc($result_ice_cream)) {
                    echo '<div class="col-md-4 mb-4">
                              <div class="card h-100">
                                  <img src="' . $row['image_url'] . '" class="card-img-top" alt="' . $row['name'] . '">
                                  <div class="card-body text-center">
                                      <h5 class="fw-bolder">' . $row['name'] . '</h5>
                                      <small class="badge badge-primary text-dark" style="background: pink;">' . $row['order_type'] . '</small><br>
                          <p class="fw-bold">₱' . number_format($row['price'], 2) . '</p>
                          <a href="product_details.php?product_id=' . $row['product_id'] . '" class="ice-cream-btn">View</a>
                                        </div>
                                    </div>
                                </div>';
                           }          
                      echo '</div>
                            </section>';
                  } else {
                      echo '<p>No ice cream products available.</p>';
                  }
                  ?>



        <!-- Floats Section -->
        <?php
        if (mysqli_num_rows($result_floats) > 0) {
            echo '<section id="floats">
                      <h4 class="text-center fw-bold">Floats</h4>
                      <div class="row mt-4" style="margin-bottom: 50px;">';
            while ($row = mysqli_fetch_assoc($result_floats)) {
                echo '<div class="col-md-4 mb-4">
                          <div class="card h-100">
                              <img src="' . $row['image_url'] . '" class="card-img-top" alt="' . $row['name'] . '">
                              <div class="card-body text-center">
                                  <small class="badge badge-primary text-dark" style="background: pink;">' . $row['order_type'] . '</small><br>
                                  <h5 class="fw-bolder">' . $row['name'] . '</h5>
                                  <p class="fw-bold">₱' . number_format($row['price'], 2) . '</p>
                                  <a href="product_details.php?product_id=' . $row['product_id'] . '" class="ice-cream-btn">View</a>
                              </div>
                          </div>
                      </div>';
            }
            
            echo '</div>
                  </section>';
        } else {
            echo '<section id="floats">
                    <h4 class="text-center fw-bold">Floats</h4>
                    <p class="text-center">Floats are currently not available right now.</p>
                  </section>';
        }
        ?>

        <!-- Sugar Bowl Section -->
        <?php
          if (mysqli_num_rows($result_sugar_bowl) > 0) {
              echo '<section id="sugar-bowl">
                        <h4 class="text-center fw-bold">Sugar Bowl</h4>
                        <div class="row mt-4" style="margin-bottom: 50px;">';
              while ($row = mysqli_fetch_assoc($result_sugar_bowl)) {
                  echo '<div class="col-md-4 mb-4">
                            <div class="card h-100">
                             <img src="' . $row['image_url'] . '" class="card-img-top" alt="' . $row['name'] . '">
                             <div class="card-body text-center">
                                 <small class="badge badge-primary text-dark" style="background: pink;">' . $row['order_type'] . '</small><br>
                                  <h5 class="fw-bolder">' . $row['name'] . '</h5>
                                  <p class="fw-bold">₱' . number_format($row['price'], 2) . '</p>
                                  <a href="product_details.php?product_id=' . $row['product_id'] . '" class="ice-cream-btn">View</a>
                              </div>
                          </div>
                      </div>';
            }
            echo '</div>
                  </section>';
        } else {
            echo '<section id="sugar-bowl">
                    <h4 class="text-center fw-bold">Sugar Bowl</h4>
                    <p class="text-center">Sugar Bowl items are currently not available.</p>
                  </section>';
        }
        ?>

    </div>
</section>



   <!-- Footer -->
    <?php include('footer.php'); ?>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
