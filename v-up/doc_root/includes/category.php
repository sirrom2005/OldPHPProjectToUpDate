<?php
	echo "<h1>$categoryName</h1>";
	if(!empty($categoryList))
	{
		mediumVideoList($categoryList);
	}
	else
	{
		echo "<span class='msg'>No videos found for this category...</span>";
	}
?>

