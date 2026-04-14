<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('../../configs/db.php');

if (!isset($_SESSION['AccNo'])) {
    die("User not logged in");
}

$accNo = $_SESSION['AccNo'];
$msg = "";
$balance = "";
$showBalance = false;

$sql = "SELECT upi_pin, upi_pin_length FROM userinfo WHERE AccNo = ?";
$stmt = mysqli_prepare($conn, $sql);

$pinExists = null;
$pinLength = null;

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $accNo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $pinExists = $row['upi_pin'];
        $pinLength = $row['upi_pin_length'];
    }

    mysqli_stmt_close($stmt);
}

/* CREATE PIN */

if (isset($_POST['create_pin'])) {

    $pin = $_POST['pin'];
    $confirm = $_POST['confirm_pin'];
    $length = $_POST['pin_length'];

    if (strlen($pin) != $length) {
        $msg = "PIN must be $length digits";
    } elseif ($pin != $confirm) {
        $msg = "PIN mismatch";
    } else {

        $hash = password_hash($pin, PASSWORD_DEFAULT);

        $update = "UPDATE userinfo SET upi_pin=?, upi_pin_length=? WHERE AccNo=?";
        $stmt = mysqli_prepare($conn, $update);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sii", $hash, $length, $accNo);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        header("Location: check_balance.php");
        exit;
    }
}

/* VERIFY PIN */

if (isset($_POST['check_pin'])) {

    $pin = $_POST['upi_pin'];

    if ($pinExists && password_verify($pin, $pinExists)) {

        $bal = "SELECT Balance FROM balance WHERE AccNo = ?";
        $stmt = mysqli_prepare($conn, $bal);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $accNo);
            mysqli_stmt_execute($stmt);
            $res = mysqli_stmt_get_result($stmt);

            if ($res && mysqli_num_rows($res) > 0) {
                $balance = mysqli_fetch_assoc($res)['Balance'];
                $showBalance = true;
            }

            mysqli_stmt_close($stmt);
        }

    } else {
        $msg = "Invalid UPI PIN";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
<title>Check Balance</title>

<style>
body {
    font-family: Arial;
    background: #f4f6fb;
}

.container {
    width: 420px;
    margin: 80px auto;
    background: white;
    padding: 35px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
}

.title {
    font-size: 22px;
    margin-bottom: 25px;
    color: #4e73df;
    font-weight: 600;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

button {
    width: 100%;
    padding: 10px;
    background: #4e73df;
    border: none;
    color: white;
    border-radius: 8px;
    cursor: pointer;
}

button:hover {
    background: #2e59d9;
}

.msg {
    color: red;
    margin-top: 10px;
}

.balance {
    font-size: 26px;
    color: green;
    margin-top: 20px;
    font-weight: bold;
}
</style>
</head>

<body>

<div class="container">

<?php if (empty($pinExists)) { ?>

<div class="title">Create UPI PIN</div>

<form method="POST">
<select name="pin_length">
<option value="4">4 Digit PIN</option>
<option value="6">6 Digit PIN</option>
</select>

<input type="password" name="pin" placeholder="Enter PIN" required>
<input type="password" name="confirm_pin" placeholder="Confirm PIN" required>

<button name="create_pin">Create PIN</button>
</form>

<?php } else { ?>

<div class="title">Enter UPI PIN</div>

<form method="POST">
<input type="password" name="upi_pin" placeholder="Enter UPI PIN" required>
<button name="check_pin">Check Balance</button>
</form>

<?php } ?>

<div class="msg"><?php echo $msg; ?></div>

<?php
if ($showBalance) {
    echo "<div class='balance'>₹ $balance</div>";
}
?>

</div>

</body>
</html>