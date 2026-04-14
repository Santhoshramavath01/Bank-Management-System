<?php
session_start();
require('../configs/db.php');

$accNo = $_SESSION['AccNo'];

$type = $_POST['card_type'];
$limit = $_POST['limit'];
$income = $_POST['income'];

/* GENERATE CARD */
$card = "4532" . rand(100000000000,999999999999);
$cvv = rand(100,999);
$expiry = date("Y-m-d", strtotime("+5 years"));

mysqli_query($conn,"
INSERT INTO credit_cards 
(AccNo, CardNumber, CardType, CreditLimit, UsedLimit, CVV, Expiry, Status)
VALUES
('$accNo','$card','$type','$limit',0,'$cvv','$expiry','ACTIVE')
");

header("Location: ../pages/dashboard/manage_credit.php");
exit;
?>