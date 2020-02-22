<?php
	include_once("../classes/software.class.php");
	include_once("../classes/pagination.class.php");
	
	$obj = new software();
	
	$data['sortby'] = $_REQUEST['sortby']; 
	$data['banner_type'] = $_REQUEST['banner_type']; 
	$data['ord']	= (!empty($_GET['ord']))? $_GET['ord'] : "asc" ;
	
	$presult = $obj->getBanner($data);

	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_banners&sortby={$data['sortby']}&ord={$data['ord']}";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
	$adsType = $comObj->getData( "odb_ads_type", NULL, "id", "ASC" );
?>
<form name="f" method="post" action="">
<table style="border:solid 1px #999999; margin-bottom:5px;">
	<tr><th colspan="4">Filter</th></tr>
	<tr>
		<td>
		<select name="banner_type" onchange="document.f.submit();">
			<option value="">Select Category</option>
		<?php foreach($adsType as $row){?> 
			<option value="<?php echo $row[id];?>" <?php echo ($data['banner_type']==$row[id])? "selected" : "";?> ><?php echo $row['size'];?> - <?php echo (empty($row['rotating']))? "None Rotating Banner" : "Rotating Banner";?> </option>
		<?php } ?> 
		</select>
		</td>
	</tr>
</table>
</form>
<table width="95%">
	<tr><th colspan="8" class="header">Banner Listing</th></tr>
	<tr>
		<th width="100">&nbsp;</th>
		<th>
			Advertiser
			<a class="asc"  href="<?php echo "index.php?action=list_banners";?>&sortby=advertiser&ord=asc"></a>
			<a class="desc" href="<?php echo "index.php?action=list_banners";?>&sortby=advertiser&ord=desc"></a>
		</th>
		<th>Size</th>
		<th>Website url</th>
		<th>
			Date added
			<a class="asc"  href="<?php echo "index.php?action=list_banners";?>&sortby=date_added&ord=asc"></a>
			<a class="desc" href="<?php echo "index.php?action=list_banners";?>&sortby=date_added&ord=desc"></a>
		</th>
		<th>Enabled</th>
	</tr>
<?php	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr>
			<td>
				[<a href="index.php?action=add_banner&id=<?php echo $row['id'];?>" >Edit</a>]
                [<a href="javascript:deleteThis('Banner for -<?php echo $row['advertiser']?>-', <?php echo $row['id'];?>);" >Delete</a>]
			</td>
			<td><?php echo $row['advertiser'] ?></td>
			<td><?php echo $row['size'] ?></td>
			<td><?php echo $row['website'] ?></td>
			<td><?php echo $row['date_added'] ?></td>
			<td><?php echo $row['enable'] ?></td>
		</tr>
<?php
		}
	}else{ echo "<tr><td colspan='8' align='center'>No listing found...</td></tr> "; }
?>
<tr>
	<td colspan="8">
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
<script>
function deleteThis(str, id)
{
	if(confirm("Delete :: ["+str+"] ?"))
	{
		window.location = "includes/delete_banner.php?id=" + id;
	}	
}
</script>
<?php $comObj->logAdminActions("View Ads Banner Listing"); ?>