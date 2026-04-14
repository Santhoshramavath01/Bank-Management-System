<?php
$bill = $_GET['bill'] ?? 'UNKNOWN';
?>

<!DOCTYPE html>
<html>
<head>
<title>Payment Success</title>

<style>

body{
font-family:'Segoe UI';
background:#f4f6fb;
margin:0;
}

/* MAIN CARD */
.container{
width:420px;
margin:80px auto;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 10px 30px rgba(0,0,0,0.1);
text-align:center;
}

/* SUCCESS ICON */
.success-icon{
font-size:60px;
color:#28a745;
margin-bottom:15px;
}

/* TITLE */
.title{
font-size:22px;
font-weight:600;
color:#28a745;
margin-bottom:10px;
}

/* BILL DETAILS */
.details{
background:#f4f6ff;
padding:15px;
border-radius:10px;
margin-top:20px;
text-align:left;
font-size:14px;
}

.details p{
margin:6px 0;
}

/* BUTTON */
.btn{
margin-top:20px;
display:inline-block;
padding:10px 20px;
background:#4e73df;
color:white;
border-radius:8px;
text-decoration:none;
}

.btn:hover{
background:#2e59d9;
}

</style>

</head>

<body>

<div class="container">

<div class="success-icon">✔</div>

<div class="title">Payment Successful</div>

<p>Your bill has been paid successfully.</p>

<div class="details">
<p><strong>Bill ID:</strong> <?php echo $bill; ?></p>
<p><strong>Status:</strong> Success</p>
<p><strong>Date:</strong> <?php echo date("d M Y, h:i A"); ?></p>
</div>

<a href="index.php" class="btn">Back to Dashboard</a>

</div>

</body>
</html>