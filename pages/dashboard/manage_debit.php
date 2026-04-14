<?php
session_start();
require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];

$res = mysqli_query($conn,"SELECT * FROM debit_cards WHERE AccNo='$accNo'");
$row = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Debit Card</title>

<style>

body{
font-family:'Segoe UI';
background:#f5f6fa;
margin:0;
}

/* CONTAINER */
.container{
width:420px;
margin:20px auto;
}

/* HEADER */
.header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:10px;
}

/* CARD */
.card{
background:linear-gradient(135deg,#1fa463,#0d6b3c);
color:white;
padding:20px;
border-radius:15px;
position:relative;
}

/* CHIP */
.chip{
width:40px;
height:30px;
background:gold;
border-radius:5px;
margin-bottom:10px;
}

/* BANK */
.bank{
position:absolute;
top:20px;
right:20px;
font-weight:bold;
}

/* NUMBER */
.number{
letter-spacing:2px;
margin:15px 0;
font-size:18px;
}

/* NAME */
.name{
text-transform:uppercase;
font-size:14px;
}

/* TOGGLE */
.toggle-box{
display:flex;
justify-content:space-between;
margin:10px 0;
}

/* OPTIONS */
.option{
background:white;
padding:15px;
border-radius:12px;
margin-top:10px;
display:flex;
align-items:center;
gap:10px;
cursor:pointer;
box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

</style>

</head>

<body>

<div class="container">

<div class="header">
<h3>Manage Debit Card</h3>
</div>

<?php if($row){ ?>

<!-- CARD UI -->
<div class="card">

<div class="bank">FINOVA</div>

<div class="chip"></div>

<div class="number" id="cardNumber">
**** **** **** <?php echo substr($row['CardNumber'], -4); ?>
</div>

<p>VALID THRU: <?php echo date('m/y', strtotime($row['Expiry'])); ?></p>

<p class="name"><?php echo $row['CardHolder']; ?></p>

<!-- CVV -->
<div id="cvvBox" style="display:none;">
CVV: <?php echo $row['CVV']; ?>
</div>

</div>

<!-- TOGGLES -->
<div class="toggle-box">

<label>
Card Details
<input type="checkbox" id="toggleDetails">
</label>

<label>
CVV
<input type="checkbox" id="toggleCVV">
</label>

</div>

<!-- OPTIONS -->
<div class="option" onclick="go('block_card.php')">
🚫 Block / Unblock Card
</div>

<div class="option" onclick="go('card_usage.php')">
📊 Manage Card Usage
</div>

<div class="option" onclick="go('pin_generate.php')">
🔐 PIN Generation
</div>

<div class="option" onclick="go('card_summary.php')">
📄 Card Summary
</div>

<?php } else { ?>

<p>No Debit Card Found</p>

<?php } ?>

</div>

<script>

/* SHOW FULL CARD NUMBER */
document.getElementById("toggleDetails").addEventListener("change", function(){

if(this.checked){
document.getElementById("cardNumber").innerText =
"<?php echo $row['CardNumber'] ?? ''; ?>";
}else{
document.getElementById("cardNumber").innerText =
"**** **** **** <?php echo substr($row['CardNumber'] ?? '', -4); ?>";
}

});

/* SHOW CVV */
document.getElementById("toggleCVV").addEventListener("change", function(){

document.getElementById("cvvBox").style.display =
this.checked ? "block" : "none";

});

/* NAVIGATION */
function go(page){
window.location.href = page;
}

</script>

</body>
</html>