<?php
session_start();
if (!isset($_SESSION['AccNo'])) {
    header('Location: ../login.php?msg=Please login to continue');
    exit;
}

require('../../configs/db.php');
require('pp_check.php'); // PP Check
require('../../scripts/get_balance.php'); // $balance
require('../../scripts/get_interest.php'); // $interest
require('../../scripts/get_userinfo.php'); // $name, $fName
require('../../scripts/get_analytics.php'); // $totalDebit, $totalCredit
require('../../scripts/get_transactions.php'); // $trns

// Check if there is an GET message
$error = '';
if (isset($_GET['msg'])) {
    $error = $_GET['msg'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <title>Dashboard - Finova Bank </title>
    <link href="./css/index/mainMobile.css" rel="stylesheet">
    <link href="./css/index/table.css" media="(min-width: 600px)" rel="stylesheet">
    <link href="./css/index/desktop.css" media="(min-width: 900px)" rel="stylesheet">
    <link href="./css/profile/mainMobile.css" rel="stylesheet">
    <link href="./css/table/mainMobile.css" rel="stylesheet">
    <link href="./css/table/tablet.css" media="(min-width: 600px)" rel="stylesheet">
    <link href="./css/table/desktop.css" media="(min-width: 900px)" rel="stylesheet">
    <link rel="stylesheet" href="./css/all.min.css" />
    <link rel="stylesheet" href="./css/common.css" />

    
<style>

.income-card,
.dashboard-card{
border-radius:20px;
transition:all 0.3s ease;
cursor:pointer;
box-shadow:0 4px 12px rgba(0,0,0,0.1);
background:#fff;
}

.income-card:hover,
.dashboard-card:hover{
transform:translateY(-8px);
box-shadow:0 12px 25px rgba(0,0,0,0.2);
}

.card-body{
display:flex;
justify-content:space-between;
align-items:center;
}

.card-price{
font-size:24px;
font-weight:bold;
}

.income-title{
color:rgb(28,200,138);
font-weight:600;
}

.expense-title{
color:red;
font-weight:600;
}

.turnover-title{
color:rgb(78,115,223);
font-weight:600;
}

.ratio-title{
color:rgb(54,185,204);
font-weight:600;
}

.card-icon{
color:#d1d3e2;
}

.progress3{
width:120px;
height:8px;
background:#e9ecef;
border-radius:10px;
overflow:hidden;
margin-left:10px;
}

.progress-bar3{
height:100%;
background:#36b9cc;
border-radius:10px;
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

.section-title{
font-size:20px;
font-weight:600;
margin:25px 0 15px;
}

.service-section{
margin-top:20px;
}

.service-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(160px,1fr));
gap:20px;
}

.service-card{
background:#fff;
border-radius:15px;
padding:25px;
text-align:center;
text-decoration:none;
color:#333;
box-shadow:0 4px 12px rgba(0,0,0,0.1);
transition:all 0.3s ease;
}

.service-card i{
font-size:28px;
margin-bottom:10px;
color:#4e73df;
}

.service-card p{
font-size:15px;
font-weight:600;
}

.service-card:hover{
transform:translateY(-6px);
box-shadow:0 12px 25px rgba(0,0,0,0.2);
background:#f8f9ff;
}
.menu-btn{
background:none;
border:none;
font-size:20px;
margin-left:15px;
cursor:pointer;
color:#4e73df;
}

/* collapsed sidebar */

.sidebar{
width:220px;
transition:0.3s;
}

.sidebar.active{
margin-left:-220px;
}

/* content full width */

#wrapper.toggled .sidebar{
margin-left:-220px;
}

#wrapper.toggled #content-wrapper{
margin-left:0;
width:100%;
}
.navbar-top{
width:100%;
padding:10px 20px;
background:white;
box-shadow:0 2px 8px rgba(0,0,0,0.05);
}

.navbar-nav-ul{
list-style:none;
margin:0;
padding:0;
gap:20px;
}

.navbar-nav-ul li{
display:flex;
align-items:center;
}
.search-container{
position:relative;
}

.search-box{
display:none;
position:absolute;
top:40px;
right:0;
background:white;
width:230px;
padding:10px;
border-radius:8px;
box-shadow:0 4px 10px rgba(0,0,0,0.1);
z-index:999;
}

.search-box input{
width:100%;
padding:8px;
border:1px solid #ccc;
border-radius:5px;
outline:none;
}

#suggestions{
margin-top:5px;
}

.suggestion-item{
padding:6px;
cursor:pointer;
border-radius:4px;
}

.suggestion-item:hover{
background:#f1f1f1;
}
</style>
</head>

<body>
   

<div id="content-wrapper">
<!-- Navbar Top -->
<div class="navbar-top d-flex justify-content-between align-items-center" id="page-top">

<!-- Bank Logo + Name -->
<div class="d-flex align-items-center">
    <img src="../../assets/img/bank.png" alt="Bank Logo" width="35" height="35">
    <span style="font-size:18px;font-weight:600;margin-left:10px;">Finova Bank</span>
</div>

<ul class="navbar-nav-ul d-flex align-items-center">

