<?php
session_start();
include('config.php');


?>
<!DOCTYPE html>
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
<header class="py-5">
    <div class="container px-lg-5">
        <div class="p-4 p-lg-5 rounded-3 text-center">
            <div class="m-4 m-lg-5">
                <h1 class="display-5 fw-bold">Pizza tracker</h1>
            </div>
        </div>
    </div>
</header>
<section class="pt-4">
    <div class="container px-lg-5">
        <!-- Page Features-->
        <?php

        $result = null;
        if (isset($_GET['userid']) && $_GET['userid'] != -1) {

            $query = "SELECT o.*, u.username FROM orders o join users u on u.user_id = o.fk_user where o.fk_user = ? order by timestamp desc";
            $stmt = $link->prepare($query);

            if ($stmt === false) {
                $error .= 'prepare() failed ' . $link->error . '<br />';
            }
            if (!$stmt->bind_param("s", $_GET['userid'])) {
                $error .= 'bind_param() failed ' . $link->error . '<br />';
            }
            if (!$stmt->execute()) {
                $error .= 'execute() failed ' . $link->error . '<br />';
            }
            $result = $stmt->get_result();
        } else {
            $query = "SELECT o.*, u.username FROM orders o join users u on u.user_id = o.fk_user order by timestamp desc";
            $result = $link->query($query);
        }

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $totalsql = "select sum(o.quantity * p.price - p.price / 100 * o.discount) as total from order_items o join pizzas p on p.pizza_id = o.fk_pizza where fk_order = " . $row['order_id'];

                $total = $link->query($totalsql);
                $total = $total->fetch_row();
                ?>
                <div class="row gx-lg-5">
                    <h3>Order #<?= $row['order_id'] ?> from <?= $row['username'] ?></h3>
                    <div class="row">
                        <div class="col-4">
                            <p class="">Timestamp: <?= $row['timestamp'] ?></p>
                        </div>
                        <div class="col-2">
                            <p>Total: <?= $total[0] ?> CHF</p>
                        </div>

                    </div>
                    <?php
                    $sql = "select o.*, p.name, p.image, p.price from order_items o join pizzas p on o.fk_pizza = p.pizza_id where fk_order = " . $row['order_id'];
                    $result2 = $link->query($sql);

                    if ($result2->num_rows > 0) {
                        // output data of each row
                        while ($row2 = $result2->fetch_assoc()) { ?>
                            <div class="row gx-lg-5">
                                <div class="card border-0 rounded-3 ">
                                    <div class="card-body ">
                                        <div class="row d-flex justify-content-between align-items-center">
                                            <div class=" col-2">
                                                <img
                                                        src="assets/pizzas/<?= $row2['image'] ?>"
                                                        class="img-fluid rounded-3" alt="Cotton T-shirt">
                                            </div>

                                            <div class="col-2">
                                                <p class="lead fw-normal mb-2"><?= $row2['quantity'] ?>x
                                                    <strong><?= $row2['name'] ?></strong></p>
                                            </div>
                                            <div class="col-2">
                                                <?php
                                                if ($row2['discount'] == null || $row2['discount'] == 0) { ?>
                                                    <p class="lead fw-normal mb-2">
                                                        <strong><?= $row2['price'] * $row2['quantity'] ?>
                                                            CHF</strong></p>
                                                <?php } else { ?>
                                                    <p class="link-dark fw-bold text-decoration-line-through"><?= ($row2["price"] * $row2['quantity']) ?>
                                                        CHF </p>
                                                    <h4 class="link-danger fw-bold "><?= ($row2["price"] / 100) * (100 - $row2["discount"]) ?>
                                                        CHF <span
                                                                class="badge bg-danger"><?= $row2["discount"] * $row2['quantity'] ?>%</span>
                                                    </h4>

                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php }
                    }
                    ?>
                </div>

                <?php
            }

            ?>

        <?php } ?>
    </div>

    </div>
</section>
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

