<?php
session_start();
require('../configs/db.php');

$accNo = $_SESSION['AccNo'];

$online_enabled = isset($_POST['online_enabled']) ? 1 : 0;
$atm_enabled    = isset($_POST['atm_enabled']) ? 1 : 0;

$online_limit = $_POST['online_limit'];
$atm_limit    = $_POST['atm_limit'];

/* INSERT OR UPDATE */
mysqli_query($conn,"
INSERT INTO card_settings (AccNo, online_enabled, atm_enabled, online_limit, atm_limit)
VALUES ('$accNo','$online_enabled','$atm_enabled','$online_limit','$atm_limit')
ON DUPLICATE KEY UPDATE
online_enabled='$online_enabled',
atm_enabled='$atm_enabled',
online_limit='$online_limit',
atm_limit='$atm_limit'
");

header("Location: ../pages/dashboard/card_usage.php?msg=Saved");
exit;
?>