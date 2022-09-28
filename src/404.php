<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Pizzataxi</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="css/custom.css" rel="stylesheet" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />

</head>
<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="#!">Pizzataxi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="order.php">Order</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <?php
                if (!isset($_SESSION['username'])) {
                    print('
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    ');
                } else {
                    print('<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>');
                }
                ?>
            </ul>
        </div>
    </div>
</nav>
<!-- Header-->
<header class="py-5">
    <div class="container px-lg-5">
        <div class="p-4 p-lg-5 rounded-3 text-center">
            <div class="m-4 m-lg-5">
                <div class="row justify-content-center">
                    <p class="col-3" style="font-size: 150px">4</p>
                    <img class="col-3 pizzaspin" src="assets/pizzas/margeritha404.png">
                    <p class="col-3" style="font-size: 150px">4</p>
                </div>
                <p class="fs-4">Site not Found</p>
                <a class="btn btn-primary btn-lg" href="index.php">Return to a safeplace</a>
            </div>
        </div>
    </div>
</header>

<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Pizzataxi 2022</p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>
