<?php
	$result = $siteObj->getPageContent($_GET['p']);
	$current = $_GET['p'];
	$title = $result['title'];
?>
<div><?php echo $result['detail'];?></div>