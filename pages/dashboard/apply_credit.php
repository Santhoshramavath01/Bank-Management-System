<?php
session_start();
require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];

/* GET BALANCE */
$res = mysqli_query($conn,"SELECT Balance FROM balance WHERE AccNo='$accNo'");
$bal = mysqli_fetch_assoc($res);
$balance = $bal['Balance'] ?? 0;

/* CHECK EXISTING CARD */
$res2 = mysqli_query($conn,"SELECT * FROM credit_cards WHERE AccNo='$accNo'");
$hasCard = mysqli_num_rows($res2) > 0;

$eligible = ($balance >= 5000 && !$hasCard);
?>

<!DOCTYPE html>
<html>
<head>
<title>Apply Credit Card</title>

<style>
body{font-family:'Segoe UI';background:#eef2ff;}
.container{width:420px;margin:40px auto;background:white;padding:25px;border-radius:15px;}
.step{display:none;}
.step.active{display:block;}
.title{font-size:20px;color:#4e73df;margin-bottom:15px;}
input,select{width:100%;padding:12px;margin-bottom:10px;border-radius:8px;border:1px solid #ddd;}
button{width:100%;padding:12px;background:#4e73df;color:white;border:none;border-radius:8px;}
.warning{background:#ffe6e6;padding:10px;color:red;border-radius:8px;}
.success{background:#e6ffed;padding:10px;color:green;border-radius:8px;}
</style>
</head>

<body>

<div class="container">

<!-- STEP 1 -->
<div class="step active" id="step1">
<div class="title">Eligibility Check</div>

<?php if($eligible){ ?>
<div class="success">✔ Eligible for Credit Card</div>
<button onclick="next()">Continue</button>
<?php } else { ?>
<div class="warning">
❌ Not Eligible<br>
• Balance must be ₹5000+<br>
• Only one credit card allowed
</div>
<?php } ?>

</div>

<!-- STEP 2 -->
<div class="step" id="step2">
<div class="title">Financial Details</div>

<input type="number" id="income" placeholder="Monthly Income" required>
<input type="text" id="job" placeholder="Occupation" required>

<button onclick="validateIncome()">Continue</button>
</div>

<!-- STEP 3 -->
<div class="step" id="step3">
<div class="title">Card Selection</div>

<select id="card_type">
<option>Visa</option>
<option>MasterCard</option>
<option>RuPay</option>
</select>

<select id="limit">
<option value="50000">₹50,000 Limit</option>
<option value="100000">₹1,00,000 Limit</option>
<option value="200000">₹2,00,000 Limit</option>
</select>

<button onclick="submitForm()">Apply Now</button>
</div>

</div>

<script>
let step=1;

function next(){
document.getElementById("step"+step).classList.remove("active");
step++;
document.getElementById("step"+step).classList.add("active");
}

function validateIncome(){
let income = document.getElementById("income").value;

if(income < 15000){
alert("Minimum income ₹15000 required");
return;
}
next();
}

function submitForm(){

let form = document.createElement("form");
form.method="POST";
form.action="../../scripts/apply_credit_process.php";

let fields={
income:document.getElementById("income").value,
job:document.getElementById("job").value,
card_type:document.getElementById("card_type").value,
limit:document.getElementById("limit").value
};

for(let key in fields){
let i=document.createElement("input");
i.type="hidden";
i.name=key;
i.value=fields[key];
form.appendChild(i);
}

document.body.appendChild(form);
form.submit();
}
</script>

</body>
</html>