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
    <style>
      
      body{
        background: linear-gradient(135deg, #f9e5d9, #c3e7c4, #ffefbb);
      }
      
      .btn {
          border-radius: 50px;
          padding: 8px 15px;
          font-size: 1rem;
          transition: all 0.3s ease-in-out;
      }

      /* No Dip button */
      .product-btn {
          background: darkblue;
          color: white;
      }

      .product-btn:hover {
          background: blue;
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

     
      .bg-light {
          background-color: #FFF0F5;
      }

    
      #inputQuantity {
          font-size: 1.2rem;
          padding: 5px 10px;
          border-radius: 5px;
          border: 1px solid #FFB6C1;
          max-width: 60px;
      }
  
      .checkbox-label, .radio-label {
          font-size: 1rem;
          color: black;
          margin-right: 20px;
      }

      .checkbox-input, .radio-input {
          margin-right: 10px;
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

                    <!-- Toppings radio buttons -->
                    <strong>Toppings</strong>
                    <div class="mb-5 mt-1">
                        <label class="radio-label">
                            <input type="radio" class="radio-input" name="topping" id="noDip" />
                            No Dip
                        </label>
                        <label class="radio-label">
                            <input type="radio" class="radio-input" name="topping" id="withDip" />
                            With Dip
                        </label>
                    </div>

                    <!-- Sizes radio buttons -->
                    <strong>Sizes</strong>
                    <div class="mb-5 mt-1">
                        <label class="radio-label">
                            <input type="radio" class="radio-input" name="size" id="size55ml" />
                            55ML
                        </label>
                        <label class="radio-label">
                            <input type="radio" class="radio-input" name="size" id="size75ml" />
                            75ML
                        </label>
                    </div>

                    <!-- Quantity input -->
                    <div class="d-flex" style="flex-direction: column;">
                        <input class="form-control text-center me-3" id="inputQuantity" type="number" value="1" style="max-width: 3rem; border: 1px solid black;" />
                        <br>
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
