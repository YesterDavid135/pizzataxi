<!DOCTYPE html>
<?php
session_start();
include('config.php');

$error = '';
$message = '';
$username = $password = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['username'])) {
        $username = htmlspecialchars(trim($_POST['username']));

        if (empty($username) || !preg_match("/(?=.*[a-z])(?=.*[A-Z])[a-zA-Z]{6,30}/", $username)) {
            $error .= "Der Benutzername entspricht nicht dem geforderten Format.<br />";
        }
    } else {
        $error .= "Geben Sie bitte den Benutzername an.<br />";
    }
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
        if (empty($password) || !preg_match("/(?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/", $password)) {
            $error .= "Das Passwort entspricht nicht dem geforderten Format.<br />";
        }
    } else {
        $error .= "Geben Sie bitte das Passwort an.<br />";
    }

    if (empty($error)) {
        $query = "SELECT user_id, username, password from users where username = ?";
        $stmt = $link->prepare($query);

        if ($stmt === false) {
            $error .= 'prepare() failed ' . $link->error . '<br />';
        }
        if (!$stmt->bind_param("s", $username)) {
            $error .= 'bind_param() failed ' . $link->error . '<br />';
        }
        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $link->error . '<br />';
        }
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            if (password_verify($password, $row['password'])) {

                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                $_SESSION['userid'] = $row['id'];

                session_regenerate_id(true);

                header("Location: index.php");

                die();

            } else {
                $error .= "Benutzername oder Passwort sind falsch";
            }
        } else {
            $error .= "Benutzername oder Passwort sind falsch";
        }
    }
}

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
<body>
<!-- Responsive navbar-->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-lg-5">
        <a class="navbar-brand" href="#!">Pizzataxi</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="order.php">Order</a></li>
                <li class="nav-item"><a class="nav-link" href="#!">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <?php
                if (!isset($_SESSION['username'])) {
                    print('
                        <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
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
                <h1 class="display-5 fw-bold">Login</h1>
            </div>
        </div>
    </div>
</header>
<!-- Page Content-->
<div class="container px-lg-5">
    <div class="p-4 p-lg-5 rounded-3">
        <div class="m-4 m-lg-5">

            <?php
            if (!empty($message)) {
                echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
            } else if (!empty($error)) {
                echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
            }
            ?>

            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
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
