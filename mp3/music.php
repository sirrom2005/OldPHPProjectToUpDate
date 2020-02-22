<?php	
session_start();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");
include_once("classes/pagination.class.php");

$siteObj 	= new site();
$ary = NULL;
$rs  = NULL;


if(!empty($_POST))
{
	$rs = $_POST;
	$ary = array("searchopt" => $rs['searchopt'], "searchtext" => $rs['searchtext']);
}
else
{
	$ary = array("searchopt" => base64_decode($_GET['f']), "searchtext" => $_GET['s']);
	$rs  = array("searchopt" => "dfgfdgd", "searchtext" => $ary['searchtext']);
}

$presult 	= $siteObj->searchMP3($rs);

$_LIMIT 	= 8;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "music.html?l=V435435&f=".base64_encode($ary['searchopt'])."&s=".$ary['searchtext'];
$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$results 	= $p->getPaginatedResults($presult);

if(!isset($_SESSION['CARTITEM'])){$_SESSION['CARTITEM'] = array();} 
include_once("templates/search_layout.html");
?>