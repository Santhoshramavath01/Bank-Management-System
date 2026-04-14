<?php

session_start();
require(__DIR__ . '/../configs/db.php');

$accNo = $_SESSION['AccNo'];

$type = $_POST['bill_type'];
$provider = $_POST['provider'];
$amount = $_POST['amount'];
$pin = $_POST['upi_pin'];

/* HANDLE DYNAMIC FIELD */

if($type == "Mobile"){
    $consumer = $_POST['mobile'];
}
elseif($type == "DTH"){
    $consumer = $_POST['subscriber_id'];
}
elseif($type == "Electricity"){
    $consumer = $_POST['consumer_no'];
}
elseif($type == "Water"){
    $consumer = $_POST['connection_id'];
}
else{
    $consumer = "";
}

/* VERIFY PIN */

$stmt = mysqli_prepare($conn, "SELECT upi_pin FROM userinfo WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $accNo);
mysqli_stmt_execute($stmt);

$res = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($res);

if (!$data || !password_verify($pin, $data['upi_pin'])) {
    header("Location: ../pages/dashboard/bill_pay.php?msg=Invalid PIN");
    exit;
}

/* CHECK BALANCE */

$stmt = mysqli_prepare($conn, "SELECT Balance FROM balance WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $accNo);
mysqli_stmt_execute($stmt);

$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);

if ($amount > $row['Balance']) {
    header("Location: ../pages/dashboard/bill_pay.php?msg=Insufficient Balance");
    exit;
}

/* GENERATE BILL ID */

$bill_id = "BILL" . date("YmdHis") . rand(100,999);

/* INSERT BILL */

$stmt = mysqli_prepare($conn,
"INSERT INTO bill_payments 
(BillID, AccNo, BillType, Provider, ConsumerNo, Amount)
VALUES (?, ?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "sisssd",
$bill_id, $accNo, $type, $provider, $consumer, $amount);

mysqli_stmt_execute($stmt);

/* TRANSACTION (USE SYSTEM ACCOUNT) */

$txn = "TXN" . rand(100000,999999);
$receiver = 999999999999; // system account
$userRemark = $_POST['remarks'] ?? '';

$remarks = "Bill Payment - $type";

if(!empty($userRemark)){
    $remarks .= " ($userRemark)";
}

$stmt = mysqli_prepare($conn,
"INSERT INTO transactions (Sender, Receiver, Amount, Remarks, TxnID)
VALUES (?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "iiiss",
$accNo, $receiver, $amount, $remarks, $txn);

mysqli_stmt_execute($stmt);

/* SUCCESS */

header("Location: ../pages/dashboard/bill_success.php?bill=$bill_id");
exit;

?>