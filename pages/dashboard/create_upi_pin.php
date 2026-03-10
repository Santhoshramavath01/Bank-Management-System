<?php
session_start();
require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];
$msg="";

if(isset($_POST['create_pin'])){

$pin = $_POST['pin'];
$confirm = $_POST['confirm_pin'];
$length = $_POST['pin_length'];

if(strlen($pin) != $length){
$msg = "PIN must be $length digits";
}
else if($pin != $confirm){
$msg = "PIN does not match";
}
else{

$hash = password_hash($pin,PASSWORD_DEFAULT);

$sql = "UPDATE userinfo
SET upi_pin='$hash', upi_pin_length='$length'
WHERE AccNo='$accNo'";

mysqli_query($conn,$sql);

$msg="UPI PIN created successfully";

}

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Create UPI PIN</title>

<link rel="stylesheet" href="./css/common.css">

<style>

.pin-container{
width:420px;
margin:80px auto;
background:white;
padding:35px;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
text-align:center;
}

.pin-title{
font-size:22px;
margin-bottom:20px;
font-weight:600;
color:#4e73df;
}

.pin-container input,
.pin-container select{
width:100%;
padding:10px;
margin-top:8px;
margin-bottom:18px;
border-radius:6px;
border:1px solid #ccc;
}

.pin-btn{
background:#4e73df;
color:white;
padding:10px 25px;
border:none;
border-radius:6px;
cursor:pointer;
}

.pin-btn:hover{
background:#2e59d9;
}

.pin-msg{
margin-top:15px;
color:red;
}

</style>

</head>

<body>

<div class="pin-container">

<div class="pin-title">Create UPI PIN</div>

<form method="POST">

<label>Select PIN Length</label>

<select name="pin_length">
<option value="4">4 Digit PIN</option>
<option value="6">6 Digit PIN</option>
</select>

<label>Enter PIN</label>
<input type="password" name="pin" required>

<label>Confirm PIN</label>
<input type="password" name="confirm_pin" required>

<button class="pin-btn" name="create_pin">Create PIN</button>

<div class="pin-msg">
<?php echo $msg ?>
</div>

</form>

</div>

</body>

</html>