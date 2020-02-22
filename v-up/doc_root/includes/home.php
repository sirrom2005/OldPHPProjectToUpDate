<?php
	$featured = $obj->getFeaturedVideo(3);
	$latestVideo = $obj->getLatestVideo(12);
	if(!empty($featured))  
	{
		echo "<h1><a href='page.php?action=search&feat=1'>Featured videos</a></h1>";
		largeVideoList($featured);
	}
	if(!empty($latestVideo))
	{
		echo "<h1><a href='page.php?action=search&latest=1'>Latest videos</a></h1>";
		mediumVideoList($latestVideo);
	}
?>