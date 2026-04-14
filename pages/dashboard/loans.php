<?php
session_start();
if (!isset($_SESSION['AccNo'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Loans</title>

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
width:90%;
margin:30px auto;
}

/* TITLE */
.title{
font-size:26px;
font-weight:600;
margin-bottom:20px;
color:#333;
}

/* QUICK ACTIONS */
.quick-actions{
display:flex;
gap:15px;
margin-bottom:30px;
flex-wrap:wrap;
}

.action-btn{
background:white;
padding:12px 18px;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.08);
cursor:pointer;
transition:0.2s;
}

.action-btn:hover{
background:#4e73df;
color:white;
}

/* GRID */
.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:20px;
}

/* CARD */
.card{
background:linear-gradient(135deg,#4e73df,#224abe);
color:white;
padding:25px;
border-radius:15px;
box-shadow:0 8px 20px rgba(0,0,0,0.15);
cursor:pointer;
transition:0.3s;
position:relative;
overflow:hidden;
}

.card:hover{
transform:translateY(-8px) scale(1.03);
}

/* ICON */
.icon{
font-size:40px;
margin-bottom:10px;
}

/* TEXT */
.card h3{
margin:10px 0 5px;
}

.card p{
font-size:13px;
opacity:0.9;
}

/* BADGE */
.badge{
position:absolute;
top:10px;
right:10px;
background:white;
color:#4e73df;
padding:3px 8px;
border-radius:20px;
font-size:10px;
font-weight:600;
}

</style>

</head>

<body>

<div class="header">
🏦 Finova Bank - Loans
</div>

<div class="container">

<div class="title">💰 Loans & Credit</div>

<!-- QUICK ACTIONS -->
<div class="quick-actions">

<div class="action-btn" onclick="goTo('loans.php')">Apply Loan</div>
<div class="action-btn" onclick="goTo('loan_status.php')">Loan Status</div>
<div class="action-btn" onclick="goTo('loan_calculator.php')">EMI Calculator</div>

</div>

<!-- LOAN TYPES -->
<div class="grid">

<div class="card" onclick="applyLoan('Education')">
<div class="badge">Low Interest</div>
<div class="icon">🎓</div>
<h3>Education Loan</h3>
<p>Support your studies with flexible repayment options.</p>
</div>

<div class="card" onclick="applyLoan('Home')">
<div class="badge">Popular</div>
<div class="icon">🏠</div>
<h3>Home Loan</h3>
<p>Buy your dream home with easy EMI plans.</p>
</div>

<div class="card" onclick="applyLoan('Gold')">
<div class="badge">Instant</div>
<div class="icon">🪙</div>
<h3>Gold Loan</h3>
<p>Get quick funds against your gold assets.</p>
</div>

<div class="card" onclick="applyLoan('Car')">
<div class="badge">Fast</div>
<div class="icon">🚗</div>
<h3>Car Loan</h3>
<p>Drive your dream car with affordable EMIs.</p>
</div>

<div class="card" onclick="applyLoan('Personal')">
<div class="badge">Flexible</div>
<div class="icon">💳</div>
<h3>Personal Loan</h3>
<p>Instant personal loans for your needs.</p>
</div>

<div class="card" onclick="applyLoan('Agriculture')">
<div class="badge">Special</div>
<div class="icon">🌱</div>
<h3>Agriculture Loan</h3>
<p>Financial support for farming and crops.</p>
</div>

</div>

</div>

<script>

/* APPLY LOAN */
function applyLoan(type){
window.location.href = "loan_apply.php?type="+type;
}

/* QUICK NAVIGATION */
function goTo(page){
window.location.href = page;
}

</script>

</body>
</html>