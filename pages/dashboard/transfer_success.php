<?php
session_start();
require('../../configs/db.php');

$txn = $_GET['txn'];

$sql = "SELECT * FROM transactions WHERE TxnID='$txn'";
$res = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>

<head>

<title>Payment Successful</title>

<style>
.success-box{
width:420px;
margin:100px auto;
background:white;
padding:40px;
text-align:center;
border-radius:12px;
box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.success-icon{
font-size:50px;
color:green;
margin-bottom:15px;
}

.txn-id{
font-size:18px;
font-weight:bold;
color:#4e73df;
margin:15px 0;
}

.btn-back{
display:inline-block;
background:#4e73df;
color:white;
padding:10px 25px;
border-radius:6px;
text-decoration:none;
margin-top:10px;
}

.btn-back:hover{
background:#2e59d9;
}
</style>

</head>

<body>

<div class="success-box">

<div class="success-icon">✔</div>

<h2>Payment Successful</h2>

<p>Amount: ₹ <?php echo $data['Amount']; ?></p>

<p>Transaction ID:</p>

<div class="txn-id">
<?php echo $txn; ?>
</div>

<br>


</div>

</body>

</html>