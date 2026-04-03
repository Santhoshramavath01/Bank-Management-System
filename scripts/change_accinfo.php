<?php
session_start();

if (!isset($_SESSION['AccNo'])) {
    header('Location: ../pages/login.php');
    exit;
}

require('../configs/db.php');

$accNo = $_SESSION['AccNo'];

$name = $_POST['name'];
$email = $_POST['email'];
$address = $_POST['address'];

$sql = "UPDATE userinfo 
        SET Name='$name', Email='$email', Address='$address'
        WHERE AccNo='$accNo'";

$result = mysqli_query($conn,$sql);

if($result){
header("Location: ../pages/dashboard/profile.php?msg=Profile Updated");
}else{
header("Location: ../pages/dashboard/settings.php?msg=Update Failed");
}

?>