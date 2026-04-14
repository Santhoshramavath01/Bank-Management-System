<?php
session_start();
require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];

$res = mysqli_query($conn,
"SELECT * FROM loans WHERE AccNo='$accNo'");
?>

<!DOCTYPE html>
<html>
<head>
<title>Loan History</title>

<style>
body{font-family:'Segoe UI';background:#eef2ff;}

.container{
width:70%;margin:40px auto;background:white;
padding:20px;border-radius:12px;
}

.card{
padding:10px;border-bottom:1px solid #ddd;
}
</style>

</head>

<body>

<div class="container">

<h2>Loan History</h2>

<?php
while($row=mysqli_fetch_assoc($res)){
echo "<div class='card'>
{$row['LoanType']} - ₹{$row['Amount']} ({$row['Status']})
</div>";
}
?>

</div>

</body>
</html>