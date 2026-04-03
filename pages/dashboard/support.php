<?php
session_start();
if (!isset($_SESSION['AccNo'])) {
    header('Location: ../login.php?msg=Please login to continue');
    exit;
}
require('../../configs/db.php');
require('pp_check.php'); // PP Check
require('../../scripts/get_userinfo.php'); // $name

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
    <title>Support - Finova Bank </title>
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

            <!--!Index's Main contents start here-->
            <div class="index-content container-main">
                <div class="dashboard-header  d-flex justify-between">
                    <!--!Dashboard header-->
                    <h3>
                        Support
                    </h3>
                </div>



                <div class="overview-row row d-flex">

                    <!--Contact Form-->

                    <div class="form-set-row">
                        <div class="form-padding-row">
                            <div class="from-setting-container shadow-edit">
                                <!--Header-->
                                <div class="project-head earning-header d-flex justify-between">
                                    <h6 class="earning-header-text">Contact Form</h6>
                                </div>
                                <!--body-->
                                <div class="user-setting-body project-body">
                                    <form action="../../scripts/send_email.php" method="POST">
                                        <!--row1-->
                                        <div style="margin-bottom: 0px;"
                                            class="form-row form-row-col2 d-flex justify-between">
                                            <div
                                                class="form-row-textarea d-flex flex-direction-column margin-column-form">
                                                <label class="form-label" for="signature"><strong>Share any
                                                        issues, feedback, or thoughts about your banking
                                                        experience.</strong></label>
                                                <textarea class="form-control-prof" name="signature" id="signature"
                                                    cols="30" rows="10"></textarea>
                                                <br>
                                                <small style="text-align: left; margin-bottom: 0px;" id="error-code"
                                                    class="error-font">
                                                    <?php echo $error ?>
                                                </small>
                                            </div>
                                        </div>
                                        <!--row2-->
                                        <div class="form-row margin-row-prof d-flex justify-between">
                                            <div class="switch form-row-col d-flex ">
                                                <input id="switch-1" type="checkbox" class="switch-input" />
                                                <label for="switch-1" class="switch-label">Notify me about reply</label>
                                                <label for="switch-1" class="switch-label2">Notify me about
                                                    reply</label>
                                            </div>
                                        </div>
                                        <!--row3-->
                                        <div class="form-row">
                                            <div class="form-row-button">
                                                <button class="button-profile" type="submit" name="send"
                                                    id="send">Send</button>
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