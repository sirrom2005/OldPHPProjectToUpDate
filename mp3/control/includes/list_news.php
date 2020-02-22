<?php
	include_once("../classes/pagination.class.php");
		
	$presult = $comObj->getData("odb_news",NULL,"date_added","DESC");
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_news";
	$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$results 	= $p->getPaginatedResults($presult);
	
	if(empty($results)){ echo "<span class='err'>No news listing found...</span>"; return false; }
?>
<table>
	<tr><th colspan="3" class="header">News listing</th></tr>
<?php	
$alt = true;
foreach( $results as $row ){
$alt 	= ($alt)? false : true;
$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
    <tr class="<?php echo $style;?>">
        <td>
        <a href="javascript:removeNews(<?php echo $row['id'] ?>); " ><img src="../images/icon-delete.gif"></a>
        <a href="index.php?action=add_news&id=<?php echo $row['id'] ?>" ><img src="../images/application_edit.png"></a>
        </td>
        <td><?php echo cleanString($row['title']);?></td>
        <td><?php echo date("d-M-Y", strtotime($row['date_added']));?></td>
    </tr>
<?php
}
?>
<?php
	if( count($presult) > $_LIMIT)
	{ 
		echo "<tr><td colspan='3' class='pagination'>";
		$p->cleanPagination(false); $p->paginate();
		echo "</td></tr>";
	}
?>  
</table>
<script>
function removeNews(id)
{
	if(confirm("Are you sure you want to delete this record?"))
	{
		window.location = "index.php?action=delete_news&id=" + id;
	}	
}
</script>