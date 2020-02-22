<?php
	$current = "my_music";
	include_once("classes/pagination.class.php");
	$id = $_GET['id'];
	$presult = $siteObj->getPurchaseItem(base64_decode($id));
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=purchase_record&id=$id";
	$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$result 	= $p->getPaginatedResults($presult);
?>

<?php foreach($result as $row){?>
<div class="track sample">
	<img alt="<?php echo $row['title'];?>" height="48" width="50" class="thumb" src="<?php echo (empty($row['photo']))? ARTISTE_IMG_URL.'default.png' : ARTISTE_IMG_URL.ARTISTE_SML_TMB."_".$row['photo'];?>" />
	<a href="#" class="play">
	<object type="application/x-shockwave-flash" data="player/player_mp3_maxi.swf" width="25" height="20">
		<param name="movie" value="player/player_mp3_maxi.swf" />
		<param name="bgcolor" value="#ffffff" />
		<param name="FlashVars" value="mp3=<?php echo MP3LOCATION."sample_{$row['id']}.mp3";?>&amp;width=25&amp;autoload=0&amp;showslider=0&amp;showloading=always" />
	</object>
	</a>
	<span class="track info">
		<span class="track title"><?php echo $row['title'];?></span>
		<span class="track sub-title"><?php echo $row['riddim'];?> (<?php echo $row['producerfname'];?>)</span>
	</span>
	<span class="credit info">&nbsp;</span>
	
	<a class="btn buy" href="#">Download</a>
</div>
<?php }?> 

