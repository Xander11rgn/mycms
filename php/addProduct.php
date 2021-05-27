<?php
require_once('DB.php');

$productName = $_POST["productName"];
$description = $_POST["description"];
$price = $_POST["price"];
$isAvailable = $_POST["isAvailable"];
$count = $_POST["count"];
$imgData = $_POST["imgData"];

$productID = addProduct($productName, $description, $price, $isAvailable, $count);
addImage($productID, $imgData);
// var_dump(intval(str_replace(" ", "", "$price")));