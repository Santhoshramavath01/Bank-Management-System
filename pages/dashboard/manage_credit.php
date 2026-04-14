<?php
session_start();
require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];

$res = mysqli_query($conn,"SELECT * FROM credit_cards WHERE AccNo='$accNo'");
$row = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Credit Card</title>

<style>
body{font-family:'Segoe UI';background:#eef2ff;}

.container{
width:420px;margin:30px auto;background:white;
padding:20px;border-radius:15px;
}

.card{
background:linear-gradient(135deg,#8e44ad,#5e3370);
color:white;padding:20px;border-radius:15px;
margin-bottom:20px;
}

button{
padding:10px 15px;
background:red;color:white;border:none;border-radius:8px;
}

.option{
background:#f4f6fb;
padding:12px;
margin-top:10px;
border-radius:10px;
cursor:pointer;
}
</style>
</head>

<body>

<div class="container">

<h3>💳 Your Credit Card</h3>

<?php if($row){ ?>

<div class="card">
<p>**** **** **** <?= substr($row['CardNumber'],-4) ?></p>
<p>Limit: ₹<?= $row['CreditLimit'] ?></p>
<p>Used: ₹<?= $row['UsedLimit'] ?></p>
<p>Status: <?= $row['Status'] ?></p>
</div>

<button onclick="block()">Block Card</button>

<div class="option">📊 View Statement</div>
<div class="option">💰 Pay Bill</div>

<?php } else { ?>
<p>No Credit Card Found</p>
<?php } ?>

</div>

<script>
function block(){
if(confirm("Block card?")){
window.location.href="../../scripts/block_credit.php";
}
}
</script>

</body>
</html>