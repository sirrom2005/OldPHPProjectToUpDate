<?php
	include_once("classes/pagination.class.php");
	
	$rs = $_POST;
	$presult = $siteObj->searchMP3($rs);
	
	$_LIMIT 	= 10;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=browse";
	$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$results 	= $p->getPaginatedResults($presult);
?>
<table>
<?php 
	if(!empty($results))
	{
		foreach($results as $row)
		{ 
			$artiste = $siteObj->getArtisteByMusic($row['id'])
?>
        <tr>
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
            <!--td>
                /*if(!empty($artiste))
                {
                    foreach($artiste as $key => $value)
                    {
                        echo $value." ";
                    }
                }*/
                ?>
            </td-->
            <td><h1><?php echo $row['credit_amount'];?></h1><small>CREDITS</small></td>
            <td><a href="javascript:addtocart(<?php echo $row['id'];?>);" class="addtocart"></a></td>
        </tr>
<?php 
		} 
	}else{ echo "<tr><td>No results found...</td></tr>";}
?>
    <?php if( count($presult) > $_LIMIT){ ?>
	<tr>
        <td colspan="5" class="pagination">
		<?php $p->cleanPagination(false); $p->paginate(); ?>
        </td>
    </tr>
    <?php } ?>
</table>
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