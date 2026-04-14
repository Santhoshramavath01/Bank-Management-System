<?php

session_start();

if (!isset($_SESSION['AccNo'])) {
    header("Location: ../pages/login.php");
    exit;
}

require('../configs/db.php');

$accNo  = $_SESSION['AccNo'];
$type   = $_POST['loan_type'] ?? '';
$amount = $_POST['amount'] ?? '';
$tenure = $_POST['tenure'] ?? '';
$income = $_POST['income'] ?? '';

/* -----------------------------
   VALIDATION
--------------------------------*/

if (empty($type) || empty($amount) || empty($tenure) || empty($income)) {
    header("Location: ../pages/dashboard/loans.php?msg=All fields required");
    exit;
}

if (!is_numeric($amount) || $amount <= 0) {
    header("Location: ../pages/dashboard/loans.php?msg=Invalid amount");
    exit;
}

/* -----------------------------
   GENERATE LOAN ID
--------------------------------*/

$loan_id = "LOAN" . date("YmdHis") . rand(100,999);

/* -----------------------------
   SIMPLE ELIGIBILITY CHECK
--------------------------------*/

$status = "PENDING";

/* Example rule */
if ($income >= 20000 && $amount <= ($income * 20)) {
    $status = "APPROVED";
} else {
    $status = "PENDING";
}

/* -----------------------------
   INSERT INTO DATABASE
--------------------------------*/

$stmt = mysqli_prepare($conn,
"INSERT INTO loans (LoanID, AccNo, LoanType, Amount, Tenure, Income, Status)
VALUES (?, ?, ?, ?, ?, ?, ?)");

mysqli_stmt_bind_param($stmt, "sisiiis",
$loan_id, $accNo, $type, $amount, $tenure, $income, $status);

if (!mysqli_stmt_execute($stmt)) {
    header("Location: ../pages/dashboard/loans.php?msg=Loan application failed");
    exit;
}

/* -----------------------------
   SUCCESS
--------------------------------*/

header("Location: ../pages/dashboard/loan_status.php?msg=Application submitted");
exit;

?>