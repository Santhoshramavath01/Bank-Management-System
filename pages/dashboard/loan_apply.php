<?php
session_start();
$type = $_GET['type'] ?? 'Loan';
?>

<!DOCTYPE html>
<html>
<head>
<title>Apply Loan</title>

<style>

body{
font-family:'Segoe UI';
background:#eef2ff;
margin:0;
}

.container{
width:600px;
margin:40px auto;
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.title{
font-size:24px;
color:#4e73df;
margin-bottom:20px;
font-weight:600;
}

.section{
margin-top:20px;
margin-bottom:10px;
font-weight:600;
color:#555;
}

input, select{
width:100%;
padding:12px;
margin-bottom:12px;
border-radius:8px;
border:1px solid #ddd;
font-size:14px;
}

.row{
display:flex;
gap:10px;
}

.row input{
flex:1;
}

button{
width:100%;
padding:14px;
background:linear-gradient(135deg,#4e73df,#224abe);
color:white;
border:none;
border-radius:10px;
font-size:16px;
font-weight:600;
cursor:pointer;
margin-top:10px;
}

button:hover{
opacity:0.9;
}

</style>

</head>

<body>

<div class="container">

<!-- ✅ DYNAMIC TITLE -->
<div class="title">Apply for <?php echo $type; ?> Loan</div>

<form action="../../scripts/loan_apply_process.php" method="POST">

<input type="hidden" name="loan_type" value="<?php echo $type; ?>">

<!-- PERSONAL DETAILS -->
<div class="section">👤 Personal Details</div>

<div class="row">
<input type="text" name="fullname" placeholder="Full Name" required>
<input type="text" name="mobile" placeholder="Mobile Number" required>
</div>

<input type="email" name="email" placeholder="Email Address" required>

<!-- LOAN DETAILS -->
<div class="section">💰 Loan Details</div>

<div class="row">
<input type="number" name="amount" placeholder="Loan Amount" required>
<input type="number" name="tenure" placeholder="Tenure (Months)" required>
</div>

<input type="number" name="income" placeholder="Monthly Income" required>

<!-- ✅ DYNAMIC LOAN PURPOSE -->
<select name="loan_purpose" required>
<option value="">Select Purpose</option>
<option>Personal Use</option>
<option>Business</option>
<option>Emergency</option>
</select>

<!-- ✅ DYNAMIC SECTIONS BASED ON LOAN TYPE -->

<?php if($type == "Education"){ ?>

<div class="section">🎓 Education Details</div>

<input type="text" name="course" placeholder="Course Name" required>
<input type="text" name="college" placeholder="College / University Name" required>

<select name="study_location" required>
<option value="">Study Location</option>
<option>India</option>
<option>Abroad</option>
</select>

<?php } elseif($type == "Car"){ ?>

<div class="section">🚗 Vehicle Details</div>

<input type="text" name="car_model" placeholder="Car Model" required>
<input type="number" name="car_price" placeholder="Car Price" required>

<?php } elseif($type == "Home"){ ?>

<div class="section">🏠 Property Details</div>

<input type="text" name="property_location" placeholder="Property Location" required>
<input type="number" name="property_value" placeholder="Property Value" required>

<?php } elseif($type == "Gold"){ ?>

<div class="section">🪙 Gold Details</div>

<input type="number" name="gold_weight" placeholder="Gold Weight (grams)" required>

<?php } elseif($type == "Personal"){ ?>

<div class="section">💳 Loan Purpose</div>

<input type="text" name="purpose" placeholder="Reason for Loan" required>

<?php } elseif($type == "Agriculture"){ ?>

<div class="section">🌱 Agriculture Details</div>

<input type="text" name="land_area" placeholder="Land Area (acres)" required>
<input type="text" name="crop_type" placeholder="Crop Type" required>

<?php } ?>

<!-- FINANCIAL DETAILS -->
<div class="section">🏦 Financial Details</div>

<select name="existing_loan">
<option value="">Any Existing Loan?</option>
<option>Yes</option>
<option>No</option>
</select>

<input type="number" name="existing_emi" placeholder="Existing EMI (if any)">

<!-- SUBMIT -->
<button type="submit">Apply Now</button>

</form>

</div>

</body>
</html>