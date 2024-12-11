<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>Login - Sweet Treats Ice Cream Shop</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.0.0/css/all.css" />
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS for Ice Cream Shop theme -->
     <link rel="stylesheet" href="./css/login.css">
</head>
<body>

    <!-- Login Form -->
    <div class="login-form-container">
        <h1 class="text-center">Paparazzi Admin</h1>
        <br>
        <br>
        <form action="auth_login.php" method="POST">
            <!-- Email input -->
            <div class="form-outline">
                <label class="form-label" for="email">Email address</label>
                <input type="email" id="email" name="email" class="form-control" required />
            </div>

            <!-- Password input -->
            <div class="form-outline">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required />
            </div>

            <!-- Remember me checkbox and Forgot password link -->
            <div class="row mb-4">
                <div class="col d-flex justify-content-start">
                    <div class="form-check">
                        <a href="forgot_password.php" class="forgot-password-link" style="color: blue;">Forgot password?</a>
                    </div>
                </div>        
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Sign in</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>


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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
