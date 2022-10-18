<?php
session_start();
include('config.php');

if (!$_SESSION['loggedin']) {
    echo "Please log in to track your pizza";
    exit();
}


// Create Order
$query = "SELECT * from orders where fk_user = ?";
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

while($row = $result->fetch_assoc()) {

    print_r($row);
}
$orderid = $link->query("SELECT LAST_INSERT_ID()");
$orderid = $orderid->fetch_assoc()['LAST_INSERT_ID()'];


?>

