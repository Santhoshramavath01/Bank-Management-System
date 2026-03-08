<?php
session_start();
require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];

mysqli_query($conn,"DELETE FROM userinfo WHERE AccNo='$accNo'");
mysqli_query($conn,"DELETE FROM credentials WHERE AccNo='$accNo'");
mysqli_query($conn,"DELETE FROM balance WHERE AccNo='$accNo'");

session_destroy();

header("Location: ../../login.php");
?>