<?php
require_once('DB.php');

$login = $_POST['login'];
$password = $_POST["password"];


checkUser($login, $password);
// var_dump($_POST);