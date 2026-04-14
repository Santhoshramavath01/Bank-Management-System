<?php

require(__DIR__ . '/../configs/db.php');

header('Content-Type: text/plain');

if (!isset($_POST['accNo'])) {
    echo "notfound";
    exit;
}

$accNo = $_POST['accNo'];

if (!is_numeric($accNo)) {
    echo "notfound";
    exit;
}

$stmt = mysqli_prepare($conn, "SELECT Name FROM userinfo WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $accNo);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    echo $row['Name'];
} else {
    echo "notfound";
}

exit;