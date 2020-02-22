<?php
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
<tr><th class="lable">Banner Type</th><th>URL</th><th>Banner</th><th width="1" class="lable">&nbsp;</th></tr>
    <tr>
        <td colspan="4" class="pagination">
            <?php
                if( count($presult) > $_LIMIT)
                {						
                    $p->cleanPagination(false);
                    $p->paginate();
                }
            ?>
        </td>
    </tr>
<?php 
	foreach($banners as $row)
	{ 
		$logo_type	= $row['banner_file_type'];
		$ext 		= str_replace("image/", "", $logo_type);
		$imgname 	= "../images/tmp_ads/{$row['id']}_{$row['banner_size']}.$ext";
?>
  <tr>
    <td><?php echo $row['name'];?></td>
	<td><?php echo $row['url'];?></td>
    <td><img src="<?php echo $imgname;?>"/></td>
    <td><a href="javascript:delRecord(<?php echo $row['id']?>, '<?php echo base64_encode($imgname);?>'); " ><img src="images/delete.png" alt="Delete this image." title="Delete this image..." border="0" /></a></td>
  </tr>
<?php 
	}
?>
    <tr>
        <td colspan="4" class="pagination">
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

<script language="javascript">
function delRecord(id, img)
{
	if(confirm("Are you sure you want to delete this record?"))
	{
		window.location = "includes/delete_banner.php?id=" + id + "&file=" + img;
	}
}
</script>
