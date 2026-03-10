<?php
session_start();

if (!isset($_SESSION['AccNo'])) {
header("Location: ../login.php?msg=Please login");
exit;
}

require('../../configs/db.php');
require('../../scripts/get_userinfo.php');
require('pp_check.php');

?>

<!DOCTYPE html>
<html>

<head>

<title>Direct Pay - Finova Bank</title>

<link rel="stylesheet" href="./css/common.css">
<link rel="stylesheet" href="./css/all.min.css">

<style>

body{
background:#f4f6fb;
font-family:Arial;
}

.direct-container{
max-width:450px;
margin:80px auto;
background:white;
padding:35px;
border-radius:15px;
box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.direct-title{
font-size:22px;
font-weight:600;
margin-bottom:25px;
color:#4e73df;
text-align:center;
}

.direct-input{
width:100%;
padding:12px;
border-radius:8px;
border:1px solid #ccc;
margin-bottom:15px;
font-size:14px;
}

.direct-input:focus{
border-color:#4e73df;
outline:none;
}

.receiver-name{
color:green;
font-weight:600;
margin-bottom:10px;
}

.pay-btn{
width:100%;
background:#4e73df;
color:white;
border:none;
padding:12px;
border-radius:8px;
font-size:15px;
cursor:pointer;
}

.pay-btn:hover{
background:#2e59d9;
}

.error{
color:red;
text-align:center;
margin-bottom:10px;
}

</style>

</head>

<body>

<div class="direct-container">

<div class="direct-title">
<i class="fas fa-bolt"></i> Direct Pay
</div>

<?php
if(isset($_GET['msg'])){
echo "<p class='error'>".$_GET['msg']."</p>";
}
?>

<form action="../../scripts/direct_pay_process.php" method="POST">

<label>UPI ID</label>

<input 
type="text"
name="upi_id"
id="upi_id"
class="direct-input"
placeholder="example@finova"
onkeyup="getReceiver()"
required>

<p id="receiver" class="receiver-name"></p>

<label>Amount</label>

<input
type="number"
name="amount"
class="direct-input"
placeholder="Enter amount"
required>

<label>Note</label>

<input
type="text"
name="remarks"
class="direct-input"
placeholder="Optional note">

<label>Enter UPI PIN</label>

<input
type="password"
name="upi_pin"
class="direct-input"
placeholder="UPI PIN"
required>

<button class="pay-btn" type="submit">
<i class="fas fa-paper-plane"></i> Pay Now
</button>

</form>

</div>

<script>

function getReceiver(){

var upi = document.getElementById("upi_id").value;

if(upi.length < 3){
document.getElementById("receiver").innerHTML="";
return;
}

var xhr = new XMLHttpRequest();

xhr.open("POST","../../scripts/get_upi_receiver.php",true);

xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

xhr.onload=function(){

if(this.responseText=="notfound"){

document.getElementById("receiver").innerHTML =
"<span style='color:red'>UPI ID not found</span>";

}else{

document.getElementById("receiver").innerHTML =
"Receiver: "+this.responseText;

}

};

xhr.send("upi="+upi);

}

</script>

</body>

</html>