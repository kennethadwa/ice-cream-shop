<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Shop Menu - Ice Cream Delight</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <style>
            .custom-control {
    background-color: black;
    max-width: 50px;
    max-height: 50px;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
}
        </style>
    </head>
    <body>

        <!-- NAVBAR.PHP -->
        <?php include('navbar.php'); ?>

        <!-- Header -->
        <header class="py-5 text-white text-center" style="background-color: #ffb6c1;">
            <div class="container">
                <h1 class="display-3 fw-bolder" style="font-family: 'Cookie', cursive; text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);">Welcome to Paparazzi Menu</h1>
                <p class="lead fw-normal" style="text-shadow: 1px 1px 8px black;">Delicious ice cream made just for you!</p>
            </div>
        </header>

        <!-- Menu Section -->
<section id="menu" class="py-5">
    <div class="container">
        <h2 class="text-center" style="font-family: 'Cookie', cursive; color: #ff69b4;">Our Menu</h2>

        <!-- Ice Cream and Cones -->
        <div class="row mt-4">
            <div class="col-12">
                <div style="background: #4a90e2; color: white; padding: 20px; margin-bottom: 15px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h2 class="text-start fw-bold" style="font-family: 'Montserrat', sans-serif; font-size: 2rem;">Ice Cream in Cones</h2>
                </div>
                
                <!-- Carousel for Ice Cream in Cones -->
                <div id="carouselIceCreamCones" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="d-flex justify-content-evenly">
                                <!-- 3 Product Cards -->
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Wafer Cone">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Wafer Cone</h5>
                                        <p>No Dip / With Dip</p>
                                        <p class="fw-bold">₱50.00 - ₱60.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Wafer Cone">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Wafer Cone</h5>
                                        <p>No Dip / With Dip</p>
                                        <p class="fw-bold">₱50.00 - ₱60.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Chocolate Cone">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Chocolate Cone</h5>
                                        <p>No Dip / With Dip</p>
                                        <p class="fw-bold">₱55.00 - ₱65.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-evenly">
                                <!-- 3 Product Cards -->
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Wafer Cone">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Wafer Cone</h5>
                                        <p>No Dip / With Dip</p>
                                        <p class="fw-bold">₱50.00 - ₱60.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Wafer Cone">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Wafer Cone</h5>
                                        <p>No Dip / With Dip</p>
                                        <p class="fw-bold">₱50.00 - ₱60.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Chocolate Cone">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Chocolate Cone</h5>
                                        <p>No Dip / With Dip</p>
                                        <p class="fw-bold">₱55.00 - ₱65.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev custom-control" type="button" data-bs-target="#carouselIceCreamCones" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next custom-control" type="button" data-bs-target="#carouselIceCreamCones" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Milk Tea and Smoothies -->
        <div class="row mt-4">
            <div class="col-12">
                <div style="background: #ff6f61; color: white; padding: 20px; margin-bottom: 15px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                    <h2 class="text-start fw-bold" style="font-family: 'Montserrat', sans-serif; font-size: 2rem;">Milk Tea & Smoothies</h2>
                </div>
                
                <!-- Carousel for Milk Tea and Smoothies -->
                <div id="carouselMilkTeaSmoothies" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="d-flex justify-content-evenly">
                                <!-- 3 Product Cards -->
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Matcha Milk Tea">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Matcha Milk Tea</h5>
                                        <p>With Tapioca Pearls</p>
                                        <p class="fw-bold">₱80.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Strawberry Smoothie">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Strawberry Smoothie</h5>
                                        <p>Fresh & Creamy</p>
                                        <p class="fw-bold">₱90.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Taro Milk Tea">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Taro Milk Tea</h5>
                                        <p>With Tapioca Pearls</p>
                                        <p class="fw-bold">₱85.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="d-flex justify-content-evenly">
                                <!-- 3 Product Cards -->
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Matcha Milk Tea">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Matcha Milk Tea</h5>
                                        <p>With Tapioca Pearls</p>
                                        <p class="fw-bold">₱80.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Strawberry Smoothie">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Strawberry Smoothie</h5>
                                        <p>Fresh & Creamy</p>
                                        <p class="fw-bold">₱90.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                                <div class="card h-100" style="width: 18rem;">
                                    <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Taro Milk Tea">
                                    <div class="card-body text-center">
                                        <h5 class="fw-bolder">Taro Milk Tea</h5>
                                        <p>With Tapioca Pearls</p>
                                        <p class="fw-bold">₱85.00</p>
                                        <button class="btn btn-primary">Buy</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev custom-control" type="button" data-bs-target="#carouselMilkTeaSmoothies" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next custom-control" type="button" data-bs-target="#carouselMilkTeaSmoothies" data-bs-slide="next" style="background-color: black;">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>




        <!-- Footer-->
        <footer class="py-5 bg-light">
            <div class="container text-center"><p class="m-0 text-dark">Copyright &copy; Ice Cream Delight 2024</p></div>
        </footer>

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>

        <script>
            // Slider functionality
let sliders = document.querySelectorAll('.menu-slider');
sliders.forEach(slider => {
    const leftArrow = slider.querySelector('.left');
    const rightArrow = slider.querySelector('.right');
    const items = slider.querySelector('.menu-items');

    leftArrow.addEventListener('click', () => {
        items.scrollBy({
            left: -300,
            behavior: 'smooth'
        });
    });

    rightArrow.addEventListener('click', () => {
        items.scrollBy({
            left: 300,
            behavior: 'smooth'
        });
    });
});

// Pagination functionality (optional for dynamic pages)
document.querySelectorAll('.pagination .page-link').forEach(page => {
    page.addEventListener('click', function (e) {
        e.preventDefault();
        alert(`Page ${this.textContent} clicked!`);
        // Here you can load the content of the respective page dynamically
    });
});

        </script>
    </body>
</html>
