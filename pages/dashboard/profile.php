<?php
session_start();
if (!isset($_SESSION['AccNo'])) {
    header('Location: ../login.php?msg=Please login to continue');
    exit;
}

require('../../configs/db.php');
require('../../scripts/get_userinfo.php'); // $All user info
require('pp_check.php'); // PP Check
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <title>Profile - Finova Bank </title>
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
/* Profile Account Info Styling */

.user-setting-body p{
margin-bottom:15px;
font-size:15px;
}

.user-setting-body strong{
color:#4e73df;
font-weight:600;
}

.user-setting-body span{
display:block;
margin-top:5px;
font-size:14px;
color:#333;
}

.upi-box{
background:#f4f6ff;
padding:8px 12px;
border-radius:6px;
font-weight:600;
color:#4e73df;
display:inline-block;
}

.mobile-box{
font-weight:500;
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
            <!--!Index's Main contents start here-->
            <div class="index-content container-main">
                <div class="dashboard-header  d-flex justify-between">
                    <!--!Dashboard header-->
                    <h3>
                        Your Profile
                    </h3>
                    <a href="settings.php" class="generate-dash-btn"><i class="fas fa-edit fa-sm text-white-50"></i>Edit
                        Profile</a>
                </div>

                <div class="overview-row row d-flex">
                    <!--Profile Info-->
                    <div class="earnings profile">
                        <div class="col-profile prof-col1 margin-row-prof shadow-edit">
                            <div class="prof-body pr-body2">
                                <img src="<?php echo $pp ?>" alt="Profile Picture">
                                <div>
                                    <p class="form-label text-center">
                                        <span>
                                            <?php echo $accNo ?>
                                        </span> <br>
                                        <span>Saving Account</span> <br>
                                        <span>Finova Bank Ltd</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Account Info-->
                    <div class="revenue profileInfo">
                        <div class="revenue-container row2-bgEdit">
                            <!--head of transfer chart-->
                            <div class="revenue-header d-flex justify-between">
                                <h6 class="revenue-header-text">Account Info</h6>
                                <button class="button-nobg" type="button"><i class="fas fa-ellipsis-v "></i></button>
                            </div>
                            <!--body of transfer chart-->
                            <div class="user-setting-body project-body">
                                <p class="form-label" for="receiver_accNo"><strong>Account Number:</strong> <br>
                                    <span class="form-label">
                                        <?php echo $accNo ?>
                                    </span>
                                </p>
                                <p class="form-label" for="receiver_accNo"><strong>Account Type:</strong> <br>
                                    <span class="form-label">Saving</span>
                                </p>
                                <p class="form-label" for="receiver_accNo"><strong>Full Name:</strong> <br>
                                    <span class="form-label">
                                        <?php echo $name ?>
                                    </span>
                                </p>
                                </p>
                                <p class="form-label" for="receiver_accNo"><strong>Address:</strong> <br>
                                    <span class="form-label">
                                        <?php echo $address ?>
                                    </span>
                                </p>
                                </p>
                                <p class="form-label" for="receiver_accNo"><strong>Email:</strong> <br>
                                    <span class="form-label">
                                        <?php echo $email ?>
                                    </span>
                                </p>
                                </p>
                                <p class="form-label"><strong>Mobile Number:</strong> <br>
<span class="mobile-box">
<?php echo $mobile ?>
</span>
</p>
<p class="form-label"><strong>UPI ID:</strong> <br>
<span class="upi-box">
<?php echo $upi ?>
</span>
</p>

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