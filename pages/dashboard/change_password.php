<?php
session_start();

if (!isset($_SESSION['AccNo'])) {
    header('Location: ../login.php?msg=Please login first');
    exit;
}

require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];
$msg = "";

if(isset($_POST['change_password'])){

$currentPassword = $_POST['current_password'];
$newPassword = $_POST['new_password'];
$confirmPassword = $_POST['confirm_password'];

/* Get current password from database */

$sql = "SELECT Pass FROM credentials WHERE AccNo='$accNo'";
$result = mysqli_query($conn,$sql);
$row = mysqli_fetch_assoc($result);

/* Verify current password */

if(!password_verify($currentPassword,$row['Pass'])){

$msg = "Current password is incorrect";

}

/* Check new password match */

else if($newPassword != $confirmPassword){

$msg = "New passwords do not match";

}

else{

$newHash = password_hash($newPassword, PASSWORD_DEFAULT);

$update = "UPDATE credentials SET Pass='$newHash' WHERE AccNo='$accNo'";
mysqli_query($conn,$update);

$msg = "Password updated successfully";

}

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Change Password - Finova Bank</title>

<link rel="stylesheet" href="./css/common.css">
<link rel="stylesheet" href="./css/all.min.css">

<style>

.change-container{
max-width:450px;
margin:60px auto;
background:#fff;
padding:30px;
border-radius:10px;
box-shadow:0 4px 15px rgba(0,0,0,0.1);
}

.change-container h3{
text-align:center;
margin-bottom:25px;
}

.form-group{
margin-bottom:15px;
}

.form-group input{
width:100%;
padding:10px;
border-radius:6px;
border:1px solid #ccc;
}

.change-btn{
width:100%;
padding:10px;
background:#4e73df;
border:none;
color:white;
border-radius:6px;
cursor:pointer;
}

.change-btn:hover{
background:#2e59d9;
}

.msg{
text-align:center;
margin-top:10px;
color:red;
}

</style>

</head>

<body>

<div class="change-container">

<h3>Change Password</h3>

<form method="POST">

<div class="form-group">
<label>Current Password</label>
<input type="password" name="current_password" required>
</div>

<div class="form-group">
<label>New Password</label>
<input type="password" name="new_password" required>
</div>

<div class="form-group">
<label>Confirm New Password</label>
<input type="password" name="confirm_password" required>
</div>

<button class="change-btn" name="change_password">
Update Password
</button>

<div class="msg">
<?php echo $msg ?>
</div>

</form>

</div>

</body>
</html>