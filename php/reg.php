<?php
require_once('DB.php');

$login = $_POST['login'];
$password = $_POST["password"];
$lastName = $_POST["lastName"];
$firstName = $_POST["firstName"];
$middleName = $_POST["middleName"];
$mail = $_POST["mail"];
$phone = $_POST["phone"];
$groupID = intval($_POST["groupID"]);


addUser($login, $password, $lastName, $firstName, $middleName, $mail, $phone, $groupID);
// var_dump($_POST);