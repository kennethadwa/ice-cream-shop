<?php
require '../connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
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

$profile_image = $user['img'] ? $user['img'] : 'https://img.icons8.com/ios-filled/50/user.png'; // Default image if none
?>

<style>
    .navbar {
        background: linear-gradient(180deg, #2D2F33, #3E4147);
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
    .nav-item:hover .nav-link {
        cursor: pointer;
    }
    button:focus, 
img:focus {
    outline: none;
    box-shadow: none;
}

</style>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon" style="background-color: #ff69b4;"></span>
        </button>
        
        <div class="collapse navbar-collapse d-flex justify-content-end mr-5" id="navbarNav">
            <!-- User Account Dropdown -->
            <div class="dropdown ms-3 mr-4">
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
    </div>
</nav>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>