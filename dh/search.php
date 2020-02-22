<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	
	$obj = new software();

	$data['sort']	= $_GET['sort'];
	$data['pub']	= base64_decode($_GET['pub']); 
	$data['cat']	= $_REQUEST['search_cat'];
	$data['subcat']	= $_REQUEST['subcategories']; 
	$data['title']	= $_REQUEST['search_text']; 
	$data['text']	= $_REQUEST['search_text_any']; 
	$data['filesize']	= $_REQUEST['filesize'];
	$data['pricelimit']	= $_REQUEST['pricelimit'];
	$data['keyword']	= $_REQUEST['keyword'];
	if(empty($data['pricelimit']))
	{
		$data['sprice']= $_REQUEST['sprice']; 
		$data['eprice']= $_REQUEST['eprice']; 
	}

	$presult 	= $obj->getSoftwareList($data);
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = DOMAIN."search.php?search_cat={$data['cat']}&subcat={$data['subcat']}&search_text={$data['title']}&text={$data['text']}&filesize={$data['filesize']}&sprice={$data['sprice']}&eprice={$data['eprice']}&pricelimit={$data['pricelimit']}&pub={$_GET['pub']}"; 
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);

	$classSoftware 	= "selected";
	$page 			= "software_list.php";
	$pageTitle		= "&raquo; Software ";
	$textHeading    = (!empty($data['pub']))? "for {$data['pub']}" : "";
	$keywordHeading = (!empty($data['keyword']))? "[Keyword: {$data['keyword']}]" : "";
	
	if(!empty($cat))
	{
		$pageTitle	.= "&raquo; {$presult[0][category]}";
	}
	
	$showSearchSort = true;
	include_once("page_tmp.php");
?>