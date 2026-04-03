<?php
session_start();
if (!isset($_SESSION['AccNo'])) {
  header('Location: ../login.php?msg=Please login to continue');
  exit;
}

require('../../configs/db.php');
require('pp_check.php'); // PP Check
require('../../scripts/get_balance.php'); // $balance
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

<a class="logout-btn" href="logout.php">
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
          <h3>Analytics
          </h3>
        </div>
        <!--!Indo cards-->
        <div class="income-inf-row row">
          <!-- Income Card -->
<div class="col-income">
  <div class="card income-card">

    <div class="card-body">

      <div class="card-text">

        <div class="card-span">
          <span class="income-title">Income</span>
        </div>

        <div class="card-price">
          <span>Rs. <?php echo $totalCredit ?></span>
        </div>

      </div>

      <div class="card-icon">
        <i class="fas fa-dollar-sign fa-2x"></i>
      </div>
    </div>

  </div>
</div>
<!-- Card 2 : Expense -->
<div class="col-income">
  <div class="card dashboard-card expense-card">
    <div class="card-body">
      <div class="card-text">
        <div class="card-span"><span class="expense-title">Expense</span></div>
        <div class="card-price"><span>Rs. <?php echo $totalDebit ?></span></div>
      </div>
      <div class="card-icon">
        <i class="fas fa-percent fa-2x"></i>
      </div>
    </div>
  </div>
</div>

<!-- Card 3 : Turnover -->
<div class="col-income">
  <div class="card dashboard-card turnover-card">
    <div class="card-body">
      <div class="card-text">
        <div class="card-span"><span class="turnover-title">Turnover</span></div>
        <div class="card-price">
          <span>Rs. <?php echo $totalCredit + $totalDebit ?></span>
        </div>
      </div>
      <div class="card-icon">
        <i class="fas fa-money-bill fa-2x"></i>
      </div>
    </div>
  </div>
</div>

<!-- Card 4 : I/E Ratio -->
<div class="col-income">
  <div class="card dashboard-card ratio-card">
    <div class="card-body">
      <div class="card-text">
        <div class="card-span">
          <span class="ratio-title">I/E Ratio</span>
        </div>

        <div class="card-price d-flex align-items-center">

          <?php
          if ($totalDebit != 0) {
            $incomeToOutcomeRatio = ($totalCredit / $totalDebit) * 100;
            echo '<span>' . number_format($incomeToOutcomeRatio, 1) . '%</span>';
          } else {
            $incomeToOutcomeRatio = 100;
            echo '<span>Infinity</span>';
          }
          ?>

          <div class="progress3 ms-2">
            <div style="width: <?php echo min(100,$incomeToOutcomeRatio); ?>%;" class="progress-bar3"></div>
          </div>

        </div>

      </div>

      <div class="card-icon">
        <i class="fas fa-exchange-alt fa-2x"></i>
      </div>

    </div>
  </div>
</div>

          <!--First Rows-->
          <div class="overview-row row d-flex">
            <!--Recent Transactions-->
            <div class="earnings ">
              <div class="earning-container row2-bgEdit">
                <!--head of Transactions chart-->
                <div class="earning-header d-flex justify-between">
                  <h6 class="earning-header-text">Balance Overview</h6>
                  <button class="button-nobg" type="button"><i class="fas fa-ellipsis-v "></i></button>
                </div>
                <!--body of Transactions chart-->
                <div class="line_chart">
                  <canvas id="line_chart"></canvas>
                </div>
              </div>
            </div>
            <!--Transfer-->
            <div class="revenue">
              <div class="revenue-container row2-bgEdit">
                <!--head of transfer chart-->
                <div class="revenue-header d-flex justify-between">
                  <h6 class="revenue-header-text">Cashflow</h6>
                  <button class="button-nobg" type="button"><i class="fas fa-ellipsis-v "></i></button>
                </div>
                <!--body of transfer chart-->
                <div class="doughnut_chart">
                  <canvas id="doughnut_chart"></canvas>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./js/doughnut_chart.js"></script>
    <script src="./js/line_chart.js"></script>
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

</script>
</html>