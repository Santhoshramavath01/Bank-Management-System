<?php

session_start();
require('../configs/db.php');

$sender = $_SESSION['AccNo'];

$upi = $_POST['upi_id'];
$amount = $_POST['amount'];
$remarks = $_POST['remarks'];
$pin = $_POST['upi_pin'];

$date = date("Y-m-d H:i:s");

/* VERIFY UPI PIN */

$sql = "SELECT upi_pin FROM userinfo WHERE AccNo='$sender'";
$res = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($res);

if(!password_verify($pin,$data['upi_pin'])){

header("Location: ../pages/dashboard/direct_pay.php?msg=Invalid UPI PIN");
exit;

}

/* FIND RECEIVER USING UPI */

$sql2 = "SELECT AccNo FROM userinfo WHERE UPI='$upi'";
$res2 = mysqli_query($conn,$sql2);

if(mysqli_num_rows($res2) == 0){

header("Location: ../pages/dashboard/direct_pay.php?msg=UPI ID not found");
exit;

}

$receiver = mysqli_fetch_assoc($res2)['AccNo'];

/* CHECK BALANCE */

$sql3 = "SELECT Balance FROM balance WHERE AccNo='$sender'";
$res3 = mysqli_query($conn,$sql3);
$bal = mysqli_fetch_assoc($res3)['Balance'];

if($amount > $bal){

header("Location: ../pages/dashboard/direct_pay.php?msg=Insufficient Balance");
exit;

}

/* UPDATE SENDER BALANCE */

$newSender = $bal - $amount;

mysqli_query($conn,
"UPDATE balance SET Balance='$newSender' WHERE AccNo='$sender'");

/* UPDATE RECEIVER BALANCE */

$sql4 = "SELECT Balance FROM balance WHERE AccNo='$receiver'";
$res4 = mysqli_query($conn,$sql4);
$rb = mysqli_fetch_assoc($res4)['Balance'];

$newReceiver = $rb + $amount;

mysqli_query($conn,
"UPDATE balance SET Balance='$newReceiver' WHERE AccNo='$receiver'");

/* SAVE TRANSACTION */

$txn = "TXN".rand(100000,999999);

mysqli_query($conn,
"INSERT INTO transactions
(Sender,Receiver,Amount,Remarks,DateTime,TxnID)
VALUES
('$sender','$receiver','$amount','$remarks','$date','$txn')");

/* REDIRECT TO SUCCESS PAGE */

header("Location: ../pages/dashboard/transfer_success.php?txn=$txn");

?>