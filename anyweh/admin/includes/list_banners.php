<?
	include_once("../classes/banner.class.php");
	include_once("../classes/image_resize.php");
	include_once("../classes/pagination.class.php");
	
	$bannerObj = new banner();
	
	$presult = $bannerObj->getBannerList();
	
	$_LIMIT 	= 10;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_banners";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$banners = $p->getPaginatedResults($presult);
	
	if(empty($banners))
	{
		echo "<h1 class='header'>No banners found.</h1>";
		return;
	} 
?>
<h1 class='header'>banners.</h1>
<table border="1">
<tr><th class="lable">Edit</th><th class="lable">Info</th><th class="lable">Banner</th><th class="lable" width="1">Delete</th></tr>
    <tr>
        <td colspan="4" class="pagination">
            <?
                if( count($presult) > $_LIMIT)
                {						
                    $p->cleanPagination(false);
                    $p->paginate();
                }
            ?>
        </td>
    </tr>
<? 
	foreach($banners as $row)
	{ 
?>
  <tr>
  	<td>[<a href="index.php?action=add_banner&type=<?=$row['bannerType']?>&id=<?=$row['id']?>">Edit</a>]</td>
    <td><?=cleanString($row['detail'])?></td>
    <td><a href="index.php?action=add_banner&type=<?=$row['bannerType']?>&id=<?=$row['id']?>"><img src="../<?=BANNER_THUM_FOLDER.$row['banner']?>" height="90" border="0" /></a></td>
    <td><a href="javascript:delRecord(<?=$row['id']?>, '<?=base64_encode($row['banner'])?>'); " ><img src="images/delete.png" alt="Delete this image." title="Delete this image..." border="0" /></a></td>
  </tr>
<? 
	}
?>
    <tr>
        <td colspan="4" class="pagination">
            <?
                if( count($presult) > $_LIMIT)
                {						
                    $p->cleanPagination(false);
                    $p->paginate();
                }
            ?>
        </td>
    </tr>
</table>

<script language="javascript">
function delRecord(id, img)
{
	if(confirm("Are you sure you want to delete this record?"))
	{
		window.location = "includes/delete_banner.php?id=" + id + "&file=" + img;
	}
}
</script>
