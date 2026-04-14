<!DOCTYPE html>
<html>
<head>
<title>Loan Offers</title>

<style>

body{
font-family:'Segoe UI';
background:#eef2ff;
margin:0;
}

/* CONTAINER */
.container{
width:90%;
margin:40px auto;
}

/* TITLE */
.title{
font-size:24px;
font-weight:600;
margin-bottom:20px;
}

/* GRID */
.grid{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
gap:20px;
}

/* CARD */
.card{
background:white;
padding:20px;
border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,0.1);
transition:0.3s;
cursor:pointer;
}

.card:hover{
transform:translateY(-6px);
}

/* ICON */
.icon{
font-size:35px;
margin-bottom:10px;
}

/* TEXT */
.card h3{
margin:10px 0 5px;
}

.card p{
margin:4px 0;
font-size:14px;
color:#555;
}

/* BADGE */
.badge{
display:inline-block;
background:#4e73df;
color:white;
padding:3px 10px;
border-radius:20px;
font-size:12px;
margin-bottom:8px;
}

</style>

</head>

<body>

<div class="container">

<div class="title">🎁 Loan Offers</div>

<div class="grid">

<!-- HOME -->
<div class="card">
<div class="badge">Low Interest</div>
<div class="icon">🏠</div>
<h3>Home Loan</h3>
<p>Interest: 8.5%</p>
<p>Max Amount: ₹50 Lakhs</p>
</div>

<!-- PERSONAL -->
<div class="card">
<div class="badge">Instant</div>
<div class="icon">💳</div>
<h3>Personal Loan</h3>
<p>Interest: 10%</p>
<p>Instant Approval</p>
</div>

<!-- EDUCATION -->
<div class="card">
<div class="badge">Student Friendly</div>
<div class="icon">🎓</div>
<h3>Education Loan</h3>
<p>Interest: 7.5%</p>
<p>No collateral required</p>
</div>

<!-- CAR -->
<div class="card">
<div class="badge">Fast Approval</div>
<div class="icon">🚗</div>
<h3>Car Loan</h3>
<p>Interest: 9%</p>
<p>Up to ₹20 Lakhs</p>
</div>

<!-- GOLD -->
<div class="card">
<div class="badge">Quick Loan</div>
<div class="icon">🪙</div>
<h3>Gold Loan</h3>
<p>Interest: 8%</p>
<p>Instant disbursement</p>
</div>

<!-- AGRICULTURE -->
<div class="card">
<div class="badge">Special Scheme</div>
<div class="icon">🌱</div>
<h3>Agriculture Loan</h3>
<p>Interest: 6%</p>
<p>For farmers & crops</p>
</div>

<!-- BUSINESS -->
<div class="card">
<div class="badge">SME Support</div>
<div class="icon">🏢</div>
<h3>Business Loan</h3>
<p>Interest: 11%</p>
<p>Up to ₹1 Crore</p>
</div>

<!-- LAP -->
<div class="card">
<div class="badge">High Value</div>
<div class="icon">🏦</div>
<h3>Loan Against Property</h3>
<p>Interest: 8.75%</p>
<p>High loan amount</p>
</div>

</div>

</div>

</body>
</html>