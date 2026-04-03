<?php
session_start();

if (!isset($_SESSION['AccNo'])) {
    header("Location: ../login.php");
    exit;
}

require('../configs/db.php');

$accNo = $_SESSION['AccNo'];

/* GET RANGE */
$range = isset($_GET['range']) ? $_GET['range'] : 'all';

$dateFilter = "";

if ($range == "week") {
    $dateFilter = "AND DateTime >= DATE_SUB(NOW(), INTERVAL 7 DAY)";
}

if ($range == "month") {
    $dateFilter = "AND DateTime >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
}

/* STATEMENT PERIOD TEXT */
if ($range == "week") {
    $period = "Last 1 Week";
}
elseif ($range == "month") {
    $period = "Last 1 Month";
}
else {
    $period = "All Transactions";
}

/* GET CUSTOMER NAME */
$userQuery = "SELECT Name FROM userinfo WHERE AccNo='$accNo'";
$userResult = mysqli_query($conn,$userQuery);
$user = mysqli_fetch_assoc($userResult);
$customerName = $user['Name'];

/* GET TRANSACTIONS */
$query = "SELECT * FROM transactions 
WHERE (Sender='$accNo' OR Receiver='$accNo') 
$dateFilter
ORDER BY DateTime DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Database Query Failed: " . mysqli_error($conn));
}

$transactions = mysqli_fetch_all($result, MYSQLI_ASSOC);

/* LOAD PDF LIBRARY */
require('../libs/fpdf186/fpdf.php');

$pdf = new FPDF();
$pdf->AddPage();

/* TITLE */
$pdf->SetFont('Arial','B',20);
$pdf->Cell(0,15,'Finova Bank Statement',0,1,'C');

$pdf->Ln(3);

/* CUSTOMER DETAILS */
$pdf->SetFont('Arial','',12);

$pdf->Cell(0,8,'Customer Name : '.$customerName,0,1);
$pdf->Cell(0,8,'Account Number : '.$accNo,0,1);
$pdf->Cell(0,8,'Statement Period : '.$period,0,1);

$pdf->Ln(8);

/* TABLE HEADER */
$pdf->SetFont('Arial','B',11);
$pdf->SetFillColor(52,152,219);
$pdf->SetTextColor(255,255,255);

$pdf->Cell(35,10,'Type',1,0,'C',true);
$pdf->Cell(55,10,'Description',1,0,'C',true);
$pdf->Cell(25,10,'Amount',1,0,'C',true);
$pdf->Cell(35,10,'Date',1,0,'C',true);
$pdf->Cell(35,10,'Time',1,1,'C',true);

/* RESET TEXT COLOR */
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',10);

/* TABLE DATA */
foreach($transactions as $trn){

$date = date('d-m-Y', strtotime($trn['DateTime']));
$time = date('H:i:s', strtotime($trn['DateTime']));

if($trn['Sender'] == $accNo){
$type = "Debit";
$desc = "Transfer to ".$trn['Receiver'];
}else{
$type = "Credit";
$desc = "Transfer from ".$trn['Sender'];
}

$pdf->Cell(35,10,$type,1,0,'C');
$pdf->Cell(55,10,$desc,1,0,'L');
$pdf->Cell(25,10,"Rs ".$trn['Amount'],1,0,'C');
$pdf->Cell(35,10,$date,1,0,'C');
$pdf->Cell(35,10,$time,1,1,'C');

}

$pdf->Output();
?>