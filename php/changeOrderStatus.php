<?php
require_once('DB.php');

if (isset($_POST["orderID"]) and isset($_POST["statusID"])) {
  $orderID = $_POST["orderID"];
  $statusID = $_POST["statusID"];
}

changeOrderStatus($orderID, $statusID);
// var_dump(intval(str_replace(" ", "", "$price")));