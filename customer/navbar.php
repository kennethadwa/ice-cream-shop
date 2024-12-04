<?php

require '../connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


$user_id = $_SESSION['user_id'];

// Fetch the user's image from the database
$sqls = "SELECT img FROM users WHERE user_id = ?";
$stmts = $conn->prepare($sqls);
$stmts->bind_param("i", $user_id);
$stmts->execute();
$results = $stmts->get_result();
$user = $results->fetch_assoc();

// Set the image path, default to a generic image if none exists
$profile_image = $user['img'] ? $user['img'] : 'https://img.icons8.com/ios-filled/50/user.png'; // Default image if no profile image
?>


<style>
    .navbar {
        background-color: white;
        position: sticky;
        top: 0;
        z-index: 1000;
    }
    .navbar-nav .nav-link {
        color: #ff69b4;
        font-size: 1.1rem;
        font-weight: bold;
        transition: all 0.3s ease;
        padding: 8px 16px;
        border-radius: 20px;
    }
    .navbar-toggler {
        border: none;
    }
    .navbar-toggler-icon {
        background-color: #ff69b4;
    }
    .btn-outline-dark {
        color: #ff69b4;
        border-color: #ff69b4;
    }
    .btn-outline-dark:hover {
        background-color: #ff69b4;
        color: white;
    }
    .navbar-nav .nav-link:hover {
        background-color: #f8d7d1;
        color: #d36f8d;
        border-radius: 10px; 
    }
    .nav-item:hover .nav-link {
        cursor: pointer;
    }
</style>



<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        
        <!-- Logo and Brand Name -->
        <a class="navbar-brand d-flex align-items-center" href="#" style="font-family: 'Pacifico', cursive; font-size: 1.5rem; color: #ff69b4;">
            <img src="./assets/img/brand2.png" alt="logo" style="max-height: 50px; max-width: 80px; margin-right: 10px;">
            <span>Paparazzi</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="background-color: #ff69b4;"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav" style="margin-right: 50px;">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link text-dark" href="index.php#home" style="color: #ff69b4; font-size: 1.2rem; font-weight: bold;">🍦 Home</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="index.php#best-sellers" style="color: #ff69b4; font-size: 1.2rem; font-weight: bold;">🍨 Best Sellers</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="index.php#menu" style="color: #ff69b4; font-size: 1.2rem; font-weight: bold;">🍧 Menu</a></li>
                <li class="nav-item"><a class="nav-link text-dark" href="order_history.php" style="color: #ff69b4; font-size: 1.2rem; font-weight: bold;">
                    <i class="bi-clock-history me-1" style="color: #ff69b4;"></i> Order History
                </a></li>
                &nbsp;
            </ul>
            &nbsp;
            <form class="d-flex">
                <a class="btn" href="cart.php" type="submit" style="background: #ff69b4; box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5); color: white;">
                    <i class="bi-cart-fill me-1" style="color: white;"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                </a>
            </form>
        </div>

        <br>

        <!-- User Account Dropdown -->
<div class="dropdown" style="margin-left: 20px;">
    <button class="btn" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background: transparent; border:none;">
        <img width="45" height="45" src="<?php echo $profile_image; ?>" alt="user" style="border-radius: 50%; border: 2px solid pink; box-shadow: 1px 1px 5px black; background-size: cover; object-fit: cover;"/>
    </button>
    <ul class="dropdown-menu" aria-labelledby="userDropdown">
        <li>
            <a class="dropdown-item" href="profile.php">
                <i class="bi bi-person-circle me-2"></i> My Account
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="logout.php">
                <i class="bi bi-box-arrow-right me-2"></i> Log Out
            </a>
        </li>
    </ul>
</div>
    </div>
</nav>


