<?php
session_start();
require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];

/* GET SETTINGS */
$res = mysqli_query($conn,"SELECT * FROM card_settings WHERE AccNo='$accNo'");
$data = mysqli_fetch_assoc($res);

/* IF NOT EXISTS → CREATE DEFAULT */
if(!$data){

mysqli_query($conn,"
INSERT INTO card_settings 
(AccNo, online_enabled, atm_enabled, pos_enabled, online_limit, atm_limit, pos_limit)
VALUES 
('$accNo',1,1,1,200000,75000,200000)
");

$res = mysqli_query($conn,"SELECT * FROM card_settings WHERE AccNo='$accNo'");
$data = mysqli_fetch_assoc($res);
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Domestic Usage</title>

<style>

body{
font-family:'Segoe UI';
background:#f5f6fa;
margin:0;
}

.container{
width:420px;
margin:20px auto;
}

.header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:15px;
}

.box{
background:white;
padding:15px;
border-radius:12px;
margin-bottom:15px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

label{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:10px;
}

/* SLIDER */
input[type=range]{
width:100%;
}

/* BUTTON */
button{
width:100%;
padding:14px;
background:linear-gradient(135deg,#4e73df,#224abe);
color:white;
border:none;
border-radius:10px;
font-weight:600;
cursor:pointer;
}

.limit{
font-weight:bold;
margin:5px 0;
}

</style>

</head>

<body>

<div class="container">

<div class="header">
<h3>Domestic Usage</h3>
</div>

<form action="../../scripts/update_card_usage.php" method="POST">

<!-- ONLINE -->
<div class="box">

<label>
Online (E-com)
<input type="checkbox" name="online_enabled"
<?= ($data['online_enabled'] ?? 1) ? 'checked' : '' ?>>
</label>

<p class="limit">₹ <span id="limit1"><?= $data['online_limit'] ?? 200000 ?></span></p>

<input type="range" 
name="online_limit"
min="1" max="200000"
value="<?= $data['online_limit'] ?? 200000 ?>"
oninput="limit1.innerText=this.value">

<p style="font-size:12px;color:#777;">
Min ₹1 — Max ₹2,00,000
</p>

</div>

<!-- ATM -->
<div class="box">

<label>
Cash Withdrawal
<input type="checkbox" name="atm_enabled"
<?= ($data['atm_enabled'] ?? 1) ? 'checked' : '' ?>>
</label>

<p class="limit">₹ <span id="limit2"><?= $data['atm_limit'] ?? 75000 ?></span></p>

<input type="range" 
name="atm_limit"
min="100" max="75000"
value="<?= $data['atm_limit'] ?? 75000 ?>"
oninput="limit2.innerText=this.value">

<p style="font-size:12px;color:#777;">
Min ₹100 — Max ₹75,000
</p>

</div>

<!-- POS -->
<div class="box">

<label>
POS (Swipe Machine)
<input type="checkbox" name="pos_enabled"
<?= ($data['pos_enabled'] ?? 1) ? 'checked' : '' ?>>
</label>

<p class="limit">₹ <span id="limit3"><?= $data['pos_limit'] ?? 200000 ?></span></p>

<input type="range" 
name="pos_limit"
min="1" max="200000"
value="<?= $data['pos_limit'] ?? 200000 ?>"
oninput="limit3.innerText=this.value">

<p style="font-size:12px;color:#777;">
Min ₹1 — Max ₹2,00,000
</p>

</div>

<button type="submit">Save Settings</button>

</form>

</div>

</body>
</html>