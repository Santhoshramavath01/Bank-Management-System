<?php
session_start();
if (!isset($_SESSION['AccNo'])) {
    header('Location: ../login.php?msg=Please login to continue');
    exit;
}

require('../../configs/db.php');
require('../../scripts/get_userinfo.php'); // All user info
require('pp_check.php'); // PP Check

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
    <title>Settings - Finova Bank </title>
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
.settings-container{
margin-top:20px;
}

.settings-title{
font-size:22px;
margin-bottom:20px;
font-weight:600;
}

.settings-grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:20px;
}

.settings-card{
background:#fff;
padding:25px;
border-radius:12px;
text-align:center;
text-decoration:none;
color:#333;
box-shadow:0 4px 12px rgba(0,0,0,0.1);
transition:0.3s;
}

.settings-card i{
font-size:28px;
margin-bottom:10px;
color:#4e73df;
}

.settings-card:hover{
transform:translateY(-6px);
box-shadow:0 10px 25px rgba(0,0,0,0.15);
}

.settings-card.danger i{
color:red;
}
.dark-mode{
background:#1e1e2f;
color:white;
}

.dark-mode .settings-card{
background:#2a2a3c;
color:white;
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
                        Edit Profile
                    </h3>
                </div>

                <div class="overview-row row d-flex">
                    <!--Profile Info-->
                    <div class="earnings profile">
                        <div class="col-profile prof-col1 margin-row-prof shadow-edit">
                            <div class="prof-body pr-body2">
                                <img id="profilePic" src="<?php echo $pp ?>" alt="Profile Picture">
                                <div>
                                    <input type="file" id="fileInput" style="display: none;" accept="image/*">
                                    <button class="button-profile" type="button"
                                        onclick="document.getElementById('fileInput').click();">Change Photo</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Account Info-->
                    <div class="revenue profileInfo">
                        <div class="revenue-container row2-bgEdit">
                            <div class="user-setting-head project-head">
                                <h6>Change Account Info</h6>
                            </div>
                            <div class="user-setting-body project-body">
                                <form action="../../scripts/change_accinfo.php" method="POST">
                                    <!--row1-->
                                    <div class="form-row d-flex justify-between">
                                        <div class="form-row-col d-flex flex-direction-column">
                                            <label class="form-label" for="name"><strong>Name</strong></label>
                                            <input class="form-control-prof" type="text" id="name"
                                                value="<?php echo $name ?>" name="name">
                                        </div>
                                        <div class="form-row-col d-flex flex-direction-column">
                                            <label class="form-label" for="email"><strong>Email Address</strong></label>
                                            <input class="form-control-prof" type="email" id="email"
                                                value="<?php echo $email ?>" name="email">
                                        </div>
                                    </div>
                                    <!--row2-->
                                    <div class="form-row d-flex justify-between">
                                        <div style="margin-bottom: 10px;"
                                            class="form-row-col d-flex flex-direction-column">
                                            <label class="form-label" for="address"><strong>Address</strong></label>
                                            <input class="form-control-prof" type="text" id="address"
                                                value="<?php echo $address ?>" name="address">
                                        </div>
                                    </div>
                                    <small style="text-align: left; margin-bottom: 10px;" id="error-code"
                                        class="error-font">
                                        <?php echo $error ?>
                                    </small>
                                    <!--row3-->
                                    <div class="form-row">
                                        <div class="form-row-button">
                                            <button class="button-profile" type="submit" name="change">Save
                                                Settings</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- Settings Section -->

<div class="overview-row row d-flex" style="margin-top:30px;">

<div class="revenue profileInfo">
<div class="revenue-container row2-bgEdit">

<div class="user-setting-head project-head">
<h6>Security & Settings</h6>
</div>

<div class="settings-grid">

<a href="change_password.php" class="settings-card">
<i class="fas fa-lock"></i>
<p>Change Password</p>
</a>

<a href="change_upi_pin.php" class="settings-card">
<i class="fas fa-key"></i>
<p>Change UPI PIN</p>
</a>

<a href="update_mobile.php" class="settings-card">
<i class="fas fa-phone"></i>
<p>Update Mobile Number</p>
</a>

<a href="debit_card.php" class="settings-card">
<i class="fas fa-credit-card"></i>
<p>Manage Debit Card</p>
</a>

<a href="#" onclick="toggleDarkMode()" class="settings-card">
<i class="fas fa-moon"></i>
<p>Dark Mode</p>
</a>


</div>

</div>
</div>

</div>
                    </div>
                </div>
            </div>
        </div>
        <script src="../../assets/js/file_handle.js"></script>
<script>

function toggleDarkMode(){

document.body.classList.toggle("dark-mode");

localStorage.setItem(
"darkMode",
document.body.classList.contains("dark-mode")
);

}

if(localStorage.getItem("darkMode") === "true"){
document.body.classList.add("dark-mode");
}

</script>
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