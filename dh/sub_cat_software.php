<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	
	$obj = new software();

	$data['cat']		= $_GET['cat'];
	$data['sub_cat']	= $_GET['sub_cat'];
	$data['sort']		= $_GET['sort'];
	$data['sortby']		= $_GET['sortby'];
	$presult 			= $obj->getSoftwareBySubcategory($data);
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = DOMAIN."sub_cat_software.php?cat={$data['cat']}&sub_cat={$data['sub_cat']}&sort={$data['sort']}";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
	
	$classSoftware 	= "selected";
	$page 			= "software_list.php";
	$pageTitle		= "&raquo; Software ";
	if(!empty($cat))
	{
		$str = explode("::", $presult[0]['program_category_class']);
		$pageTitle	.= "&raquo; {$presult[0][category]} &raquo; {$str[1]}";
	}
	
	$subCat = true;
	include_once("page_tmp.php");
?>