<?php
	include_once("../classes/pagination.class.php");
	include_once("../classes/software.class.php");
	
	$obj = new software();

	$data['sortby'] 		= $_REQUEST['sortby'];
	$data['title'] 			= $_REQUEST['title'];
	$data['category_id'] 	= $_REQUEST['category_id'];
	$data['ord']			= (!empty($_GET['ord']))? $_GET['ord'] : "asc" ;
	$data['acc_id']			= ($_SESSION['admin']['account_type']==1)? $_SESSION['admin']['id'] : "" ;
	
	$presult = $obj->searchNews($data);
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_news&category_id={$data['category_id']}&title={$data['title']}&sortby={$data['sortby']}&ord={$data['ord']}";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
	$category = $obj->getNewsCategory();
	
	if($_POST)
	{
		$rs = $comObj->getDataById("odb_news", $_POST['request_delete'] );
		
		$subject	= "DownloadHours.com :Request to delete news article.";
		$message	= "Request to delete news article [{$rs['title']}] ID [{$rs['id']}]<br>from user [{$_SESSION['admin']['user_name']}] ID [{$_SESSION['admin']['id']}] was submitted.";
		$header  	= 'MIME-Version: 1.0' . "\r\n";
		$header 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header 	.= "From: downloadhours-admin no-reply@downloadhours.com\r\n";
		@mail(EMAIL_ADDRESS, $subject, $message, $header);
		$comObj->logAdminActions("REQUEST TO DELETE NEWS ARTILCE");
		echo "<p class='msg'>Delete request submitted for [{$rs['title']}]..</p>";
	}
?>
<form name="f" method="post" action="">
<table style="border:solid 1px #999999; margin-bottom:5px;">
	<tr><th colspan="4">Filter</th></tr>
	<tr><td><b>Name:</b></td><td><input type="text" name="title" /></td>
		<td>
			<select name="category_id" onchange="document.f.submit();">
				<option value="">Select Category</option>
				<?php
					if(!empty($category))
					{
						foreach($category as $row)
						{
				?>
						<option value="<?php echo $row['id'];?>" <?php echo ($data['category_id']==$row['id'])? "selected" : "" ;?> ><?php echo $row['cat_name'];?></option>
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
<form name="ff" method="post" action="">
<table width="100%">
	<tr><th colspan="4" class="header">News Listing</th></tr>
	<tr>
		<th width="100">&nbsp;</th>
		<th>
			Title
			<a class="asc"  href="<?php echo "index.php?action=list_news&category_id={$data['category_id']}&title={$data['title']}";?>&sortby=title&ord=asc"></a>
			<a class="desc" href="<?php echo "index.php?action=list_news&category_id={$data['category_id']}&title={$data['title']}";?>&sortby=title&ord=desc"></a>
		</th>
		<th>Category</th>
		<th>
			Date Added
			<a class="asc"  href="<?php echo "index.php?action=list_news&category_id={$data['category_id']}&title={$data['title']}";?>&sortby=date_added&ord=asc"></a>
			<a class="desc" href="<?php echo "index.php?action=list_news&category_id={$data['category_id']}&title={$data['title']}";?>&sortby=date_added&ord=desc"></a>
		</th>
	</tr>
<?php	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr>
        	<td nowrap="nowrap">
                <?php if( $_SESSION['admin']['account_type'] == 2 ){ ?>
				[<a href="javascript:deleteThis(<?php echo $row['id'];?>);" >Delete</a>]
				<?php }else{ ?>
                [<a href="javascript:requestdelete(<?php echo $row['id'];?>);" >Delete</a>]
                <?php }?>
				[<a href="index.php?action=add_news&id=<?php echo $row['id'];?>" >Edit</a>]
           </td>
		   <td><?php echo $row['title'] ?></td> 
		   <td><?php echo $row['category'] ?></td>
		   <td><?php echo date("Y/m/d", strtotime($row['date_added']));?></td>
        </tr> 
<?php
		}
	}else{ echo "<tr><td colspan='4' align='center'>No listing found...</td></tr> "; }
?>
<tr>
	<td colspan="4">
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
<input type="hidden" name="request_delete" />
</form>
<script>
<?php if( $_SESSION['admin']['account_type']!=1){ ?>
function deleteThis(id)
{
	if(confirm("Delete this item?"))
	{
		window.location = "includes/delete_news.php?id=" + id;
	}	
}
<?php } ?>
function requestdelete(id)
{
	if(confirm("Request delete for this article."))
	{
		document.ff.request_delete.value = id;
		document.ff.submit();
	}	
}
</script>
<?php $comObj->logAdminActions("View News Listing PAGE:".$page); ?>