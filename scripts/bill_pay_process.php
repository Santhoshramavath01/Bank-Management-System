<?php

session_start();
require(__DIR__ . '/../configs/db.php');

/* =========================
   🔐 CHECK LOGIN
========================= */
if (!isset($_SESSION['AccNo'])) {
    header("Location: ../login.php?msg=Please login");
    exit;
}

$accNo   = $_SESSION['AccNo'];
$type    = $_POST['bill_type'] ?? '';
$provider= trim($_POST['provider'] ?? '');
$amount  = $_POST['amount'] ?? '';
$pin     = $_POST['upi_pin'] ?? '';
$userRemark = trim($_POST['remarks'] ?? '');

$date = date("Y-m-d H:i:s");

/* =========================
   ✅ VALIDATION
========================= */

if (empty($type) || empty($provider) || empty($amount) || empty($pin)) {
    header("Location: ../pages/dashboard/bill_pay.php?msg=All fields are required");
    exit;
}

if (!is_numeric($amount) || $amount <= 0) {
    header("Location: ../pages/dashboard/bill_pay.php?msg=Invalid amount");
    exit;
}

/* =========================
   📌 HANDLE DYNAMIC FIELD
========================= */

if ($type == "Mobile") {
    $consumer = $_POST['mobile'] ?? '';
} elseif ($type == "DTH") {
    $consumer = $_POST['subscriber_id'] ?? '';
} elseif ($type == "Electricity") {
    $consumer = $_POST['consumer_no'] ?? '';
} elseif ($type == "Water") {
    $consumer = $_POST['connection_id'] ?? '';
} else {
    $consumer = '';
}

if (empty($consumer)) {
    header("Location: ../pages/dashboard/bill_pay.php?msg=Consumer details required");
    exit;
}

/* =========================
   🔐 VERIFY PIN
========================= */

$stmt = mysqli_prepare($conn, "SELECT upi_pin FROM userinfo WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $accNo);
mysqli_stmt_execute($stmt);

$res = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($res);

if (!$data || !password_verify($pin, $data['upi_pin'])) {
    header("Location: ../pages/dashboard/bill_pay.php?msg=Invalid PIN");
    exit;
}

/* =========================
   💰 CHECK BALANCE
========================= */

$stmt = mysqli_prepare($conn, "SELECT Balance FROM balance WHERE AccNo=?");
mysqli_stmt_bind_param($stmt, "i", $accNo);
mysqli_stmt_execute($stmt);

$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);

if ($amount > $row['Balance']) {
    header("Location: ../pages/dashboard/bill_pay.php?msg=Insufficient Balance");
    exit;
}

/* =========================
   🧾 GENERATE BILL ID
========================= */

$bill_id = "BILL" . date("YmdHis") . rand(100,999);

/* =========================
   💾 INSERT BILL
========================= */

$stmt = mysqli_prepare($conn,
"INSERT INTO bill_payments 
(BillID, AccNo, BillType, Provider, ConsumerNo, Amount)
VALUES (?, ?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "sisssd",
    $bill_id, $accNo, $type, $provider, $consumer, $amount
);

/* =========================
   ⚠️ HANDLE BILL INSERT ERROR
========================= */

try {
    mysqli_stmt_execute($stmt);
} catch (mysqli_sql_exception $e) {
    header("Location: ../pages/dashboard/bill_pay.php?msg=Bill payment failed");
    exit;
}

/* =========================
   💸 TRANSACTION ENTRY
========================= */

$txn = "TXN" . rand(100000,999999);
$receiver = 999999999999; // system account

$remarks = "Bill Payment - $type";
if (!empty($userRemark)) {
    $remarks .= " ($userRemark)";
}

$stmt = mysqli_prepare($conn,
"INSERT INTO transactions (Sender, Receiver, Amount, Remarks, TxnID)
VALUES (?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "iiiss",
    $accNo, $receiver, $amount, $remarks, $txn
);

/* =========================
   ⚠️ HANDLE TRANSACTION ERRORS
========================= */

try {

    mysqli_stmt_execute($stmt);

} catch (mysqli_sql_exception $e) {

    $error = $e->getMessage();

    if (strpos($error, 'Invalid Amount') !== false) {
        $msg = "Invalid amount";
    } elseif (strpos($error, 'Insufficient Balance') !== false) {
        $msg = "Insufficient balance";
    } else {
        $msg = "Transaction failed";
    }

    header("Location: ../pages/dashboard/bill_pay.php?msg=" . urlencode($msg));
    exit;
}

/* =========================
   ✅ SUCCESS
========================= */

header("Location: ../pages/dashboard/bill_success.php?bill=$bill_id");
exit;

?>