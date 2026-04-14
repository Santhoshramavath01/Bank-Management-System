<?php
session_start();
require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];
$res = mysqli_query($conn,"SELECT * FROM debit_cards WHERE AccNo='$accNo'");
$row = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
<title>Card Summary</title>

<style>
body{font-family:'Segoe UI';background:#f5f6fa;}

.container{
width:420px;margin:20px auto;background:white;
padding:20px;border-radius:12px;
}

.card{
background:linear-gradient(135deg,#1fa463,#0d6b3c);
color:white;padding:15px;border-radius:12px;
margin-bottom:15px;
}
</style>
</head>

<body>

<div class="container">

<div class="card">
<p><?php echo "**** **** **** ".substr($row['CardNumber'], -4); ?></p>
<p><?php echo $row['CardHolder']; ?></p>
</div>

<p><b>Status:</b> Active</p>
<p><b>ATM Limit:</b> ₹75,000</p>
<p><b>Purchase Limit:</b> ₹2,00,000</p>
<p><b>Account No:</b> <?php echo $accNo; ?></p>

</div>

</body>
</html>