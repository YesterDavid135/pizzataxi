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
        if (isset($_POST['password'])) {
            $password = trim($_POST['password']);

        }
    } else {
        $error .= "Please provide a username and a password";
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
                $_SESSION['userid'] = $row['user_id'];

                session_regenerate_id(true);

                header("Location: index.php");

                die();

            } else {
                $error .= "Username or password is wrong";
            }
        } else {
            $error .= "Username or password is wrong";
        }
    }
}

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
            <div class="m-2 m-lg-0">
                <h1 class="display-5 fw-bold">Login</h1>
            </div>
        </div>
    </div>
</header>
<!-- Page Content-->
<div class="container px-lg-5">
    <div class="p-4 p-lg-5 rounded-3">
        <div class="m-lg-5 p-4">
            <?php
            // Ausgabe der Fehlermeldungen
            if (!empty($error)) {
                echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
            } else if (!empty($message)) {
                echo "<div class=\"alert alert-success\" role=\"alert\">" . $message . "</div>";
            }
            ?>
            <form action="" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required
                           value="<?= isset($_POST['username']) ? $_POST['username'] : '' ?>">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
                <button type="submit" class="btn btn-dark">Submit</button>
                <p>Don't have an Account yet? <a href="register.php" class="text-reset">Register here</a></p>
            </form>
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
