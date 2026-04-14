<?php
session_start();
if (!isset($_SESSION['AccNo'])) {
    header('Location: ../login.php?msg=Please login to continue');
    exit;
}

require('../../configs/db.php');
require('pp_check.php'); // PP Check
require('../../scripts/get_userinfo.php'); // $fName


// Check if there is an GET message
$error = '';
if (isset($_GET['msg'])) {
    $error = $_GET['msg'];
}

$accNo = $_SESSION['AccNo'];
$sql = "SELECT Balance FROM balance WHERE AccNo = '$accNo'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
$balance = $data['Balance'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <title>Transfer Online - Finova Bank </title>
    <link href="./css/index/mainMobile.css" rel="stylesheet">
    <link href="./css/index/table.css" media="(min-width: 600px)" rel="stylesheet">
    <link href="./css/index/desktop.css" media="(min-width: 900px)" rel="stylesheet">
    <link href="./css/profile/mainMobile.css" rel="stylesheet">
    <link href="./css/table/mainMobile.css" rel="stylesheet">
    <link href="./css/table/tablet.css" media="(min-width: 600px)" rel="stylesheet">
    <link href="./css/table/desktop.css" media="(min-width: 900px)" rel="stylesheet">
    <link rel="stylesheet" href="./css/all.min.css" />
    <link rel="stylesheet" href="./css/common.css" />
    <link rel="stylesheet" href="./css/newmew.css" />

    <style>
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
.transfer-form{
margin-top:10px;
}

.transfer-form input{
border-radius:8px;
padding:10px;
transition:0.3s;
}

.transfer-form input:focus{
border:1px solid #4e73df;
box-shadow:0 0 5px rgba(78,115,223,0.5);
}

.transfer-btn{
background:#4e73df;
color:white;
padding:10px 20px;
border:none;
border-radius:8px;
font-size:15px;
cursor:pointer;
}

.transfer-btn:hover{
background:#2e59d9;
}
</style>
</head>

<body class="transfer">
    
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
            <!--!Index's Main contents start here-->
            <div class="index-content container-main">
                <div class="dashboard-header  d-flex justify-between">
                    <!--!Dashboard header-->
                    <h3>Transfer Funds
                    </h3>
                </div>

                <!--First Rows-->
                <div class="overview-row row d-flex">

                    <!--Transfer-->
                    <div class="revenue">
                        <div class="revenue-container row2-bgEdit">
                            <!--head of transfer chart-->
                            <div class="revenue-header d-flex justify-between">
                                <h6 class="revenue-header-text">Send Money</h6>
                                <button class="button-nobg" type="button"><i class="fas fa-ellipsis-v "></i></button>
                            </div>
                            <!--body of transfer chart-->
                            <div class="user-setting-body project-body">
 <form action="../../scripts/bal_transfer.php" method="POST" class="transfer-form">

<!-- Receiver Account Number -->
<div class="form-row d-flex justify-between">
<div class="form-row-col d-flex flex-direction-column">

<label class="form-label"><strong>Receiver Account Number</strong></label>

<input 
class="form-control-prof" 
type="text" 
name="receiver_accNo" 
id="receiver_accNo" 
onblur="getReceiverName()" 
required>

<p id="receiverName" style="margin-top:5px;font-weight:600;"></p>

</div>
</div>

<!-- Receiver Bank Name -->
<div class="form-row d-flex justify-between">
<div class="form-row-col d-flex flex-direction-column">

<label class="form-label"><strong>Receiver Bank Name</strong></label>

<input  
class="form-control-prof"
type="text" 
name="receiver_bank"
required>

</div>
</div>

<!-- IFSC Code -->
<div class="form-row d-flex justify-between">
<div class="form-row-col d-flex flex-direction-column">

<label class="form-label"><strong>IFSC Code</strong></label>

<input 
class="form-control-prof" 
type="text" 
name="ifsc" 
placeholder="Example: FINO00012" 
required>

</div>
</div>

<!-- Amount -->
<div class="form-row d-flex justify-between">
<div class="form-row-col d-flex flex-direction-column">

<label class="form-label"><strong>Amount</strong></label>

<input 
class="form-control-prof" 
type="number" 
name="amount" 
required>

</div>
</div>

<!-- Remarks -->
<div class="form-row d-flex justify-between">
<div class="form-row-col d-flex flex-direction-column">

<label class="form-label"><strong>Remarks / Notes</strong></label>

<input 
class="form-control-prof" 
type="text" 
name="remarks" 
placeholder="Optional note">

</div>
</div>

<!-- UPI PIN -->
<div class="form-row d-flex justify-between">
<div class="form-row-col d-flex flex-direction-column">

<label class="form-label"><strong>Enter UPI PIN</strong></label>

<input 
class="form-control-prof" 
type="password" 
name="upi_pin" 
required>

</div>
</div>

<!-- Error Message -->
<small id="error-code" class="error-font" style="color:red;">
<?php echo $error ?>
</small>

<!-- Transfer Button -->
<div class="form-row">
<div class="form-row-button text-center">

<button class="button-profile transfer-btn" name="submit" type="submit">
<i class="fas fa-paper-plane"></i> Transfer Money
</button>

</div>
</div>

</form>
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

menu.style.display = (menu.style.display === "block") ? "none" : "block";

}

window.onclick = function(event) {

if(!event.target.closest('.profile-dropdown')){

var menu = document.getElementById("profileMenu");

if(menu){
menu.style.display = "none";
}

}

}

/* -----------------------------
   FIXED RECEIVER FUNCTION
--------------------------------*/

function getReceiverName(){

var accNo = document.getElementById("receiver_accNo").value;

/* Only run for full 12 digits */
if(accNo.length != 12){
document.getElementById("receiverName").innerHTML="";
return;
}

var xhr = new XMLHttpRequest();

xhr.open("POST","../../scripts/get_receiver.php",true);

xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

xhr.onload = function(){

if(this.responseText.trim() == "notfound"){

document.getElementById("receiverName").innerHTML =
"<span style='color:red'>Receiver not found</span>";

}else{

document.getElementById("receiverName").innerHTML =
"<span style='color:green'>Receiver: " + this.responseText + "</span>";

}

};

xhr.send("accNo=" + accNo);

}

function logoutUser(){

if(confirm("Are you sure you want to logout?")){
window.location.href = "/Bank-Management-System-in-Web/pages/home.php";
}

}

</script>
</html>