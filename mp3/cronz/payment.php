<?php	
session_start();
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/report.class.php");

$obj = new report();

$rs = $obj->salesReportForThisMonth();
$obj->addPaymentInfo($rs)
?>