<?php
session_start();

if (!isset($_SESSION['AccNo'])) {
header("Location: ../pages/login.php");
exit;
}

require('../configs/db.php');

$sender = $_SESSION['AccNo'];

$receiver = $_POST['receiver_accNo'];
$bank = $_POST['bank_name'];
$ifsc = $_POST['ifsc'];
$amount = $_POST['amount'];
$remarks = $_POST['remarks'];
$upi_pin = $_POST['upi_pin'];

$date = date("Y-m-d H:i:s");

/* Check UPI PIN */

$sqlPin = "SELECT upi_pin FROM userinfo WHERE AccNo='$sender'";
$resPin = mysqli_query($conn,$sqlPin);
$dataPin = mysqli_fetch_assoc($resPin);

if(!password_verify($upi_pin,$dataPin['upi_pin'])){
header("Location: ../pages/dashboard/transfer.php?msg=Invalid UPI PIN");
exit;
}

/* Check Receiver */

$sqlCheckReceiver = "SELECT * FROM userinfo WHERE AccNo='$receiver'";
$resReceiver = mysqli_query($conn,$sqlCheckReceiver);

if(mysqli_num_rows($resReceiver)==0){
header("Location: ../pages/dashboard/transfer.php?msg=Receiver not found");
exit;
}

/* Check Sender Balance */

$sqlBal = "SELECT Balance FROM balance WHERE AccNo='$sender'";
$resBal = mysqli_query($conn,$sqlBal);
$balData = mysqli_fetch_assoc($resBal);

$balance = $balData['Balance'];

if($amount > $balance){
header("Location: ../pages/dashboard/transfer.php?msg=Insufficient Balance");
exit;
}

/* Deduct Sender Balance */

$newSenderBal = $balance - $amount;

$updateSender = "UPDATE balance SET Balance='$newSenderBal' WHERE AccNo='$sender'";
mysqli_query($conn,$updateSender);

/* Add Receiver Balance */

$sqlReceiverBal = "SELECT Balance FROM balance WHERE AccNo='$receiver'";
$resReceiverBal = mysqli_query($conn,$sqlReceiverBal);
$dataReceiverBal = mysqli_fetch_assoc($resReceiverBal);

$receiverBalance = $dataReceiverBal['Balance'];

$newReceiverBal = $receiverBalance + $amount;

$updateReceiver = "UPDATE balance SET Balance='$newReceiverBal' WHERE AccNo='$receiver'";
mysqli_query($conn,$updateReceiver);

/* Generate Transaction ID */

$txn_id = "TXN".rand(100000,999999);

/* Save Transaction */

$sqlTxn = "INSERT INTO transactions 
(Sender,Receiver,Amount,Remarks,DateTime,TxnID)
VALUES
('$sender','$receiver','$amount','$remarks','$date','$txn_id')";

mysqli_query($conn,$sqlTxn);

/* Redirect to Confirmation */

header("Location: ../pages/dashboard/transfer_success.php?txn=$txn_id");

?>