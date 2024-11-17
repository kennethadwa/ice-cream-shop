<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sweet Treats - Ice Cream Shop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
      /* Button Styles for Ice Cream Theme */
      .btn {
          border-radius: 50px;
          padding: 8px 15px;
          font-size: 1rem;
          transition: all 0.3s ease-in-out;
      }

      /* No Dip button */
      .product-btn {
          background: #FF6E40;
          color: white;
      }

      .product-btn:hover {
          background: #FF6E40;
          color: white;
      }

      /* Size buttons */
      .btn-size {
          background: #FFB6C1;
          color: white;
          margin-right: 10px;
      }

      .btn-size:hover {
          background: #FF6F61;
          color: white;
      }

      /* Ice Cream Theme Header */
      h1.display-5.fw-bolder {
          font-family: 'Pacifico', cursive;
          color: #FF6F61;
      }

      h2.fw-bolder {
          font-family: 'Cookie', cursive;
          color: #FF6F61;
      }

      /* Product Description */
      p.lead {
          font-family: 'Roboto Slab', serif;
          color: #555;
      }

      /* Card Design */
      .card {
          border: 1px solid #FFB6C1;
          border-radius: 15px;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
          transition: transform 0.3s ease-in-out;
      }

      .card:hover {
          transform: scale(1.05);
      }

      .card-img-top {
          border-radius: 15px 15px 0 0;
          object-fit: cover;
      }

      /* Related Products Section */
      .bg-light {
          background-color: #FFF0F5; /* Soft light pink for related products */
      }

      /* Input Quantity Style */
      #inputQuantity {
          font-size: 1.2rem;
          padding: 5px 10px;
          border-radius: 5px;
          border: 1px solid #FFB6C1;
          max-width: 60px;
      }
    </style>
</head>
<body>

    <!-- NAVIGATION BAR -->
    <?php include('navbar.php'); ?>

    <!-- Product section-->
    <section class="py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="row gx-4 gx-lg-5 align-items-center">
                <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="./assets/img/ten-yen.png" alt="..." /></div>
                <div class="col-md-6">
                    <h1 class="display-5 fw-bolder">Ten Yen Ice Cream</h1>
                    <div class="fs-5 mb-5">
                        <span>₱55.99</span>
                    </div>
                    <p class="lead">Lorem ipsum dolor sit amet consectetur adipisicing elit. Praesentium at dolorem quidem modi. Nam sequi consequatur obcaecati excepturi alias magni, accusamus eius blanditiis delectus ipsam minima ea iste laborum vero?</p>
                    


                    <!-- Category buttons (No Dip and With Dip) -->
                    <strong style="margin-bottom: 50px;">Toppings</strong>
                    <div class="mb-5 mt-1">
                        <button class="btn product-btn">No Dip</button>
                        <button class="btn product-btn">With Dip</button>
                    </div>


                    <!-- Size buttons (55ML and 75ML) -->
                     <strong style="margin-bottom: 50px;">Sizes</strong>
                    <div class="mb-5 mt-1">  
                        <button class="btn product-btn">55ML</button>
                        <button class="btn product-btn">75ML</button>
                    </div>

                    <div class="d-flex">
                        <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />
                        <button class="btn product-btn flex-shrink-0" type="button">
                            <i class="bi-cart-fill me-1"></i>
                            Add to cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
