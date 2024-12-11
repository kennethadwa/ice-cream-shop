<style>
    .bg-gradient-icecream {
        background: linear-gradient(180deg, #2D2F33, #3E4147);
    }
    .sidebar-dark .nav-link {
        color: #AEB6BF;
    }
    .sidebar-dark .nav-link:hover {
        color: #E5E8E8;
    }
    .sidebar-dark .sidebar-brand {
        color: #F7F9F9;
    }
    .collapse-inner .collapse-item {
        color: #AEB6BF !important; 
    }
    .collapse-inner .collapse-item:hover {
        background-color: #53575D !important;
        color: #F7F9F9 !important;
    }
    hr.sidebar-divider {
        border-color: #55595C;
    }
    .sidebar-dark .sidebar-heading {
        color: #EAECEE;
        font-size: 0.85rem;
        font-weight: 600;
    }
</style>



<!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-icecream sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="assets/img/brand2.png" alt="logo" style="max-height: 50px; max-width: 50px;">
                </div>
                <div class="sidebar-brand-text mx-3">Paparazzi</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider" style="background:white;">

            <!-- Heading -->
            <div class="sidebar-heading">
                Product Management
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Products</span>
                </a>
                <div id="collapseTwo" class="core collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="background: linear-gradient(180deg, #2D2F33, #3E4147);">
                    <div class="core py-2 collapse-inner rounded" style="background-color: transparent;">
                        <a class="collapse-item" href="manage_products.php" style="color: white;">Manage Products</a>
                        <a class="collapse-item" href="manage_sizes.php" style="color: white;">Manage Sizes</a>
                        <a class="collapse-item" href="manage_dips.php" style="color: white;">Manage Dips</a>
                        <a class="collapse-item" href="manage_toppings.php" style="color: white;">Manage Toppings</a>
                    </div>
                </div>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider" style="background:white;">


            <!-- Heading -->
            <div class="sidebar-heading">
                Orders
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#orders"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Manage Orders</span>
                </a>
                <div id="orders" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="background: linear-gradient(180deg, #2D2F33, #3E4147);">
                    <div class="py-2 collapse-inner rounded">
                        <a class="collapse-item" href="pending_orders.php" style="color: #FF204E;">Pending Orders</a>
                        <a class="collapse-item" href="completed_orders.php" style="color: white;">Completed Orders</a>
                        <a class="collapse-item" href="cancelled_orders.php" style="color: white;">Cancelled Orders</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider" style="background:white;">


            <!-- Heading -->
            <div class="sidebar-heading">
                User Management
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userAccount"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>User Account</span>
                </a>
                <div id="userAccount" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" style="background: linear-gradient(180deg, #2D2F33, #3E4147);">
                    <div class="py-2 collapse-inner rounded">
                        <a class="collapse-item" href="customer_account.php" style="color: #FF204E;">Customer</a>
                        <a class="collapse-item" href="admin_account.php" style="color: white;">Admin</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider" style="background:white;">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->


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