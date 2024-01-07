<!DOCTYPE html>
<?php
session_start();

if ($_SESSION['admin'] == 0) {
    header('HTTP/1.1 401 Unauthorized');
    header("Location: 401.php");
    exit;
}

include('config.php');

$error = $message = '';

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['status'])) {
        $status = htmlspecialchars(trim($_POST['status']));

        if ($status == "") {
            $status = null;
        }

        if (strlen($status) > 255) {
            $error .= "Please enter e valid comment (Max 255 chars)<br>";
        }
    }

    if (empty($error)) {
        $query = "update orders set status = ? where order_id = ? ";

        $stmt = $link->prepare($query);
        if ($stmt === false) {
            $error .= 'prepare() failed ' . $link->error . '<br >';
        }

        if (!$stmt->bind_param('si', $status, $_POST['order_id'])) {
            $error .= 'bind_param() failed ' . $link->error . '<br >';
        }

        if (!$stmt->execute()) {
            $error .= 'execute() failed ' . $link->error . '<br >';
        }
    }
}

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
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-6177030326507154"
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
                <h1 class="display-5 fw-bold">Admin Center</h1>
            </div>
        </div>
    </div>
</header>
<!-- Page Content-->
    <div class="container px-lg-5">
        <!-- Page Features-->
        <ul class="list-group">
            <?php
            // Prepare a select statement
            $sql = "SELECT o.*, u.username FROM orders o join users u on u.user_id = o.fk_user order by timestamp desc";

            $result = $link->query($sql);

            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <li class="list-group-item">Order #<?= $row["order_id"] ?> / User: <?= $row["username"] ?>
                        / <?= $row["timestamp"] ?>
                        <form action="admin.php" method="post">
                            <div class="row">
                                <div class="mb-3 col-9">
                                    <input type="text" class="form-control" name="status" maxlength="255"
                                           value="<?= htmlspecialchars($row["status"]) ?>" placeholder="Create a comment...">
                                </div>
                                <input name="order_id" value="<?= $row["order_id"] ?>" hidden>
                                <div class="col-2">
                                    <button type="submit" class="btn btn-dark">Submit</button>
                                </div>
                            </div>
                        </form>
                    </li>

                    <?php
                }
            }

            ?>
        </ul>
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
