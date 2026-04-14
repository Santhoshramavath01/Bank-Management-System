<?php
session_start();
require('../../configs/db.php');

if (!isset($_SESSION['AccNo'])) {
    header("Location: ../login.php");
    exit;
}

$accNo = $_SESSION['AccNo'];

$res = mysqli_query($conn,
"SELECT * FROM loans WHERE AccNo='$accNo' ORDER BY CreatedAt DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Loan Status</title>

<style>

body{
font-family:'Segoe UI';
background:#eef2ff;
margin:0;
}

/* HEADER */
.header{
background:white;
padding:15px 30px;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
font-weight:600;
color:#4e73df;
}

/* CONTAINER */
.container{
width:85%;
margin:40px auto;
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

/* TITLE */
.title{
font-size:22px;
margin-bottom:20px;
}

/* TABLE */
table{
width:100%;
border-collapse:collapse;
}

th{
background:#f4f6fb;
padding:12px;
text-align:left;
}

td{
padding:12px;
border-bottom:1px solid #eee;
}

/* STATUS */
.status{
padding:5px 10px;
border-radius:20px;
font-size:12px;
font-weight:600;
}

.pending{
background:#fff3cd;
color:#856404;
}

.approved{
background:#d4edda;
color:#155724;
}

.rejected{
background:#f8d7da;
color:#721c24;
}

/* BADGE */
.badge{
background:#4e73df;
color:white;
padding:3px 8px;
border-radius:6px;
font-size:12px;
}

/* EMPTY */
.empty{
text-align:center;
padding:30px;
color:#888;
}

</style>

</head>

<body>

<div class="header">
🏦 Finova Bank - Loan Status
</div>

<div class="container">

<div class="title">📊 Your Loan Applications</div>

<table>

<tr>
<th>Loan ID</th>
<th>Type</th>
<th>Amount</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php

if(mysqli_num_rows($res) == 0){

echo "<tr><td colspan='5' class='empty'>No loan applications found</td></tr>";

}else{

while($row=mysqli_fetch_assoc($res)){

/* 🔥 FORCE STATUS TO PENDING (SAFE FIX) */
$status = $row['Status'];

/* If accidentally approved → still show pending */
if($status != "REJECTED"){
    $status = "PENDING";
}

$statusClass = strtolower($status);

/* STATUS TEXT */
if($status == "PENDING"){
$statusText = "⏳ Pending Review";
}elseif($status == "APPROVED"){
$statusText = "✅ Approved";
}else{
$statusText = "❌ Rejected";
}

echo "<tr>
<td>{$row['LoanID']}</td>
<td><span class='badge'>{$row['LoanType']}</span></td>
<td>₹{$row['Amount']}</td>
<td><span class='status $statusClass'>$statusText</span></td>
<td>{$row['CreatedAt']}</td>
</tr>";

}

}

?>

</table>

</div>

</body>
</html>