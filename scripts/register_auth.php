<?php

if (!isset($_POST['submit'])) {
    header('Location: ../pages/register.php');
    exit;
}

require('../configs/db.php');

$fullname = $_POST['fullName'];
$address  = $_POST['address'];
$email    = $_POST['email'];
$mobile   = $_POST['mobile'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

/* -----------------------------
   Generate IFSC
--------------------------------*/

function generateIFSC() {
    $bank = "FINO";
    $branch = "0012"; // same branch code

    return $bank . "0" . $branch;
}

/* -----------------------------
   Generate 12-digit Account Number
--------------------------------*/

function generateAccountNumber($conn) {
    $year = date("y");      // e.g., 24
    $branch = "0012";       // branch code

    do {
        $random = rand(100000, 999999);
        $accNo = $year . $branch . $random;

        $check = mysqli_query($conn, "SELECT AccNo FROM credentials WHERE AccNo='$accNo'");
    } while (mysqli_num_rows($check) > 0);

    return $accNo;
}

$accNo = generateAccountNumber($conn);
$ifsc  = generateIFSC();   // ✅ IMPORTANT (you missed this)

/* -----------------------------
   Check Duplicate Email
--------------------------------*/

$stmt = mysqli_prepare($conn, "SELECT AccNo FROM userinfo WHERE Email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    header('Location: ../pages/register.php?msg=Email already registered');
    exit;
}

/* -----------------------------
   Check Duplicate Mobile
--------------------------------*/

$stmt = mysqli_prepare($conn, "SELECT AccNo FROM userinfo WHERE Mobile = ?");
mysqli_stmt_bind_param($stmt, "s", $mobile);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    header('Location: ../pages/register.php?msg=Mobile already registered');
    exit;
}

/* -----------------------------
   Generate UPI ID
--------------------------------*/

$upi_id = $mobile . "@finova";

/* -----------------------------
   Insert into credentials
--------------------------------*/

$stmt = mysqli_prepare($conn, "INSERT INTO credentials (AccNo, Pass) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "is", $accNo, $password);
mysqli_stmt_execute($stmt);

/* -----------------------------
   Create Balance
--------------------------------*/

$stmt = mysqli_prepare($conn, "INSERT INTO balance (AccNo, Balance, Interest) VALUES (?, 0, 0)");
mysqli_stmt_bind_param($stmt, "i", $accNo);
mysqli_stmt_execute($stmt);

/* -----------------------------
   Save User Info (FIXED)
--------------------------------*/

$stmt = mysqli_prepare($conn, 
"INSERT INTO userinfo (AccNo, Name, Address, Email, Mobile, UPI, IFSC) 
VALUES (?, ?, ?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "issssss",
    $accNo, $fullname, $address, $email, $mobile, $upi_id, $ifsc
);

mysqli_stmt_execute($stmt);

/* -----------------------------
   Start Session
--------------------------------*/

session_start();
$_SESSION['AccNo'] = $accNo;

/* -----------------------------
   Redirect
--------------------------------*/

header('Location: ../pages/dashboard/index.php');
exit;

?>