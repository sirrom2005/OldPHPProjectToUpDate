<?php
	include_once("../classes/pagination.class.php");
	
	$presult = $comObj->getData("odb_content", NULL);
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_news";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
?>
<table width="100%">
	<tr><th colspan="2" class="header">Content Page Listing</th></tr>
	<tr><th width="30">&nbsp;</th><th>Title</th></tr>
<?php	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr>
        	<td>[<a href="index.php?action=add_page&id=<?php echo $row['id'];?>" >Edit</a>]</td>
			<td><?php echo $row['title'] ?></td>
        </tr> 
<?php
		}
	}else{ echo "<tr><td colspan='2' align='center'>No listing found...</td></tr> "; }
?>
<tr>
	<td colspan="2">
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
<?php $comObj->logAdminActions("View Content page Listing"); ?>