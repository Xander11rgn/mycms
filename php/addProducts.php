<?php
require_once('DB.php');

$data = $_POST["data"];
$isAvailable = $_POST["isAvailable"];
$count = $_POST["count"];

for ($i=0; $i < count($data); $i++) { 
  $productID = addProduct($data[$i]["productName"], $data[$i]["description"], $data[$i]["price"], $isAvailable, $count);
  addImage($productID, $data[$i]["img"]);
}

// var_dump(intval(str_replace(" ", "", "$price")));