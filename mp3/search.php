<?php	
session_start();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");
include_once("classes/pagination.class.php");

$siteObj = new site();

$rs = array("s" => $_REQUEST['s'],
			"opt" => $_REQUEST['opt']);

$presult = $siteObj->searchMP3($rs);

$_LIMIT 	= 8;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "search.php?s={$_REQUEST['s']}&opt={$_REQUEST['opt']}";
$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$results 	= $p->getPaginatedResults($presult);

include_once("templates/list_tmp.html");
?>