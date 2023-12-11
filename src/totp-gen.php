<!DOCTYPE html>
<?php
require __DIR__ . '/../vendor/autoload.php';
session_start();
include('config.php');
$g = new \PHPGangsta_GoogleAuthenticator();

if (!isset($_SESSION['loggedin'])
    || $_SESSION['loggedin'] //Not Logged in
    || !isset($_SESSION['userid'])) { //but user id is set (should be only after register)
    echo "Nope";  //todo noel display something nice here
    exit();
}
$userid = $_SESSION['userid'];
$username = $_SESSION['username'];

$secret = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (!isset($_POST['totp'])) {
        echo "Please give me totp"; //todo noel do it again, lol
        exit();
    }

    $totp = htmlspecialchars(trim($_POST['totp']));
    $query = "SELECT totp_secret from users where user_id = ? and totp_verified = 0 limit 1";

    $stmt = $link->prepare($query);
    $error = "";
    if ($stmt === false) {
        $error .= 'prepare() failed ' . $link->error . '<br >';
    }

    if (!$stmt->bind_param('i', $userid)) {
        $error .= 'bind_param() failed ' . $link->error . '<br >';
    }

    if (!$stmt->execute()) {
        $error .= 'execute() failed ' . $link->error . '<br >';
    }

    if ($error) {
        echo "Lost"; //todo noeeele
        exit();
    }

    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $secret = $row['totp_secret'];
    }

    if ($g->verifyCode($secret, $totp, 2)) {
        echo "hooray";
        $query = "UPDATE users SET totp_verified = 1 where user_id = ?";

        $stmt = $link->prepare($query);
        $error = "";
        if ($stmt === false) {
            $error .= 'prepare() failed ' . $link->error . '<br >';
        }

        if (!$stmt->bind_param('i', $userid)) {
            $error .= 'bind_param() failed ' . $link->error . '<br >';
        }

        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $link->error . '<br >';
            exit();
        }
        echo "Yay it worked!";
        $_SESSION['loggedin'] = true;
        header('Location: index.php');
    } else {
        $error .= "Oops, wrong code :(<br>";
    }
} else {
    $secret = $g->createSecret();

    $query = "UPDATE users SET totp_secret = ? where user_id = ? AND totp_verified = 0";

    $stmt = $link->prepare($query);
    $error = "";
    if ($stmt === false) {
        $error .= 'prepare() failed ' . $link->error . '<br >';
    }

    if (!$stmt->bind_param('si', $secret, $userid)) {
        $error .= 'bind_param() failed ' . $link->error . '<br >';
    }

    if (!$stmt->execute()) {
        $error .= 'execute() failed ' . $link->error . '<br >';
    }

    if ($error != "" || $stmt->affected_rows == 0) {
        echo "error, lol"; //todo noel, yk °^°
        exit();
    }
}

$qrCodeUrl = $g->getQRCodeGoogleUrl($username, $secret, "PizzaTaxi");
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Pizzataxi</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico">
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet">
    <script async
            src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6177030326507154"
            crossorigin="anonymous"></script>
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Responsive navbar-->
    <?php
    include('navbar.php');
    ?>
    <header class="pt-5">
        <div class="container px-lg-5">
            <div class="p-4 p-lg-5 rounded-3 text-center">
                <div class="m-2 m-lg-0">
                    <h1 class="display-5 fw-bold">2 Factor Authentication</h1>
                </div>
            </div>
        </div>
    </header>
    <div class="container px-lg-5">
        <div class="p-4 p-lg-5 rounded-3">
            <div class="m-lg-5 pb-4">
                <?php
                if (!empty($error)) {
                    echo "<div class=\"alert alert-danger\" role=\"alert\">" . $error . "</div>";
                }
                ?>
                <div class="text-center mb-5">
                    <img src="<?=$qrCodeUrl?>" alt="qrcode">
                </div>
                <form action="totp-gen.php" method="POST">
                    <div class="mb-3">
                        <label for="totp" class="form-label">Verify One Time Password</label>
                        <input name="totp" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-dark">Verify</button>
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