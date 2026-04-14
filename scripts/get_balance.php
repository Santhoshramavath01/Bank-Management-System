<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include(__DIR__ . "\..\configs\db.php");

if (!isset($_SESSION['AccNo'])) {
    die("User not logged in");
}

$accNo = $_SESSION['AccNo'];

$sql = "SELECT Balance FROM balance WHERE AccNo = ?";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $accNo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $balance = $data['Balance'];
    } else {
        $balance = 0;
    }

    mysqli_stmt_close($stmt);
} else {
    die("Query failed");
}
?>