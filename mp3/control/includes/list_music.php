<?php
	include_once("../classes/pagination.class.php");
	include_once("../classes/site.class.php");
		
	$siteObj = new site();
	$presult = $siteObj->getMP3ByProducerId($_SESSION['USER']['id']);
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_music";
	$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$results 	= $p->getPaginatedResults($presult);
	
	if(empty($results)){ echo "<span class='err'>Empty...</span>"; return false; }
?>
<table border="1">
	<tr><th colspan="5" class="header">Your music listing</th></tr>
    <tr>
    	<th>&nbsp;</th>
        <th>Play</th>
        <th>Title</th>
        <th>Date added</th>
        <th>Ready for site</th>
    </tr>
<?php	
$alt = true;
foreach( $results as $row )
{
	$alt 	= ($alt)? false : true;
	$style 	= ($alt)? "rowStyle1" : "rowStyle2";
	
	$readyCss = (file_exists(UPLOADDIR."sample_{$row['id']}.mp3"))? "readyYes" : "readyNo";
?>
    <tr class="<?php echo $style;?>">
        <td nowrap="nowrap">
        <a href="javascript:removeNews('<?php echo base64_encode($row['id']);?>');" title="delete this record." ><img src="../images/icon-delete.gif"></a>
        <a href="index.php?action=edit_music&id=<?php echo $row['id'];?>" title="edit this record." ><img src="../images/application_edit.png"></a>
        </td>
        <td>
        <?php if($readyCss=="readyYes"){ ?>
        <object type="application/x-shockwave-flash" data="../player/player_mp3_maxi.swf" width="100" height="20">
            <param name="movie" value="../player/player_mp3_maxi.swf" />
            <param name="bgcolor" value="#ffffff" />
            <param name="FlashVars" value="mp3=<?php echo MP3LOCATION."sample_{$row['id']}.mp3";?>&amp;width=100&amp;autoload=0&amp;showvolume=0&amp;showloading=always" />
        </object>
        <?php } ?>
        </td>
        <td><?php echo cleanString($row['title']);?></td>
        <td><?php echo date("d-M-Y", strtotime($row['date_added']));?></td>
        <td><span class="<?php echo $readyCss;?>"></span></td>
    </tr>
<?php
}
?>
    <tr>
        <td colspan="5">
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
<script>
function removeNews(id)
{
	if(confirm("Are you sure you want to delete this record?"))
	{
		window.location = "index.php?action=delete_music&id=" + id;
	}	
}
</script>