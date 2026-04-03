<!DOCTYPE html>
<html>

<head>

<style>

body{
font-family:Arial;
background:#f5f6ff;
}

.container{
width:700px;
margin:auto;
background:white;
padding:30px;
border-radius:10px;
}

.header{
text-align:center;
margin-bottom:20px;
}

.logo{
width:80px;
}

h2{
color:#4e73df;
margin:5px;
}

.statement{
width:100%;
border-collapse:collapse;
}

.statement th{
background:#4e73df;
color:white;
padding:10px;
}

.statement td{
padding:10px;
border:1px solid #ddd;
}

.credit{
color:green;
font-weight:bold;
}

.debit{
color:red;
font-weight:bold;
}

</style>

</head>

<body>

<div class="container">

<div class="header">

<img src="../assets/img/logo.png" class="logo">

<h2>Finova Bank Ltd</h2>

<p>Smart Banking for Everyone</p>

<h3>Bank Statement</h3>

</div>

<table class="statement">

<thead>

<tr>

<th>Transaction Type</th>
<th>Description</th>
<th>Amount</th>
<th>Remarks</th>
<th>Date</th>
<th>Time</th>

</tr>

</thead>

<tbody>

<?php

foreach ($trns as $trn){

$date = date("d-m-Y", strtotime($trn['DateTime']));
$time = date("H:i:s", strtotime($trn['DateTime']));

$sender = $trn['Sender'];
$receiver = $trn['Receiver'];
$amount = $trn['Amount'];
$remarks = $trn['Remarks'];

if($sender == $accNo){

echo "<tr>
<td class='debit'>Debit</td>
<td>Transfer to $receiver</td>
<td>Rs $amount</td>
<td>$remarks</td>
<td>$date</td>
<td>$time</td>
</tr>";

}else{

echo "<tr>
<td class='credit'>Credit</td>
<td>Transfer from $sender</td>
<td>Rs $amount</td>
<td>$remarks</td>
<td>$date</td>
<td>$time</td>
</tr>";

}

}

?>

</tbody>

</table>

</div>

</body>
</html>