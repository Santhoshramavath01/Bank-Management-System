<!DOCTYPE html>
<html>
<head>
<title>EMI Calculator</title>

<style>
body{font-family:'Segoe UI';background:#eef2ff;}

.container{
width:420px;margin:50px auto;background:white;
padding:25px;border-radius:15px;
box-shadow:0 5px 20px rgba(0,0,0,0.1);
}

input{width:100%;padding:12px;margin-bottom:10px;}

button{
width:100%;padding:10px;
background:#4e73df;color:white;border:none;border-radius:8px;
}

.result{
margin-top:15px;font-weight:bold;
color:#4e73df;
}
</style>

<script>
function calculateEMI(){

let P = document.getElementById("amount").value;
let r = document.getElementById("rate").value / 12 / 100;
let n = document.getElementById("tenure").value;

let emi = (P*r*Math.pow(1+r,n))/(Math.pow(1+r,n)-1);

document.getElementById("result").innerHTML =
"Monthly EMI: ₹"+Math.round(emi);

}
</script>

</head>

<body>

<div class="container">

<h3>EMI Calculator</h3>

<input type="number" id="amount" placeholder="Loan Amount">
<input type="number" id="rate" placeholder="Interest Rate (%)">
<input type="number" id="tenure" placeholder="Tenure (Months)">

<button onclick="calculateEMI()">Calculate</button>

<div id="result" class="result"></div>

</div>

</body>
</html>