<li class="nav-item search-container">

<a class="nav-link" href="#" onclick="toggleSearch(event)">
<i class="fas fa-search"></i>
</a>

<div id="searchBox" class="search-box">
<input type="text" id="searchInput" placeholder="Search services..." onkeyup="showSuggestions()">
<div id="suggestions"></div>
</div>

</li>

<li class="nav-item">
<a class="dropdown-toggle nav-link" href="#">
<i class="fas fa-bell fa-fw"></i>
</a>
</li>

<li class="nav-item">
<a class="dropdown-toggle nav-link" href="support.php">
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
<p>Bank Customer</p>

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
<h3>Welcome, <?php echo $fName ?></h3>
</div>

<!-- Quick Services -->

<div class="service-section">

<h4 class="section-title">Banking Services</h4>

<div class="service-grid">

<a href="transfer.php"  class="service-card">
<i class="fas fa-paper-plane"></i>
<p>Send Money</p>
</a>

<a href="direct_pay.php" class="service-card">
<i class="fas fa-qrcode"></i>
<p>Direct Pay</p>
</a>

<a href="bill_pay.php" class="service-card">
<i class="fas fa-file-invoice-dollar"></i>
<p>Bill Pay</p>
</a>

<a href="check_balance.php" class="service-card">
<i class="fas fa-wallet"></i>
<p>Check Balance</p>
</a>

<a href="transactions.php" class="service-card">
<i class="fas fa-history"></i>
<p>Transactions</p>
</a>

</div>

</div>


<!-- Loans Section -->

<div class="service-section">

<h4 class="section-title">Loans</h4>

<div class="service-grid">

<a href="education_loan.php" class="service-card">
<i class="fas fa-graduation-cap"></i>
<p>Education Loan</p>
</a>

<a href="home_loan.php" class="service-card">
<i class="fas fa-home"></i>
<p>Home Loan</p>
</a>

<a href="gold_loan.php" class="service-card">
<i class="fas fa-coins"></i>
<p>Gold Loan</p>
</a>

<a href="agriculture_loan.php" class="service-card">
<i class="fas fa-seedling"></i>
<p>Agriculture Loan</p>
</a>

<a href="car_loan.php" class="service-card">
<i class="fas fa-car"></i>
<p>Car Loan</p>
</a>

<a href="loan_calculator.php" class="service-card">
<i class="fas fa-calculator"></i>
<p>Loan Calculator</p>
</a>

</div>

</div>


<!-- Cards Section -->

<div class="service-section">

<h4 class="section-title">Cards</h4>

<div class="service-grid">

<a href="manage_debit.php" class="service-card">
<i class="fas fa-credit-card"></i>
<p>Manage Debit Card</p>
</a>

<a href="manage_credit.php" class="service-card">
<i class="fas fa-credit-card"></i>
<p>Manage Credit Card</p>
</a>

<a href="apply_debit.php" class="service-card">
<i class="fas fa-plus-circle"></i>
<p>Apply Debit Card</p>
</a>

<a href="apply_credit.php" class="service-card">
<i class="fas fa-plus-circle"></i>
<p>Apply Credit Card</p>
</a>

</div>

</div>

</div>
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

document.getElementById("sidebarToggle").addEventListener("click",function(){

document.getElementById("wrapper").classList.toggle("toggled");

});
function logoutUser(){

    if(confirm("Are you sure you want to logout?")){

        window.location.href = "/Bank-Management-System-in-Web/pages/home.php";

    }

}

function toggleSearch(e){
e.preventDefault();

let box = document.getElementById("searchBox");

if(box.style.display === "block"){
box.style.display = "none";
}else{
box.style.display = "block";
document.getElementById("searchInput").focus();
}
}

const services = [
{name:"Send Money", link:"transfer.php"},
{name:"Direct Pay", link:"direct_pay.php"},
{name:"Bill Pay", link:"bill_pay.php"},
{name:"Check Balance", link:"check_balance.php"},
{name:"Transactions", link:"transactions.php"},
{name:"Education Loan", link:"education_loan.php"},
{name:"Home Loan", link:"home_loan.php"},
{name:"Gold Loan", link:"gold_loan.php"},
{name:"Agriculture Loan", link:"agriculture_loan.php"},
{name:"Car Loan", link:"car_loan.php"},
{name:"Loan Calculator", link:"loan_calculator.php"},
{name:"Manage Debit Card", link:"manage_debit.php"},
{name:"Manage Credit Card", link:"manage_credit.php"},
{name:"Apply Debit Card", link:"apply_debit.php"},
{name:"Apply Credit Card", link:"apply_credit.php"}
];

function showSuggestions(){

let input = document.getElementById("searchInput").value.toLowerCase();
let suggestions = document.getElementById("suggestions");

suggestions.innerHTML="";

if(input === ""){
return;
}

services.forEach(function(service){

if(service.name.toLowerCase().includes(input)){

let div = document.createElement("div");
div.className="suggestion-item";
div.innerText = service.name;

div.onclick=function(){
window.location.href = service.link;
};

suggestions.appendChild(div);

}

});

}
</script>
</body>
</html>