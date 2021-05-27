<?php
require_once('DB.php');

$size = $_POST["size"];
changeImageSizes($size);
// var_dump(intval(str_replace(" ", "", "$price")));