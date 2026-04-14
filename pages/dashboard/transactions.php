<?php
session_start();
if (!isset($_SESSION['AccNo'])) {
    header('Location: ../login.php?msg=Please login to continue');
    exit;
}

require('../../configs/db.php');
require('pp_check.php');
require('../../scripts/get_userinfo.php');
require('../../scripts/get_transactions.php');

$accNo = $_SESSION['AccNo'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">

<title>Transactions - Finova Bank</title>

<link href="./css/index/mainMobile.css" rel="stylesheet">
<link href="./css/index/table.css" media="(min-width: 600px)" rel="stylesheet">
<link href="./css/index/desktop.css" media="(min-width: 900px)" rel="stylesheet">
<link href="./css/profile/mainMobile.css" rel="stylesheet">
<link href="./css/table/mainMobile.css" rel="stylesheet">
<link href="./css/table/tablet.css" media="(min-width: 600px)" rel="stylesheet">
<link href="./css/table/desktop.css" media="(min-width: 900px)" rel="stylesheet">
<link rel="stylesheet" href="./css/all.min.css">
<link rel="stylesheet" href="./css/common.css">

<style>
.statement-select{
padding:5px;
border-radius:5px;
margin-right:5px;
}
    /* PROFILE DROPDOWN */

.profile-dropdown{
position:relative;
display:flex;
align-items:center;
gap:10px;
}

.profile-img{
width:40px;
height:40px;
border-radius:50%;
cursor:pointer;
background-size:cover;
background-position:center;
border:2px solid #fff;
}

.profile-menu{
display:none;
position:absolute;
top:60px;
right:0;
width:240px;
background:white;
border-radius:12px;
box-shadow:0 8px 25px rgba(0,0,0,0.2);
padding:10px 0;
z-index:1000;
}

.profile-menu a{
display:block;
padding:12px 20px;
text-decoration:none;
color:#333;
font-size:14px;
}

.profile-menu a:hover{
background:#f5f5f5;
}

.profile-header{
text-align:center;
padding:15px;
}

.profile-pic{
width:60px;
height:60px;
border-radius:50%;
margin:auto;
background-size:cover;
background-position:center;
margin-bottom:10px;
}

.logout-btn{
color:red;
font-weight:600;
}
</style>

</head>

<body>



<div id="content-wrapper">

<!-- Navbar Top -->
<div class="navbar-top d-flex" id="page-top">

<div class="container-fluid d-flex"></div>

<ul class="navbar-nav-ul d-flex">

<li class="nav-item">
<a class="dropdown-toggle nav-link search-icon-nav" href="#">
<i class="fas fa-search"></i>
</a>
</li>

<li class="nav-item">
<a class="dropdown-toggle nav-link" href="#">
<i class="fas fa-bell fa-fw"></i>
</a>
</li>

<li class="nav-item">
<a class="dropdown-toggle nav-link" href="#">
<i class="fas fa-envelope fa-fw"></i>
</a>
</li>

<div class="topbar-divider"></div>

<!-- PROFILE DROPDOWN -->

<li class="nav-item avatar-n profile-dropdown">

<p>
<span class="avatar-text">
<?php echo $name ?>
</span>
</p>

<div class="avatar-nav profile-img"
onclick="toggleProfileMenu()"
style="background-image: url(<?php echo $pp ?>);">
</div>

<!-- Dropdown Menu -->

<div id="profileMenu" class="profile-menu">

<div class="profile-header">

<div class="profile-pic"
style="background-image: url(<?php echo $pp ?>);">
</div>

<h4><?php echo $name ?></h4>
<p>Finova Bank Customer</p>

</div>

<hr>

<a href="profile.php">
<i class="fas fa-user"></i> My Profile
</a>

<a href="settings.php">
<i class="fas fa-cog"></i> Settings
</a>

<hr>
<a class="logout-btn" href="#" onclick="logoutUser()">
<i class="fas fa-sign-out-alt"></i> Logout
</a>
</div>

</li>

</ul>

</div>


<div class="index-content container-main">

<div class="dashboard-header d-flex justify-between">

<h3>Bank Statement</h3>

<!-- NEW DOWNLOAD OPTIONS -->

<form action="../../scripts/statement_generator.php" method="GET">

<select name="range" class="statement-select">

<option value="all">All</option>
<option value="week">Last 1 Week</option>
<option value="month">Last 1 Month</option>

</select>

<button type="submit" class="generate-dash-btn">

<i class="fas fa-download fa-sm text-white-50"></i>
Download

</button>

</form>

</div>


<div class="overview-row row d-flex">

<div class="earnings">

<div class="earning-container row2-bgEdit">

<div class="earning-header d-flex justify-between">
<h6 class="earning-header-text">All Transactions</h6>
<button class="button-nobg">
<i class="fas fa-ellipsis-v"></i>
</button>
</div>


<div class="earning-body">

<div class="table-itself margin-column-form">

<table>

<thead>

<tr>
<th>Transaction Type</th>
<th>Description</th>
<th>Amount</th>
<th>Remarks</th>
<th>Transaction Date</th>
<th>Transaction Time</th>
</tr>

</thead>

<tbody>

<?php

foreach ($trns as $trn){

$date = date('d-m-Y', strtotime($trn['DateTime']));
$time = date('H:i:s', strtotime($trn['DateTime']));

$sender = $trn['Sender'];
$receiver = $trn['Receiver'];
$amount = $trn['Amount'];
$remarks = $trn['Remarks'];

/* CHECK IF BILL PAYMENT */

$isBill = strpos($remarks, 'Bill Payment') !== false;

if ($sender == $accNo){

$type = "Debit";

/* DESCRIPTION FIX */
if($isBill){
    $description = $remarks; // Bill Payment - Mobile
}else{
    $description = "Transfer to $receiver";
}

}else{

$type = "Credit";

if($isBill){
    $description = $remarks;
}else{
    $description = "Transfer from $sender";
}

}

/* COLOR STYLE */
$amountClass = ($type == "Debit") ? "style='color:red;font-weight:600'" : "style='color:green;font-weight:600'";

echo "<tr>
<td>$type</td>
<td>$description</td>
<td $amountClass>Rs. $amount</td>
<td>$remarks</td>
<td>$date</td>
<td>$time</td>
</tr>";

}

?>

</tbody>

</table>

</div>
</div>
</div>
</div>
</div>

</div>
</div>

</body>

<script>

function toggleProfileMenu() {

var menu = document.getElementById("profileMenu");

if(menu.style.display === "block"){
menu.style.display = "none";
}else{
menu.style.display = "block";
}

}

window.onclick = function(event) {

if(!event.target.closest('.profile-dropdown')){

var menu = document.getElementById("profileMenu");

if(menu){
menu.style.display = "none";
}

}

}
function logoutUser(){

    if(confirm("Are you sure you want to logout?")){

        window.location.href = "/Bank-Management-System-in-Web/pages/home.php";

    }

}
</script>
</html>