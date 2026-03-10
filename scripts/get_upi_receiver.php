<?php

require('../configs/db.php');

$upi = $_POST['upi'];

$sql="SELECT Name FROM userinfo WHERE UPI='$upi'";
$res=mysqli_query($conn,$sql);

if(mysqli_num_rows($res)>0){

$data=mysqli_fetch_assoc($res);
echo $data['Name'];

}else{

echo "notfound";

}

?>