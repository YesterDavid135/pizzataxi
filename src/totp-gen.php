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
    $query = "SELECT totp_secret from users where user_id = ? limit 1";

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
        echo "Wrong code your poor ass guy";
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
echo "QR-Code URL: " . $qrCodeUrl . "<br>";

echo '<img src="' . htmlspecialchars($qrCodeUrl) . '" alt="TOTP QR Code">';

?>
<form action="totp-gen.php" method="POST">
    <label>Verify One Time Password</label>
    <input name="totp">
    <button type="submit"></button>
</form>
