<?php
	include_once("../classes/software.class.php");
	include_once("../classes/pagination.class.php");
	
	$softObj = new software();
	
	$data['name'] 		= $_REQUEST['name'];
	$data['category'] 	= $_REQUEST['category']; 
	$data['enable'] 	= $_REQUEST['enable'];
	$data['featured'] 	= $_REQUEST['featured'];
	$data['ord']		= (!empty($_GET['ord']))? $_GET['ord'] : "" ;
	
	if($_POST['category']){ $_GET['page'] = NULL ;}
	
	$category 	= $softObj->getCategory(20);
	$presult 	= $softObj->searchSoftware($data);

	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_items&ord={$data['ord']}&name={$data['name']}&category={$data['category']}&enable={$data['enable']}&featured={$data['featured']}";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
?>
<form name="f" method="post" action="">
<table style="border:solid 1px #999999; margin-bottom:5px;">
	<tr><th colspan="4">Filter</th></tr>
	<tr><td><b>Name:</b></td><td><input type="text" name="name" /></td>
		<td>
			<select name="category" onchange="document.f.submit();">
				<option value="">Select Category</option>
				<?php
					if(!empty($category))
					{
						foreach($category as $row)
						{
				?>
						<option value="<?php echo $row['ceo_url_category'];?>" <?php echo ($data['category']==$row['ceo_url_category'])? "selected" : "" ;?> ><?php echo $row['category'];?></option>
				<?php
						}
					}
				?>
			</select>
		</td>
		<td align="right"><input type="submit" value="Search" /></td>
	</tr>
</table>
</form>
<table width="100%">
	<tr><th colspan="5" class="header">Software Listing</th></tr>
	<tr>
		<th width="110">&nbsp;</th>
		<th>
			Title
			<a class="asc"  href="index.php?action=list_items&ord=asc<?php  echo "&name={$data['name']}&category={$data['category']}";?>"></a>
			<a class="desc" href="index.php?action=list_items&ord=desc<?php echo "&name={$data['name']}&category={$data['category']}";?>"></a>
		</th>
		<th>Category</th>
		<th>Enabled</th>
		<th>Featured</th>
	</tr>
<?php	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr>
			<td>
                [<a href="javascript:deleteThis('-<?php echo $row['name']?>-', <?php echo $row['id'];?>);" >Delete</a>]
				[<a href="index.php?action=add_item&id=<?php echo $row['id'];?>" >Update</a>]
           </td>
			<td><?php echo $row['name'] ?></td>
			<td><?php echo $row['category'] ?></td>
			<td><?php echo $row['enable'] ?></td>
			<td><?php echo $row['featured'] ?></td>
		</tr>
<?php
		}
	}else{ echo "<tr><td colspan='5' align='center'>No listing found...</td></tr> "; }
?>
<tr>
	<td colspan="5">
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
		window.location = "includes/delete_item.php?id=" + id;
	}	
}
</script>
<?php $comObj->logAdminActions("View Software Listing PAGE:".$page); ?>