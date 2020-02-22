<?php
include_once("classes/pagination.class.php");

$current = "music";
$rs = $_POST;
$presult = $siteObj->searchMP3($rs);

$_LIMIT 	= 5;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "page.php?action=music";
$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$results 	= $p->getPaginatedResults($presult);
?>
<?php 
	if(!empty($results))
	{
		foreach($results as $row)
		{ 
			$artiste = $siteObj->getArtisteByMusic($row['id'])
?>
            <div class="track sample">
                <img alt="<?php echo $row['title'];?>" height="48" width="50" class="thumb" src="<?php echo ARTISTE_IMG_URL.ARTISTE_SML_TMB."_".$row['photo'];?>" />
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
                <span class="credit info">
                    <span class="credit amount"><?php echo $row['credit_amount'];?></span>
                    <span class="credit text">Credits</span>
                </span>
                
                <a class="btn buy" href="javascript:addtocart(<?php echo $row['id'];?>);"><img alt="" src="images/btn_buy.png" /></a>
            </div>
            <!--tr>
                <td><img src="<?php echo ARTISTE_IMG_URL.ARTISTE_SML_TMB."_".$row['photo'];?>" /></td>
                <td>
                   <object type="application/x-shockwave-flash" data="player/player_mp3_maxi.swf" width="25" height="20">
                        <param name="movie" value="player/player_mp3_maxi.swf" />
                        <param name="bgcolor" value="#ffffff" />
                        <param name="FlashVars" value="mp3=<?php echo MP3LOCATION."sample_{$row['id']}.mp3";?>&amp;width=25&amp;autoload=0&amp;showslider=0&amp;showloading=always" />
                    </object>
                </td>
                <td>
                    <h4><?php echo $row['title']." - ".$row['stagename'];?></h4>
                    <h5><?php echo $row['riddim'];?> (<?php echo $row['label'];?>)</h5>
                </td>
                <td><h1><?php echo $row['credit_amount'];?></h1><small>CREDITS</small></td>
                <td><a href="javascript:addtocart(<?php echo $row['id'];?>);" class="addtocart"></a></td>
            </tr-->
<?php 
		} 
	}else{ echo "<tr><td>No results found...</td></tr>";}
?>
 <?php
    if( count($presult) > $_LIMIT)
    {						
        echo "<div class='pagination'>";
        $p->cleanPagination(false);
        $p->paginate();
        echo "</div>";
    }
?>
<script>
function addtocart(id)
{
	$.get("includes/addtocart.php",
			{id:id},
			function(data)
			{
				$("#cartItemCount").html(data);
			}
	)
}
</script>