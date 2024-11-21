<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ice Cream - Paparazzi</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9e1d1; 
            font-family: 'Roboto', sans-serif;
        }

        .card {
            border-radius: 15px; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
            border: none; 
            margin-bottom: 20px; 
        }

        .card-title {
            font-family: 'Open Sans', sans-serif;
            font-size: 1.5rem;
            color: #ff6f61;
            font-weight: 600;
        }

        .btn-primary {
            background-color: #ff6f61; 
            border-color: #ff6f61;
            padding: 12px 20px; 
            border-radius: 5px; 
            font-weight: 600;
            transition: all 0.3s ease-in-out; 
        }

        .btn-primary:hover {
            background-color: #ff4b3a;
            border-color: #ff4b3a;
            transform: scale(1.05); 
        }

        .list-group-item {
            background-color: #ffffff;
            border: 1px solid #ff6f61;
            margin-bottom: 15px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .list-group-item strong {
            font-family: 'Roboto', sans-serif;
            font-size: 1.2rem;
        }

        /* Style for the input fields */
        .form-control {
            border-radius: 10px;
            padding: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        .form-control:focus {
            border-color: black;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }


        .container-fluid {
            padding: 30px;
        }

        /* Responsive adjustments for smaller devices */
        @media (max-width: 768px) {
            .card {
                margin-bottom: 15px;
            }

            .btn-primary {
                width: 100%;
            }

            .col-md-6 {
                margin-bottom: 20px;
            }
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('sidebar.php'); ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

         <!--NAVBAR-->
         <?php include ('navbar.php'); ?>

            <!-- Main Content -->
            <div id="content">
                
                <!-- Begin Page Content -->
                <div class="container-fluid mt-3">

                    <!-- Row for Form and Ice Cream Display -->
                    <div class="row">
                        
                        <!-- Left Side: Add Product Form -->
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body" style="border-radius: 10px; box-shadow: 1px 1px 5px rgba(0,0,0,0.5);">
                                    <form>
                                        <div class="form-group">
                                            <label for="productName">Product Name</label>
                                            <input type="text" class="form-control" id="productName" placeholder="Enter product name">
                                        </div>
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <input type="number" class="form-control" id="quantity" placeholder="Enter quantity">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" id="description" rows="3" placeholder="Enter description"></textarea>
                                        </div>
                                        <!-- Image Upload Section -->
                                        <div class="form-group" style="margin-bottom: 28px;">
                                            <label for="productImage">Product Image</label>
                                            <input type="file" class="form-control" id="productImage" accept="image/*">
                                        </div>
                                        <button type="submit" class="btn btn-block mt-2" style="background: #FF204E; color: white;">Add Product</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Right Side: Display All Ice Cream Products -->
                           <div class="col-md-6">
                               <div class="card">
                                   <div class="card-body" style="border-radius: 10px; box-shadow: 1px 1px 5px rgba(0,0,0,0.5);">
                                       <ul class="list-group" id="product-list">
                                           <!-- Example of a product item with Image, Edit and Delete buttons -->
                                           <li class="list-group-item" style="background: #FFF2D7; color: black; border: none; box-shadow: 1px 1px 5px rgba(0,                           0,0,0.5);">
                                               <img src="https://via.placeholder.com/100" alt="Vanilla Delight" style="width: 100px; height: 100px;                            border-radius: 5px; float: left; margin-right: 15px;">
                                               <strong>Vanilla Delight</strong><br>
                                               <small>Quantity: 50</small><br>
                                               <p>Description: A creamy vanilla flavored ice cream with a rich, smooth texture.</p>
                                               <a href="edit_ice_cream.php" class="btn btn-sm" style="background: green; color: white;" onclick="editProduct(1)">Edit</a>
                                               <button class="btn btn-sm" style="background: red; color: white;" onclick="deleteProduct(1)">Delete</button>
                                           </li>
                                           <li class="list-group-item" style="background: #543310; color: white; border: none; box-shadow: 1px 1px 5px rgba(0,                           0,0,0.5);">
                                               <img src="https://via.placeholder.com/100" alt="Chocolate Fudge" style="width: 100px; height: 100px;                            border-radius: 5px; float: left; margin-right: 15px;">
                                               <strong>Chocolate Fudge</strong><br>
                                               <small>Quantity: 30</small><br>
                                               <p>Description: A rich chocolate ice cream with gooey fudge swirls.</p>
                                               <a href="edit_ice_cream.php" class="btn btn-sm" style="background: green; color: white;" onclick="editProduct(2)">Edit</a>
                                               <button class="btn btn-sm" style="background: red; color: white;" onclick="deleteProduct(2)">Delete</button>
                                           </li>
                                           <li class="list-group-item" style="background: #FF204E; color: white; border: none; box-shadow: 1px 1px 5px rgba(0,                           0,0,0.5);">
                                               <img src="https://via.placeholder.com/100" alt="Strawberry Swirl" style="width: 100px; height: 100px;                            border-radius: 5px; float: left; margin-right: 15px;">
                                               <strong>Strawberry Swirl</strong><br>
                                               <small>Quantity: 40</small><br>
                                               <p>Description: A sweet strawberry ice cream with a touch of vanilla.</p>
                                               <a href="edit_ice_cream.php" class="btn btn-sm" style="background: green; color: white;" onclick="editProduct(3)">Edit</a>
                                               <button class="btn btn-sm" style="background: red; color: white;" onclick="deleteProduct(3)">Delete</button>
                                           </li>
                                           <li class="list-group-item" style="background: #F09319; color: white; border: none; box-shadow: 1px 1px 5px rgba(0,                           0,0,0.5);">
                                               <img src="https://via.placeholder.com/100" alt="Mango Tango" style="width: 100px; height: 100px;                            border-radius: 5px; float: left; margin-right: 15px;">
                                               <strong>Mango Tango</strong><br>
                                               <small>Quantity: 20</small><br>
                                               <p>Description: A tropical mango flavored ice cream.</p>
                                               <a href="edit_ice_cream.php" class="btn btn-sm" style="background: green; color: white;" onclick="editProduct(4)">Edit</a>
                                               <button class="btn btn-sm" style="background: red; color: white;" onclick="deleteProduct(4)">Delete</button>
                                           </li>
                                           <li class="list-group-item" style="background: #3D5300; color: white; border: none; box-shadow: 1px 1px 5px rgba(0,                           0,0,0.5);">
                                               <img src="https://via.placeholder.com/100" alt="Pistachio Dream" style="width: 100px; height: 100px;                            border-radius: 5px; float: left; margin-right: 15px;">
                                               <strong>Pistachio Dream</strong><br>
                                               <small>Quantity: 25</small><br>
                                               <p>Description: A creamy pistachio ice cream with roasted nuts.</p>
                                               <a href="edit_ice_cream.php" class="btn btn-sm" style="background: green; color: white;" onclick="editProduct(5)">Edit</a>
                                               <button class="btn btn-sm" style="background: red; color: white;" onclick="deleteProduct(5)">Delete</button>
                                           </li>
                                           <li class="list-group-item" style="background: #6A9C89; color: white; border: none; box-shadow: 1px 1px 5px rgba(0,                           0,0,0.5);">
                                               <img src="https://via.placeholder.com/100" alt="Mint Chocolate Chip" style="width: 100px; height: 100px;                            border-radius: 5px; float: left; margin-right: 15px;">
                                               <strong>Mint Chocolate Chip</strong><br>
                                               <small>Quantity: 15</small><br>
                                               <p>Description: A cool mint ice cream with chocolate chips.</p>
                                               <a href="edit_ice_cream.php" class="btn btn-sm" style="background: green; color: white;" onclick="editProduct(6)">Edit</a>
                                               <button class="btn btn-sm" style="background: red; color: white;" onclick="deleteProduct(6)">Delete</button>
                                           </li>
                                       </ul>
                           
                                       <!-- Pagination -->
                                       <nav>
                                           <ul class="pagination justify-content-center">
                                               <li class="page-item" id="prev-page">
                                                   <a class="page-link" href="#" aria-label="Previous">
                                                       <span aria-hidden="true">&laquo;</span>
                                                   </a>
                                               </li>
                                               <li class="page-item active" id="page-1">
                                                   <a class="page-link" href="#">1</a>
                                               </li>
                                               <li class="page-item" id="page-2">
                                                   <a class="page-link" href="#">2</a>
                                               </li>
                                               <li class="page-item" id="page-3">
                                                   <a class="page-link" href="#">3</a>
                                               </li>
                                               <li class="page-item" id="next-page">
                                                   <a class="page-link" href="#" aria-label="Next">
                                                       <span aria-hidden="true">&raquo;</span>
                                                   </a>
                                               </li>
                                           </ul>
                                       </nav>
                                   </div>
                               </div>
                           </div>
                    </div>
                </div>
                <!-- End Page Content -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript to handle pagination -->
<script>
    // Get all product items and pagination buttons
    const productItems = document.querySelectorAll('#product-list .list-group-item');
    const paginationItems = document.querySelectorAll('.pagination .page-item');
    
    const itemsPerPage = 2;
    let currentPage = 1;
    const totalPages = Math.ceil(productItems.length / itemsPerPage);

    function showPage(page) {
        // Hide all product items
        productItems.forEach(item => item.style.display = 'none');
        
        // Show product items for the current page
        const startIndex = (page - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const itemsToShow = Array.from(productItems).slice(startIndex, endIndex);
        itemsToShow.forEach(item => item.style.display = 'block');

        // Update active page
        paginationItems.forEach(item => item.classList.remove('active'));
        document.getElementById(`page-${page}`).classList.add('active');

        // Disable/enable previous/next buttons
        document.getElementById('prev-page').classList.toggle('disabled', page === 1);
        document.getElementById('next-page').classList.toggle('disabled', page === totalPages);
    }

    // Add event listeners to pagination buttons
    document.getElementById('prev-page').addEventListener('click', function() {
        if (currentPage > 1) {
            currentPage--;
            showPage(currentPage);
        }
    });

    document.getElementById('next-page').addEventListener('click', function() {
        if (currentPage < totalPages) {
            currentPage++;
            showPage(currentPage);
        }
    });

    paginationItems.forEach(item => {
        item.addEventListener('click', function() {
            const page = parseInt(this.id.split('-')[1]);
            currentPage = page;
            showPage(page);
        });
    });

    // Initially show page 1
    showPage(1);
</script>

</body>

</html>
