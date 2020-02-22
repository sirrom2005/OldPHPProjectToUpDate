<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	
	$obj = new software();
	
	$data['cat']	= $_GET['cat'];
	$data['sort']	= $_GET['sort'];
	$data['sortby']	= $_GET['sortby'];
	$presult 		= $obj->getSoftwareList($data);
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = DOMAIN."software.php?sort={$data['sort']}&cat={$data['cat']}";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
	
	if($cat =="games"){ $classGame = "selected"; }else{ $classSoftware = "selected"; }	
	$page 			= "software_list.php";
	$pageTitle		= "&raquo; Software ";
	
	if(!empty($cat))
	{
		$pageTitle	.= "&raquo; {$presult[0][category]}";
	}
	include_once("page_tmp.php");
?>