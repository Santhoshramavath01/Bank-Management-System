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
   Check Duplicate Email
--------------------------------*/

$sql_dupCheck = "SELECT * FROM userinfo WHERE Email = '$email'";
$result_dupCheck = mysqli_query($conn, $sql_dupCheck);

if (!$result_dupCheck) {
    header('Location: ../pages/register.php?msg=Database error');
    exit;
}

if (mysqli_num_rows($result_dupCheck) != 0) {
    header('Location: ../pages/register.php?msg=Email already registered');
    exit;
}

/* -----------------------------
   Check Duplicate Mobile
--------------------------------*/

$sql_mobileCheck = "SELECT * FROM userinfo WHERE Mobile = '$mobile'";
$result_mobileCheck = mysqli_query($conn, $sql_mobileCheck);

if (mysqli_num_rows($result_mobileCheck) != 0) {
    header('Location: ../pages/register.php?msg=Mobile already registered');
    exit;
}

/* -----------------------------
   Generate UPI ID
--------------------------------*/

$upi_id = $mobile . "@finova";

/* -----------------------------
   Generate Account Number
--------------------------------*/

$sql_genCreds = "INSERT INTO credentials (AccNo, Pass) VALUES (NULL, '$password')";
$result_genCreds = mysqli_query($conn, $sql_genCreds);

if (!$result_genCreds) {
    header('Location: ../pages/register.php?msg=Account creation failed');
    exit;
}

/* -----------------------------
   Get Generated Account Number
--------------------------------*/

$sql_getAccNo = "SELECT AccNo FROM credentials ORDER BY AccNo DESC LIMIT 1";
$result_getAccNo = mysqli_query($conn, $sql_getAccNo);
$accNo = mysqli_fetch_assoc($result_getAccNo)['AccNo'];

/* -----------------------------
   Create Balance
--------------------------------*/

$sql_genBal = "INSERT INTO balance (AccNo, Balance) VALUES ('$accNo', '0')";
mysqli_query($conn, $sql_genBal);

/* -----------------------------
   Save User Information
--------------------------------*/

$sql_saveUserInfo = "
INSERT INTO userinfo 
(AccNo, Name, Address, Email, Mobile, UPI)
VALUES 
('$accNo', '$fullname', '$address', '$email', '$mobile', '$upi_id')
";

$result_saveUserInfo = mysqli_query($conn, $sql_saveUserInfo);

if (!$result_saveUserInfo) {
    header('Location: ../pages/register.php?msg=User creation failed');
    exit;
}

/* -----------------------------
   Start Session
--------------------------------*/

session_start();
$_SESSION['AccNo'] = $accNo;

/* -----------------------------
   Redirect to Dashboard
--------------------------------*/

header('Location: ../pages/dashboard/index.php');
exit;

?>