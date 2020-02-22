<?php
	include_once("../classes/pagination.class.php");
	include_once("../classes/software.class.php");
	
	$obj = new software();
	
	$data['section'] 	= $_REQUEST['section'];
	$data['ord'] 		= $_REQUEST['ord'];
	$data['sortby'] 	= $_REQUEST['sortby'];
	$data['text'] 		= $_REQUEST['text']; 
	
	$presult = $obj->searchReviews($data);
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_reviews&text={$data['text']}&section={$data['section']}&sortby={$data['sortby']}&ord={$data['ord']}";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
?>
<form name="f" method="post" action="">
<table style="border:solid 1px #999999; margin-bottom:5px;">
	<tr><th colspan="4">Filter</th></tr>
	<tr><td><b>Search text:</b></td><td><input type="text" name="text" /></td>
		<td>
			<select name="section" onchange="document.f.submit();">
				<option value="">Select Category</option>
				<option value="1" <?php echo ( $data['section'] == 1 )? "selected" : "" ;?> >Software</option>
				<option value="2" <?php echo ( $data['section'] == 2 )? "selected" : "" ;?> >News</option>
			</select>
		</td>
		<td align="right"><input type="submit" value="Search" /></td>
	</tr>
</table>
</form>
<table width="95%">
	<tr><th colspan="6" class="header">List Reviews</th></tr>
	<tr>
		<th class="header">&nbsp;</th>
		<th class="header">
			Name
			<a class="asc"  href="<?php echo "index.php?action=list_reviews&section={$data['section']}";?>&sortby=name&ord=asc"></a>
			<a class="desc" href="<?php echo "index.php?action=list_reviews&section={$data['section']}";?>&sortby=name&ord=desc"></a>
		</th>
		<th class="header">Comment</th>
		<th class="header" width="30">Section</th>
		<th class="header" width="30" nowrap="nowrap">
			Enabled
			<a class="asc"  href="<?php echo "index.php?action=list_reviews&section={$data['section']}";?>&sortby=enable&ord=asc"></a>
			<a class="desc" href="<?php echo "index.php?action=list_reviews&section={$data['section']}";?>&sortby=enable&ord=desc"></a>
		</th>
		<th class="header" width="120">
			Date added
			<a class="asc"  href="<?php echo "index.php?action=list_reviews&section={$data['section']}";?>&sortby=date_added&ord=asc"></a>
			<a class="desc" href="<?php echo "index.php?action=list_reviews&section={$data['section']}";?>&sortby=date_added&ord=desc"></a>
		</th>
	</tr>
<?php	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr>
			<th width="100">
				[<a href="index.php?action=add_review&id=<?php echo $row['id'];?>" >Edit</a>]
				[<a href="javascript:deleteThis('Review For -<?php echo $row['name']?>-', <?php echo $row['id'];?>);" >Delete</a>]
			</th>
			<td width="90"><?php echo $row['name'] ?></td>
			<td><?php echo cleanString($row['comment']);?></td>
			<td><?php echo ($row['section']==1)? "Software" : "News" ;?></td>
			<td><?php echo (empty($row['enable']))? "No" : "Yes" ; ?></td>
			<td><?php echo $row['date_added'] ?></td>
		</tr>
<?php
		}
	}else{ echo "<tr><td colspan='6' align='center'>No listing found...</td></tr> "; }
?>
<tr>
	<td colspan="6">
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
		window.location = "includes/delete_review.php?id=" + id;
	}	
}
</script>
<?php $comObj->logAdminActions("View Reviews Listing"); ?>