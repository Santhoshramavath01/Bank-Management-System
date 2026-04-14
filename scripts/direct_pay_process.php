<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require('../configs/db.php');

/* CHECK LOGIN */
if (!isset($_SESSION['AccNo'])) {
    header("Location: ../login.php?msg=Please login");
    exit;
}

$sender  = $_SESSION['AccNo'];
$upi     = trim($_POST['upi_id']);
$amount  = $_POST['amount'];
$remarks = trim($_POST['remarks']);
$pin     = $_POST['upi_pin'];

$date = date("Y-m-d H:i:s");

/* =========================
   ✅ VALIDATE INPUT
========================= */

if (empty($upi) || empty($amount) || empty($pin)) {
    header("Location: ../pages/dashboard/direct_pay.php?msg=All required fields must be filled");
    exit;
}

if (!is_numeric($amount) || $amount <= 0) {
    header("Location: ../pages/dashboard/direct_pay.php?msg=Invalid amount");
    exit;
}

/* =========================
   🔐 VERIFY UPI PIN
========================= */

$stmt = mysqli_prepare($conn, "SELECT upi_pin FROM userinfo WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $sender);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);

if ($res && mysqli_num_rows($res) > 0) {
    $data = mysqli_fetch_assoc($res);

    if (!password_verify($pin, $data['upi_pin'])) {
        header("Location: ../pages/dashboard/direct_pay.php?msg=Invalid UPI PIN");
        exit;
    }
} else {
    header("Location: ../pages/dashboard/direct_pay.php?msg=User not found");
    exit;
}

/* =========================
   👤 FIND RECEIVER
========================= */

$stmt = mysqli_prepare($conn, "SELECT AccNo FROM userinfo WHERE UPI=?");
mysqli_stmt_bind_param($stmt, "s", $upi);
mysqli_stmt_execute($stmt);
$res2 = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($res2) == 0) {
    header("Location: ../pages/dashboard/direct_pay.php?msg=UPI ID not found");
    exit;
}

$receiver = mysqli_fetch_assoc($res2)['AccNo'];

/* ❌ PREVENT SELF TRANSFER */
if ($sender == $receiver) {
    header("Location: ../pages/dashboard/direct_pay.php?msg=Cannot send money to yourself");
    exit;
}

/* =========================
   💰 CHECK BALANCE
========================= */

$stmt = mysqli_prepare($conn, "SELECT Balance FROM balance WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $sender);
mysqli_stmt_execute($stmt);
$res3 = mysqli_stmt_get_result($stmt);
$bal = mysqli_fetch_assoc($res3)['Balance'];

if ($amount > $bal) {
    header("Location: ../pages/dashboard/direct_pay.php?msg=Insufficient Balance");
    exit;
}

/* =========================
   💸 PROCESS TRANSACTION
========================= */

$txn = "TXN" . rand(100000, 999999);

$stmt = mysqli_prepare($conn,
"INSERT INTO transactions
(Sender, Receiver, Amount, Remarks, DateTime, TxnID)
VALUES (?, ?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "iiisss",
    $sender,
    $receiver,
    $amount,
    $remarks,
    $date,
    $txn
);

/* =========================
   ⚠️ HANDLE DB ERRORS
========================= */

try {

    mysqli_stmt_execute($stmt);

} catch (mysqli_sql_exception $e) {

    $error = $e->getMessage();

    if (strpos($error, 'Invalid Amount') !== false) {
        $msg = "Invalid amount entered";
    } elseif (strpos($error, 'Insufficient Balance') !== false) {
        $msg = "Insufficient balance";
    } else {
        $msg = "Transaction failed. Try again.";
    }

    header("Location: ../pages/dashboard/direct_pay.php?msg=" . urlencode($msg));
    exit;
}

/* =========================
   ✅ SUCCESS
========================= */

header("Location: ../pages/dashboard/transfer_success.php?txn=$txn");
exit;

?>