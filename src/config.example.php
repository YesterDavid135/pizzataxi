<?php
/*
 * IMPORTANT
 * Please copy this file to config.php and adjust the variables on line 7-10
*/

define('DB_SERVER', 'hostname');
define('DB_USERNAME', 'username');
define('DB_PASSWORD', 'password');
define('DB_NAME', 'dbname');

// connect to database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
