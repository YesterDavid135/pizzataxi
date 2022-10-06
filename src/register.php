<!DOCTYPE html>
<?php
session_start();
include('config.php');

$error = $message =  '';
$firstname = $lastname = $email = $username = $password =  '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['firstname'])) {
        $firstname = htmlspecialchars(trim($_POST['firstname']));

        if (empty($firstname) || strlen($firstname) > 30) {
            $error .= "Please enter e valid firstname<br />";
        }
    } else {
        $error .= "Please enter e valid firstname<br />";
    }

    if (isset($_POST['lastname'])) {
        $lastname = htmlspecialchars(trim($_POST['lastname']));

        if (empty($lastname) || strlen($lastname) > 30) {
            $error .= "Please enter e valid lastname<br />";
        }
    } else {
        $error .= "Please enter e valid lastname<br />";
    }

    if (isset($_POST['email'])) {
        $email = htmlspecialchars(trim($_POST['email']));

        if (empty($email) || strlen($email) > 100 || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $error .= "Please enter e valid mail address<br />";
        }
    } else {
        $error .= "Please enter e valid mail address<br />";
    }

    if (isset($_POST['username'])) {
        $username = htmlspecialchars(trim($_POST['username']));

        if (empty($username) || !preg_match("/[a-zA-Z]{6,30}/", $username)) {
            $error .= "Please enter e valid username<br />";
        }
    } else {
        $error .= "Please enter e valid username<br />";
    }

    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);

        if (empty($password) || !preg_match("/^([\W\w])([^\s]){6,100}$/", $password)) {
            $error .= "Please enter e valid password<br >";
        }
    } else {
        $error .= "Please enter e valid password<br />";
    }
    if (!isset($_POST['password_conf']) || $_POST['password_conf'] != $_POST['password']) {
        $error .= "Passwords doesn't match";
    }

    if (empty($error)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $query = "Insert into users (firstname, lastname, username, password, mail) values (?,?,?,?,?)";

        $stmt = $link->prepare($query);
        if ($stmt === false) {
            $error .= 'prepare() failed ' . $link->error . '<br />';
        }

        if (!$stmt->bind_param('sssss', $firstname, $lastname, $username, $password_hash, $email)) {
            $error .= 'bind_param() failed ' . $link->error . '<br />';
        }

        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $link->error . '<br />';
        }

        if (empty($error)) {
            $result = $link->query("SELECT LAST_INSERT_ID()");
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['userid'] = $result->fetch_assoc()['LAST_INSERT_ID()'];
            $link->close();
            header('Location: index.php');
            exit();
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
<?php
include('navbar.php');
?>
<!-- Header-->
<header class="py-5">
    <div class="container px-lg-5">
        <div class="p-4 p-lg-5 rounded-3 text-center">
            <div class="m-2 m-lg-0">
                <h1 class="display-5 fw-bold">Register</h1>
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
                    <label for="firstname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname" required maxlength="30">
                </div>
                <div class="mb-3">
                    <label for="lastname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" required maxlength="30">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required maxlength="100">
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" required maxlength="30">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" required maxlength="255">
                </div>
                <div class="mb-3">
                    <label for="password_conf" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" name="password_conf" id="password_conf" required
                           maxlength="255">
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
