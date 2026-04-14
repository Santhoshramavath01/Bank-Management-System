<?php

session_start();

if (!isset($_SESSION['AccNo'])) {
    header("Location: ../pages/login.php");
    exit;
}

require(__DIR__ . '/../configs/db.php');

$sender   = $_SESSION['AccNo'];
$receiver = $_POST['receiver_accNo'] ?? '';
$amount   = $_POST['amount'] ?? '';
$remarks  = $_POST['remarks'] ?? '';
$upi_pin  = $_POST['upi_pin'] ?? '';
$ifsc     = $_POST['ifsc'] ?? '';

/* -----------------------------
   VALIDATE INPUT
--------------------------------*/

if (empty($receiver) || empty($amount) || empty($upi_pin) || empty($ifsc)) {
    header("Location: ../pages/dashboard/transfer.php?msg=All fields required");
    exit;
}

if (!is_numeric($receiver) || !is_numeric($amount)) {
    header("Location: ../pages/dashboard/transfer.php?msg=Invalid input");
    exit;
}

if ($sender == $receiver) {
    header("Location: ../pages/dashboard/transfer.php?msg=Cannot transfer to same account");
    exit;
}

/* -----------------------------
   VERIFY UPI PIN
--------------------------------*/

$stmt = mysqli_prepare($conn, "SELECT upi_pin FROM userinfo WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $sender);
mysqli_stmt_execute($stmt);

$res = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($res);

if (!$data || !password_verify($upi_pin, $data['upi_pin'])) {
    header("Location: ../pages/dashboard/transfer.php?msg=Invalid UPI PIN");
    exit;
}

/* -----------------------------
   CHECK RECEIVER EXISTS
--------------------------------*/

$stmt = mysqli_prepare($conn, "SELECT AccNo FROM credentials WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $receiver);
mysqli_stmt_execute($stmt);

$res = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($res) == 0) {
    header("Location: ../pages/dashboard/transfer.php?msg=Receiver not found");
    exit;
}

/* -----------------------------
   VALIDATE IFSC CODE (FINAL FIX)
--------------------------------*/

$stmt = mysqli_prepare($conn, "SELECT IFSC FROM userinfo WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $receiver);
mysqli_stmt_execute($stmt);

$resIFSC = mysqli_stmt_get_result($stmt);
$rowIFSC = mysqli_fetch_assoc($resIFSC);

/* If IFSC not stored */
if (!$rowIFSC || empty($rowIFSC['IFSC'])) {
    header("Location: ../pages/dashboard/transfer.php?msg=Receiver IFSC not set");
    exit;
}

/* Normalize both values */
$enteredIFSC = strtoupper(trim($ifsc));
$dbIFSC      = strtoupper(trim($rowIFSC['IFSC']));

if ($enteredIFSC != $dbIFSC) {
    header("Location: ../pages/dashboard/transfer.php?msg=Invalid IFSC Code");
    exit;
}

/* -----------------------------
   CHECK SENDER BALANCE
--------------------------------*/

$stmt = mysqli_prepare($conn, "SELECT Balance FROM balance WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $sender);
mysqli_stmt_execute($stmt);

$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);

if (!$row) {
    header("Location: ../pages/dashboard/transfer.php?msg=Account error");
    exit;
}

$balance = $row['Balance'];

if ($amount <= 0) {
    header("Location: ../pages/dashboard/transfer.php?msg=Invalid amount");
    exit;
}

if ($amount > $balance) {
    header("Location: ../pages/dashboard/transfer.php?msg=Insufficient Balance");
    exit;
}

/* -----------------------------
   GENERATE TRANSACTION ID
--------------------------------*/

$txn_id = "TXN" . date("YmdHis") . rand(100,999);

/* -----------------------------
   INSERT TRANSACTION
--------------------------------*/

$stmt = mysqli_prepare($conn,
"INSERT INTO transactions (Sender, Receiver, Amount, Remarks, TxnID)
VALUES (?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "iiiss", $sender, $receiver, $amount, $remarks, $txn_id);

if (!mysqli_stmt_execute($stmt)) {
    header("Location: ../pages/dashboard/transfer.php?msg=Transaction failed");
    exit;
}

/* -----------------------------
   SUCCESS
--------------------------------*/

header("Location: ../pages/dashboard/transfer_success.php?txn=$txn_id");
exit;

?>