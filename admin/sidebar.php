<style>
    .bg-gradient-icecream {
        background: #FF204E;
        background-size: cover;
    }
    .sidebar-dark .nav-link {
        color: #ffffff;
    }
    .sidebar-dark .nav-link:hover {
        color: white;
    }
    .sidebar-dark .sidebar-brand {
        color: #fff;
    }
    .collapse-inner .collapse-item {
        color: white !important; /* Ensures text is white */
    }
    .collapse-inner .collapse-item:hover {
        background-color: #EB3678 !important; /* Makes background black on hover */
        color: white !important; /* Keeps the text color white on hover */
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
                <div id="collapseTwo" class="core collapse show" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="core py-2 collapse-inner rounded" style="background-color: transparent;">
                        <a class="collapse-item" href="manage_ice_cream.php" style="color: white;">Manage Ice Cream</a>
                        <a class="collapse-item" href="manage_size.php" style="color: white;">Manage Sizes</a>
                        <a class="collapse-item" href="manage_flavor.php" style="color: white;">Manage Flavors</a>
                        <a class="collapse-item" href="manage_topping.php" style="color: white;">Manage Toppings</a>
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
                <div id="userAccount" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar" >
                    <div class="py-2 collapse-inner rounded" style="background-color: transparent;">
                        <a class="collapse-item" href="customer_account.php" style="color: #FF204E;">Customer</a>
                        <a class="collapse-item" href="admin_account.php" style="color: white;">Admin</a>
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider" style="background:white;">

            <!-- Nav Item - Charts -->
            <li class="nav-item">
                 <a class="nav-link" href="logout.php" style="display: flex; justify-content: center;">
                    <span style="background: red; padding: 10px 20px;">Log Out</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->