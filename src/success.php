<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="description" content=""/>
    <meta name="author" content=""/>
    <title>Pizzataxi</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico"/>
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet"/>
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet"/>
    <script async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6177030326507154"
            crossorigin="anonymous"></script>
</head>
<body class="d-flex flex-column min-vh-100">
<!-- Responsive navbar-->
<?php
include('navbar.php');
?>
<!-- Header-->
<header class="py-5">
    <div class="container px-lg-5">
        <div class="p-4 p-lg-5 rounded-3 text-center">
            <div class="m-4 m-lg-5">
                <h1 class="display-5 fw-bold">Order placed!</h1>
            </div>
        </div>
    </div>
</header>
<!-- Page Content-->
<div class="container px-lg-5">
    <div class="p-4 p-lg-5 rounded-3 ">
        <div class="m-4 m-lg-5 text-center">
            <p class="fs-4">Your order has been successfully placed.</p>
            <a class="btn col-4 btn-danger btn-lg" href=index.php>Back to home</a>
            <a class="btn col-4 btn-dark btn-lg" href="tracker.php?userid=<?=$_SESSION['userid']?>">View your orders</a>
        </div>
    </div>
</div>
<!-- Footer-->
<footer class="py-5 bg-dark mt-auto">
    <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Pizzataxi 2022</p></div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>
</html>