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
<title>Bill Payment</title>

<style>

body{
font-family:'Segoe UI';
background:#f4f6fb;
margin:0;
}

.container{
width:420px;
margin:50px auto;
background:white;
padding:25px;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.1);
}

.header{
text-align:center;
font-size:22px;
font-weight:600;
color:#4e73df;
margin-bottom:20px;
}

input, select{
width:100%;
padding:10px;
margin-bottom:12px;
border-radius:8px;
border:1px solid #ccc;
}

button{
width:100%;
padding:12px;
background:#4e73df;
color:white;
border:none;
border-radius:8px;
font-weight:600;
cursor:pointer;
}

button:hover{
background:#2e59d9;
}

.msg{
color:red;
text-align:center;
margin-bottom:10px;
}

</style>

<script>

function changeForm(){

var type = document.getElementById("bill_type").value;
var container = document.getElementById("dynamicFields");

if(type == "Mobile"){

container.innerHTML = `
<input type="text" name="mobile" placeholder="Enter Mobile Number" required>
<input type="number" name="amount" placeholder="Enter Amount" required>
`;

}

else if(type == "Electricity"){

container.innerHTML = `
<input type="text" name="consumer_no" placeholder="Consumer Number" required>
<input type="text" name="state" placeholder="State" required>
<input type="number" name="amount" placeholder="Enter Amount" required>
`;

}

else if(type == "DTH"){

container.innerHTML = `
<input type="text" name="subscriber_id" placeholder="Subscriber ID" required>
<input type="number" name="amount" placeholder="Enter Amount" required>
`;

}

else if(type == "Water"){

container.innerHTML = `
<input type="text" name="connection_id" placeholder="Connection ID" required>
<input type="number" name="amount" placeholder="Enter Amount" required>
`;

}

else{
container.innerHTML = "";
}

}

</script>

</head>

<body>

<div class="container">

<div class="header">💡 Pay Bills</div>

<div class="msg">
<?php if(isset($_GET['msg'])) echo $_GET['msg']; ?>
</div>

<form action="../../scripts/bill_pay_process.php" method="POST">

<select name="bill_type" id="bill_type" onchange="changeForm()" required>
<option value="">Select Bill Type</option>
<option value="Mobile">📱 Mobile Recharge</option>
<option value="Electricity">⚡ Electricity</option>
<option value="Water">💧 Water</option>
<option value="DTH">📺 DTH</option>
</select>

<!-- Dynamic Fields -->
<div id="dynamicFields"></div>

<!-- Common Fields -->
<input type="text" name="provider" placeholder="Provider (Airtel, BSNL)" required>

<input type="text" name="remarks" placeholder="Optional note">

<input type="password" name="upi_pin" placeholder="Enter UPI PIN" required>

<button type="submit">Pay Now</button>

</form>

</div>

</body>
</html>