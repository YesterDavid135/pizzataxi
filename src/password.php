<!DOCTYPE html>
<?php
session_start();
include('config.php');

$error = '';
$message = '';
$password_old = $password_new = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {

    if (isset($_POST['password_old'])) {
        $password_old = htmlspecialchars(trim($_POST['password_old']));
        if (isset($_POST['password_new'])) {

            $password_new = trim($_POST['password_new']);
            if (empty($password_new) || !preg_match("/^([\W\w])([^\s]){7,100}$/", $password_new)) {
                $error .= "Please enter e valid password (No whitespaces, 8 - 100 Chars)<br >";
            } else
                if ($password_new != trim($_POST['password_confirm'])) {
                    $error .= "Password confirmation don't match";
                }
        } else {
            $error .= "Please enter a new Password";
        }
    } else {
        $error .= "Please enter your old password";
    }

    if (empty($error)) {
        $query = "SELECT user_id, username, password from users where user_id = ?";
        $stmt = $link->prepare($query);

        if ($stmt === false) {
            $error .= 'prepare() failed ' . $link->error . '<br />';
        }
        if (!$stmt->bind_param("s", $_SESSION['userid'])) {
            $error .= 'bind_param() failed ' . $link->error . '<br />';
        }
        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $link->error . '<br />';
        }
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {

            if (password_verify($password_old, $row['password'])) {

                $password_hash = password_hash($password_new, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password = ? WHERE user_id = " . $_SESSION['userid'];

                $stmt = $link->prepare($query);
                if ($stmt === false) {
                    $error .= 'prepare() failed ' . $link->error . '<br />';
                }

                if (!$stmt->bind_param('s', $password_hash)) {
                    $error .= 'bind_param() failed ' . $link->error . '<br />';
                }

                if (!$stmt->execute()) {
                    $error .= 'execute() failed ' . $link->error . '<br />';
                }

                die();

            } else {
                $error .= "Password is wrong";
            }
        } else {
            $error .= "Something went wrong";
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
                <h1 class="display-5 fw-bold">Change Password</h1>
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
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) {
                ?>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="password" class="form-label">Old Password</label>
                        <input type="password" class="form-control" name="password_old" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control" name="password_new" id="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" name="password_confirm" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-dark">Submit</button>
                </form>
            <?php } else { ?>
                <p>Please log in to change your password</p>
            <?php } ?>
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
