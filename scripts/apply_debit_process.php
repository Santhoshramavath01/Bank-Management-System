<?php
session_start();
require('../configs/db.php');

$accNo = $_SESSION['AccNo'];

$name = $_POST['name'];
$type = $_POST['card_type'];
$pin  = password_hash($_POST['pin'], PASSWORD_DEFAULT);

/* ADDRESS */
$address = $_POST['address'];
$city    = $_POST['city'] ?? '';
$state   = $_POST['state'] ?? '';
$pincode = $_POST['pincode'] ?? '';

/* GENERATE CARD */
function generateCard($conn){
    do{
        $card = "5214" . rand(100000000000,999999999999);
        $check = mysqli_query($conn,"SELECT CardNumber FROM debit_cards WHERE CardNumber='$card'");
    }while(mysqli_num_rows($check)>0);
    return $card;
}

$cardNo = generateCard($conn);
$cvv = rand(100,999);
$expiry = date("Y-m-d", strtotime("+5 years"));

mysqli_query($conn,"
INSERT INTO debit_cards 
(AccNo, CardNumber, CardHolder, CardType, Expiry, CVV, PIN, DeliveryAddress, City, State, Pincode)
VALUES
('$accNo','$cardNo','$name','$type','$expiry','$cvv','$pin','$address','$city','$state','$pincode')
");

header("Location: ../pages/dashboard/manage_debit.php");
exit;
?>