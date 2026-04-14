<?php
session_start();
require('../../configs/db.php');

$accNo = $_SESSION['AccNo'];

/* GET USER BALANCE */
$res = mysqli_query($conn,"SELECT Balance FROM balance WHERE AccNo='$accNo'");
$data = mysqli_fetch_assoc($res);
$balance = $data['Balance'] ?? 0;

/* GET USER ADDRESS */
$res2 = mysqli_query($conn,"SELECT Address FROM userinfo WHERE AccNo='$accNo'");
$user = mysqli_fetch_assoc($res2);
$defaultAddress = $user['Address'] ?? '';

/* ELIGIBILITY */
$eligible = $balance >= 1000;
?>

<!DOCTYPE html>
<html>
<head>
<title>Apply Debit Card</title>

<style>
body{font-family:'Segoe UI';background:#eef2ff;}

.container{
width:420px;margin:40px auto;background:white;
padding:25px;border-radius:15px;
box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.step{display:none;}
.step.active{display:block;}

.title{
font-size:20px;
color:#4e73df;
margin-bottom:15px;
}

input,select,textarea{
width:100%;
padding:12px;
margin-bottom:12px;
border-radius:8px;
border:1px solid #ddd;
}

button{
width:100%;
padding:12px;
background:#4e73df;
color:white;
border:none;
border-radius:8px;
cursor:pointer;
}

.warning{
background:#ffe6e6;
padding:10px;
border-radius:8px;
color:red;
margin-bottom:10px;
}

.success{
background:#e6ffed;
padding:10px;
border-radius:8px;
color:green;
margin-bottom:10px;
}
</style>

</head>

<body>

<div class="container">

<!-- STEP 1 -->
<div class="step active" id="step1">

<div class="title">Step 1: Check Eligibility</div>

<?php if($eligible){ ?>
<div class="success">✔ You are eligible for Debit Card</div>
<button onclick="nextStep()">Continue</button>
<?php } else { ?>
<div class="warning">❌ Minimum balance ₹1000 required</div>
<?php } ?>

</div>

<!-- STEP 2 -->
<div class="step" id="step2">

<div class="title">Step 2: Terms & Conditions</div>

<p style="font-size:13px;">
• Card will be delivered within 7 days<br>
• Annual charges may apply<br>
• PIN must be kept confidential
</p>

<label>
<input type="checkbox" id="agree"> I agree to terms
</label>

<button onclick="checkTerms()">Continue</button>

</div>

<!-- STEP 3 -->
<div class="step" id="step3">

<div class="title">Step 3: Card Details</div>

<input type="text" id="name" placeholder="Name on Card" required>

<select id="card_type" required>
<option value="">Select Card Type</option>
<option>Visa</option>
<option>MasterCard</option>
<option>RuPay</option>
</select>

<input type="password" id="pin" placeholder="Set ATM PIN" required>

<button onclick="nextStep()">Continue</button>

</div>

<!-- STEP 4 (NEW ADDRESS STEP) -->
<div class="step" id="step4">

<div class="title">Step 4: Delivery Address</div>

<label>
<input type="checkbox" id="useProfile" checked onchange="toggleAddress()">
Use Profile Address
</label>

<textarea id="address"><?= $defaultAddress ?></textarea>

<div id="extraFields" style="display:none;">
<input type="text" id="city" placeholder="City">
<input type="text" id="state" placeholder="State">
<input type="text" id="pincode" placeholder="Pincode">
</div>

<button onclick="submitForm()">Submit Application</button>

</div>

</div>

<script>

let current = 1;

function nextStep(){
document.getElementById("step"+current).classList.remove("active");
current++;
document.getElementById("step"+current).classList.add("active");
}

function checkTerms(){
if(!document.getElementById("agree").checked){
alert("Please accept terms");
return;
}
nextStep();
}

function toggleAddress(){
let check = document.getElementById("useProfile").checked;

if(check){
document.getElementById("extraFields").style.display="none";
}else{
document.getElementById("extraFields").style.display="block";
document.getElementById("address").value="";
}
}

/* FINAL SUBMIT */
function submitForm(){

let form = document.createElement("form");
form.method = "POST";
form.action = "../../scripts/apply_debit_process.php";

/* DATA */
let fields = {
name: document.getElementById("name").value,
card_type: document.getElementById("card_type").value,
pin: document.getElementById("pin").value,
address: document.getElementById("address").value,
city: document.getElementById("city")?.value || '',
state: document.getElementById("state")?.value || '',
pincode: document.getElementById("pincode")?.value || ''
};

for(let key in fields){
let input = document.createElement("input");
input.type = "hidden";
input.name = key;
input.value = fields[key];
form.appendChild(input);
}

document.body.appendChild(form);
form.submit();
}

</script>

</body>
</html>