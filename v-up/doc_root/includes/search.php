<?php
	error_reporting(0); 
	if(!empty($_REQUEST['s']) || !empty($_GET['tags']) || !empty($_GET['user']) || !empty($_GET['feat']) || !empty($_GET['latest']) )
	{
		$data['text'] = (isset($_REQUEST['s']))? $_REQUEST['s'] : "";
		$data['tags'] = (isset($_GET['tags']) )? $_GET['tags']  : "";
		$data['user'] = (isset($_GET['user']) )? $_GET['user']  : "";
		$data['feat'] = (!empty($_GET['feat'])  )? $_GET['feat']  : ""; 
		$data['latest']=(!empty($_GET['latest']))? $_GET['latest']  : ""; 
		$presult 	  = $obj->getSearchVideo($data);
	}

	if(!empty($data['text']))
	{
		$pageKeywords	 	= "serach,find,locate";
		$pageDescription 	= "serach find locate videos from jamaica and over the world.";
		$pageTitle 			= "serach results :: www.videouploader.net";
	}
	elseif(isset($_GET['user']))
	{
		$pageKeywords	 	= "{$_GET['user']}, video area, user listing";
		$pageDescription 	= "video content for {$_GET['user']}, video upload by videouploader.net user {$_GET['user']}";
		$pageTitle 			= "{$_GET['user']} :: www.videouploader.net";
	}
	elseif(isset($_GET['tags']))
	{
		$pageKeywords	 	= "{$_GET['tags']}, videotags, tagging video, video keywords page";
		$pageDescription 	= "video tags listing for videouploader.net, video tag name {$_GET['tags']}";
		$pageTitle 			= "{$_GET['tags']} :: video tags :: www.videouploader.net";
	}
	elseif(isset($_GET['latest']))
	{
		$pageKeywords	 	= "latest videso, newest videos, hot videos";
		$pageDescription 	= "watch the latest videos uploaded on videouploader.net";
		$pageTitle 			= "latest videos :: www.videouploader.net";
	}
	elseif(isset($_GET['feat']))
	{
		$pageKeywords	 	= "featured videos, top videos, hottest, newest videos";
		$pageDescription 	= "the top featured videos on videouploader.net";
		$pageTitle 			= "featured videos :: www.videouploader.net";
	}

	include_once("classes/pagination.class.php");
	$_LIMIT 	= 22;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "page.php?action=search&s={$data['text']}&tags={$data['tags']}&user={$data['user']}&feat={$data['feat']}&latest={$data['latest']}";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$results = $p->getPaginatedResults($presult);

	echo "<h1>";
	echo (!empty($data['text']))? "Search result(s)" : "";
	echo (!empty($_GET['user']))? "Videos from {$_GET['user']}" : "";
	echo (!empty($_GET['tags']))? "Video tag ".str_replace("_", " ",$_GET['tags']) : "";
	echo (!empty($_GET['feat']))? "Featured videos" : "";
	echo (!empty($_GET['latest']))? "Latest videos" : "";
	echo "</h1>";
	echo "<div id=\"pagination\">";
	if( count($presult) > $_LIMIT)
	{						
		$p->cleanPagination(false);
		$p->paginate();
	}
	echo "</div>";
	if(!empty($results))
	{
		mediumVideoList($results);
	}
	else
	{
		echo "<span class='err'>No results found for this search...</span>";
	}
?>