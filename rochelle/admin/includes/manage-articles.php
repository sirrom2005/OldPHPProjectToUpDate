<?php
	include_once('../classes/pagination.class.php');
	$sql = "SELECT * FROM articles ORDER BY date_added DESC";
	$presult = $obj->exeSql($sql);
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "?p=manage-articles&s=y";
	$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$results 	= $p->getPaginatedResults($presult);
?>
<a href="?p=add-article" class="button add right">Add Article</a>
<h1>Manage Articles</h1>
<table id="tabledata">
	<tr>
    	<th>Title</th>
        <th>Summary</th>
        <th>Author</th>
        <th>Date-added</th>
        <th width="50">&nbsp;</th>
    </tr>
    <tbody>
    <?php 
		if(!empty($results)){ 
			$alt = true;
			foreach($results as $row)
			{
				$alt = ($alt)? false : true;
				$rowCss = ($alt)? 'rowstyle1' : '';
				
	?>
    <tr class="<?php echo $rowCss;?>">
    	<td><?php echo cleanString($row['title']);?></td>
        <td><?php echo cleanString($row['detail']);?></td>
        <td><?php echo $row['user_id'];?></td>
        <td><?php echo date('Y-m-d', strtotime($row['date_added'])) ;?></td>
        <td nowrap="nowrap"><a href="?p=add-article&id=<?php echo $row['id'];?>" class="edit button" title="edit this record">Edit</a><a href="#<?php echo $row['id'];?>" class="del button" title="delete this record" onclick="dele(<?php echo $row['id'];?>)">Delete</a></td>
    </tr>
    <?php 
			}
		} 
	?>
    </tbody>
    <tfoot>
    <tr>
    	<td colspan="5"><?php if( count($presult) > $_LIMIT){ $p->cleanPagination(false); $p->paginate(); } ?></td>
    </tr>
    </tfoot>
</table>

<script language="javascript">
function dele(id)
{
	if(confirm('You are about to delete this record.'))
	{
		window.location = '?p=add-article&id=' + id + '&d=t';
	}
}
</script>