<?php
session_start();
require_once "config.php";

// If the user clicked the add to cart button on the product page we can check for the form data
if (isset($_POST['pizza_id']) && is_numeric($_POST['pizza_id'])) {

    // Set the post variables so we easily identify them, also make sure they are integer
    $pizza_id = (int)$_POST['pizza_id'];
    // Prepare the SQL statement, we basically are checking if the product exists in our database
    $query = "SELECT * FROM pizzas where pizza_id=?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("s", $_POST['pizza_id']);
    $stmt->execute();
    $pizza = $stmt->get_result();
    // Check if the product exists (array is not empty)
    if ($pizza) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {

            if (array_key_exists($pizza_id, $_SESSION['cart'])) {
                if (isset($_POST['quantity'])) {
                    $quantity = (int)$_POST['quantity'];
                    $_SESSION['cart'][$pizza_id] = $quantity;
                } else {
                    // Product exists in cart so just update the quanity
                    $_SESSION['cart'][$pizza_id]++;
                }
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$pizza_id] = 1;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($pizza_id => 1);
        }
    }
// Prevent form resubmission...
    header('location: cart.php');
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="refresh" content="500">
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
<header class="py-5">
    <div class="container px-lg-5">
        <div class="p-4 p-lg-5 rounded-3 text-center">
            <div class="m-4 m-lg-5">
                <h1 class="display-5 fw-bold">Shopping Cart</h1>
                <p class="fs-4 text-danger">Discount changes every 15 Minutes</p>
            </div>
        </div>
    </div>
</header>
<div class="container px-lg-5">
    <!-- Page Features-->
    <?php
    if (!isset($_SESSION['cart']) || count($_SESSION['cart']) <= 0) {
        echo "No Items in Cart";
    } else {
        $cartarray = $_SESSION['cart'];

        $sql = "SELECT * FROM pizzas where pizza_id IN (" . implode(',', array_keys($cartarray)) . ")";

        $result = $link->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="row gx-lg-5">
                    <div class="card rounded-3 mb-4">
                        <div class="card-body p-4">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="col-md-2 col-lg-2 col-xl-2">
                                    <img
                                            src="assets/pizzas/<?= $row['image'] ?>"
                                            class="img-fluid rounded-3" alt="Cotton T-shirt">
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-3">
                                    <p class="lead fw-normal mb-2"><?= $row['name'] ?> </p>
                                    <p><?= $row['description'] ?></p>
                                </div>
                                <div class="col-md-3 col-lg-3 col-xl-2 d-flex">
                                    <form action="cart.php" method="post">
                                        <input name="pizza_id" value="<?= $row['pizza_id'] ?>" hidden>
                                        <input min="0" name="quantity"
                                               value="<?= $cartarray[$row['pizza_id']] ?>"
                                               type="number"
                                               class="form-control form-control-sm">
                                        <!-- todo forward changes to session -->

                                        <button type="submit" class="btn btn-outline-success px-2">
                                            Change
                                        </button>
                                    </form>
                                </div>
                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                    <?php if ($row["discount"]) { ?>
                                        <div>
                                            <p class="link-dark fw-bold text-decoration-line-through"><?= $row["price"] * $cartarray[$row['pizza_id']] ?>
                                                CHF </p>
                                            <h4 class="link-danger fw-bold "><?= ($row["price"] / 100) * (100 - $row["discount"]) * $cartarray[$row['pizza_id']] ?>
                                                CHF <span class="badge bg-danger"><?= $row["discount"] ?>%</span>
                                            </h4>
                                        </div>
                                    <?php } else { ?>
                                        <div>
                                            <h4 class="link-dark fw-bold"><?= $row["price"] * $cartarray[$row['pizza_id']] ?>
                                                CHF</h4>
                                        </div> <?php } ?>
                                </div>
                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                    <a href="#!" class="text-danger"><i class="fas fa-trash fa-lg"></i></a>
                                    <!-- todo remove from session -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
        }

        ?>
        <div class="col-5"></div>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin']) { ?>
            <a class="btn btn-success" href="order.php">Place Order</a>
        <?php } else { ?>
            <a class="btn btn-warning" href="login.php">Log in to Place Order</a>

        <?php }
    } ?>
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


