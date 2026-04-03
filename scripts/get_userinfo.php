<?php

$accNo = $_SESSION['AccNo'];

$sql = "SELECT * FROM userinfo WHERE AccNo='$accNo'";
$result = mysqli_query($conn,$sql);

$row = mysqli_fetch_assoc($result);

if($row){

$name = $row['Name'];
$address = $row['Address'];
$email = $row['Email'];
$mobile = $row['Mobile'];
$upi = $row['UPI'];

$fName = explode(" ", $name)[0]; // first name

}else{

$name = "";
$address = "";
$email = "";
$mobile = "";
$upi = "";
$fName = "";

}

?>