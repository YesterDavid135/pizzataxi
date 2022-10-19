<?php
session_start();
require_once "config.php";

if (!$_SESSION['loggedin']) {
    echo "Please log in to order a pizza";
    exit();
}
if (count($_SESSION['cart']) < 1) {
    echo "Please add at least one pizza in your cart";
    exit();
}

// Create Order
$query = 'INSERT INTO orders (fk_user) values (?)';
$stmt = $link->prepare($query);

if (!$stmt->bind_param('i', $_SESSION['userid'])) {
    echo 'bind_param() failed ' . $link->error . '<br />';
    exit();
}
if (!$stmt->execute()) {
    echo 'execute() failed ' . $link->error . '<br />';
    exit();
}

$orderid = $link->query("SELECT LAST_INSERT_ID()");
$orderid = $orderid->fetch_assoc()['LAST_INSERT_ID()'];

//Create Order Items

foreach (array_keys($_SESSION['cart']) as $key) {
    $query = 'INSERT INTO order_items (quantity, fk_order, fk_pizza, discount) values (?, ?, ?, (select discount from pizzas where pizza_id = ?));';
    $stmt = $link->prepare($query);
    if (!$stmt->bind_param('iiii', $_SESSION['cart'][$key], $orderid, $key, $key)) {
        echo 'bind_param() failed ' . $link->error . '<br />';
        exit();
    }
    if (!$stmt->execute()) {
        echo 'execute() failed ' . $link->error . '<br />';
        exit();
    }

}
$_SESSION['cart'] = array();
header('Location: success.php');
?>
