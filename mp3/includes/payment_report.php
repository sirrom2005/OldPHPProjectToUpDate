<?php
include_once("../classes/report.class.php");
include_once("../classes/pagination.class.php");

$repObj 	= new report();

$presult 	= $repObj->getSalesReport($_SESSION['USER']['id']);

$_LIMIT 	= 10;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "index.php?action=sales_report";
$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$results = $p->getPaginatedResults($presult);
?>