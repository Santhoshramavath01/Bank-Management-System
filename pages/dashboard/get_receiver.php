<?php

require('../configs/db.php');

if(isset($_POST['accNo'])){

$accNo = $_POST['accNo'];

$sql = "SELECT Name FROM userinfo WHERE AccNo='$accNo'";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0){

$data = mysqli_fetch_assoc($result);

echo $data['Name'];

}else{

echo "notfound";

}

}
?>