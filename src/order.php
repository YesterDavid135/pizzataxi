<!DOCTYPE html>
<?php
session_start();
?>
<html lang="en">
<head>
    <meta charset="utf-8"/>
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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6177030326507154"
            crossorigin="anonymous"></script>
</head>
<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="#!">Pizzataxi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
                    class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="order.php">Order</a></li>
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
            <div class="m-2 m-lg-0">
                <h1 class="display-5 fw-bold">Order a pizza</h1>
            </div>
        </div>
    </div>
</header>
<!-- Page Content-->
<section class="pt-4">
    <div class="container px-lg-5">
        <!-- Page Features-->
        <div class="row gx-lg-5">
            <?php
            // Include config file
            require_once "config.php";

            // Prepare a select statement
            $sql = "SELECT * FROM pizzas where active = 1";

            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {

                    if ($row["discount"] != null) {

                    }

                    print('
                    <div class="col-lg-6 col-xxl-4 mb-5">
                        <div class="card border-0 h-100">
                        <img class="card-img-top" src="assets/pizzas/' . $row["image"] . '" alt="Pizza image" style=" display: block">
                            <div class="card-body ">
                                <div class="text-center">
                                    <h2 class="fs-4 fw-bold">' . $row["name"] . '</h2>
                                    <p class="mb-0">' . $row["description"] . '</p>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">');

                        if ($row["discount"])
                            print ('<div>
                                        <p class="link-dark fw-bold text-decoration-line-through">' . $row["price"].  ' CHF </p>
                                        <h4 class="link-danger fw-bold ">' .  ($row["price"] / 100) * (100 - $row['discount']) .  ' CHF <span class="badge bg-danger">' . $row['discount'].'%</span></h4>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary">Add to cart</button>
                                </div>');
                        else
                            print ('
                            <div>
                                        <h4 class="link-dark fw-bold">' . $row["price"].  ' CHF</h4>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary">Add to cart</button>
                                </div>');

                        print('            
                            </div>
                        </div>
                    </div>
                    ');
                }
            }
            ?>
        </div>
    </div>
</section>
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
