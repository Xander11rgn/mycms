<?php
require_once('DB.php');

$reportType = $_POST["reportType"];
$fields = $_POST["fields"];


$reportHtml = generateReport($reportType, $fields);
$reportName = "reports/report" . time() . ".html";
file_put_contents("../" . $reportName, $reportHtml);
echo $reportName;