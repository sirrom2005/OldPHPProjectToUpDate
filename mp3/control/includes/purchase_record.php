<?php
	include_once("../classes/pagination.class.php");
	include_once("../classes/site.class.php");
	$siteObj = new site();
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
<table>
	<tr><th colspan="3" class="header">Your music listing</th></tr>
<?php	
$alt = true;
foreach($result as $row){
$alt 	= ($alt)? false : true;
$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
    <tr class="<?php echo $style;?>">
        <td>
        <object type="application/x-shockwave-flash" data="../player/player_mp3_maxi.swf" width="130" height="20">
            <param name="movie" value="../player/player_mp3_maxi.swf" />
            <param name="bgcolor" value="#ffffff" />
            <param name="FlashVars" value="mp3=<?php echo MP3LOCATION.$row['filename'];?>&amp;width=130&amp;autoload=1&amp;showvolume=1&amp;showloading=always" />
        </object>
        </td>
        <td><?php echo cleanString($row['title']);?></td>
        <td><a href="#" title="Download"><img src="../images/icon_brands.png" /></a></td>
    </tr>
<?php
}
?>
    <tr>
        <td colspan="3" class="pagination">
            <?php
                if( count($presult) > $_LIMIT)
                {						
                    $p->cleanPagination(false);
                    $p->paginate();
                }
            ?>
        </td>
    </tr>
</table>