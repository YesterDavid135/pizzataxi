<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="#!">Pizzataxi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">

                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


                <?php
                $site = $_SERVER['REQUEST_URI'];
                $site = substr($site, strripos($site, '/') + 1);
                if ($site == "") {
                    $site = "index.php";
                }
                $site = strtolower($site);
                ?>
                <li class="nav-item"><a class="nav-link <?= $site == "index.php" ? "active" : "" ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item"><a class="nav-link <?= $site == "menu.php" ? "active" : "" ?>"
                                        href="menu.php">Menu</a></li>
                <li class="nav-item"><a class="nav-link <?= $site == "cart.php" ? "active" : "" ?>"
                                        href="cart.php">Cart</a></li>
                <li class="nav-item"><a class="nav-link <?= $site == "tracker.php" ? "active" : "" ?>"
                                        href="tracker.php">Order Tracker</a></li>
                <?php
                if (isset($_SESSION['loggedin']) && $_SESSION['admin'] = 1) {?>
                    <li class="nav-item"><a class="nav-link <?= $site == "admin.php" ? "active" : "" ?>"
                                            href="admin.php">Admin Center</a></li>
                <?php } ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        More
                    </a>
                    <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="complaint.php">Complaint</a>
                        <a class="dropdown-item" href="about.php">About us</a>
                        <a class="dropdown-item" href="imprint.php">Imprint</a>
                    </div>
                </li>
            </ul>
             <!--   <li class="nav-item"><a class="nav-link <?/*= $site == "about.php" ? "active" : "" */?>" href="about.php">About
                        Us</a></li>
                <li class="nav-item"><a class="nav-link <?/*= $site == "imprint.php" ? "active" : "" */?>"
                                        href="imprint.php">Imprint</a></li>
                <li class="nav-item"><a class="nav-link <?/*= $site == "complaint.php" ? "active" : "" */?>"
                                        href="complaint.php">Complain</a></li>-->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <?php
                if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']) { ?>

                    <li class="nav-item"><a class="nav-link <?= $site == "login.php" ? "active" : "" ?>"
                                            href="login.php">Login</a></li>
                    <?php
                } else { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?=$_SESSION['username']?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="password.php">Change Password</a>
                            <a class="dropdown-item" href="logout.php">Log out</a>
                        </div>
                    </li>
                  <!--  <li class="nav-item"><a class="nav-link <?/*= $site == "password.php" ? "active" : "" */?>" href="password.php">Change Password</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>-->
                <?php }
                ?>
            </ul>
        </div>
    </div>
</nav>
