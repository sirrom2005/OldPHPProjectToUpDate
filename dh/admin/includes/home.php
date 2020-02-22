<?php	
	if($_SESSION['admin']['account_type'] == 2)
	{
		include_once("../classes/admin.class.php");
		$adminObj 				= new admin();
		$softwareToEnableCount 	= $adminObj->softwareToEnableCount();
		$featuredSoftwareCount 	= $adminObj->featuredSoftwareCount();
		$memberCount 			= $adminObj->getMemberCount();
		$publisherCount 		= $adminObj->getPublisherCount();
		$reviewCount 			= $adminObj->getReviewCount(); 
		$newsReviewCount 		= $adminObj->getNewsReviewCount(); 
?>
<ul class="adminlist">
	<li><a href="index.php?action=list_items&enable=1">(<?php echo $softwareToEnableCount['cnt']?>) Software to review/enable</a></li>
	<li><a href="index.php?action=list_items&featured=1">(<?php echo $featuredSoftwareCount['cnt']?>) Featured Software</a></li>
	<li><a href="index.php?action=list_users&category=3">(<?php echo $memberCount['cnt']?>) Members</a></li>
	<li><a href="index.php?action=list_users&category=4">(<?php echo $publisherCount['cnt']?>) Software Publisher</a></li>
	<li><a href="index.php?action=list_reviews&section=1">(<?php echo $reviewCount['cnt']?>) Software to review/enable</a></li>
	<li><a href="index.php?action=list_reviews&section=2">(<?php echo $newsReviewCount['cnt']?>) News to review/enable</a></li>
</ul>
<?php }else{ ?>
<h1 align="center">Home</h1>
<?php } ?>