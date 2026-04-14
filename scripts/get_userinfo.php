<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require(__DIR__ . '/../configs/db.php');

$accNo = $_SESSION['AccNo'];

/* -----------------------------
   Fetch User Info (SAFE)
--------------------------------*/

$stmt = mysqli_prepare($conn, 
"SELECT Name, Address, Email, Mobile, UPI, IFSC 
FROM userinfo 
WHERE AccNo = ?");

mysqli_stmt_bind_param($stmt, "i", $accNo);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    $name    = $row['Name'] ?? "";
    $address = $row['Address'] ?? "";
    $email   = $row['Email'] ?? "";
    $mobile  = $row['Mobile'] ?? "";
    $upi     = $row['UPI'] ?? "";
    $ifsc    = $row['IFSC'] ?? "";   // ✅ ADDED

    $fName = explode(" ", $name)[0];

} else {

    $name = "";
    $address = "";
    $email = "";
    $mobile = "";
    $upi = "";
    $ifsc = "";   // ✅ ADDED
    $fName = "";

}

?>