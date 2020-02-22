<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	
	$obj = new software();
	
	$cat			= $_GET['cat'];
	$presult 		= $obj->getNewsByCategory($cat);
	$latestNews 	= $obj->getLatestNews(1);
	
	$_LIMIT 	= 6;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = DOMAIN."news_listing.php?cat=$cat&sort=$sort";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
	
	$classNews 		= "selected";
	$page 			= "news_listing.php";
	$pageTitle		= "&raquo; News ";
	
	if(!empty($cat))
	{
		$pageTitle	.= "&raquo; {$results[0][cat_name]}";
	}

	include_once("page_tmp.php");
?>