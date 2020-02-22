<?php	
	include_once("classes/banner.class.php");
	include_once("classes/pagination.class.php");
	
	$bannerObj 		= new banner();
	
	$presult 		= $bannerObj->getVidoeList();
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "party_videos.html?SID=".rand();
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$vidoes = $p->getPaginatedResults($presult);
?>
<h1>Anyweh.com Videos</h1>
<style>
ol#videos{}
ol#videos li{ list-style:none; padding:0; width:150px; height:140px; float:left; margin-left:5px;}
ol#videos li img{ border:solid 1px #333333; width:150px; height:100px;}
ol#videos li span{ font-size:0.8em; text-align:center; display:block;}
ol#videos li span a{ color:#333333;}
</style>
<?php 
	if(!empty($vidoes))
	{
		echo "<ol id='videos'>";
		foreach($vidoes as $row)
		{ 
			$filename 	= explode(".", $row['filename']);
			$filename	= $filename[0];
			$image 		= (fileExists("gallery/albums/videos/images/$filename.jpg"))? "$filename.jpg" : "video_default.jpg";
?>
		<li>
			<a href="video_player.php?id=<?php echo $row['id'];?>" title="anyweh.com video player: <?php echo cleanString($row['title']);?>" ><img src="gallery/albums/videos/images/<?php echo $image;?>" alt="<?php echo cleanString($row['title']);?>" /></a>
			<span><a href="video_player.php?id=<?php echo $row['id'];?>" title="anyweh.com video player: <?php echo cleanString($row['title']);?>" ><?php echo str_replace("_", " ", substr(cleanString($row['title']), 0, 23 ));?></a></span>
		</li>
<?php 
		}
		echo "</ol>";
	} 
?>
<?php
	if( count($presult) > $_LIMIT)
	{
		echo "<div class='pagination' style='clear:left;'>";					
		$p->cleanPagination(false);
		$p->paginate();
		echo "</div>";		
	}
?>