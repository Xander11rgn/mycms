<?php
require_once('DB.php');

$shopName = $_POST['shopName'];
$designName = $_POST["designName"];
$payments = $_POST["payments"];
$deliveries = $_POST["deliveries"];
$contactPhone = $_POST["contactPhone"];
$contactMail = $_POST["contactMail"];
$imgSize = $_POST["imgSize"];


create($shopName, $designName, $payments, $deliveries, $contactPhone, $contactMail);
// var_dump($_POST);