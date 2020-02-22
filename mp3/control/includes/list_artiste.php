<?php
	include_once("../classes/pagination.class.php");
	
	$presult = $comObj->getData("odb_artistes",NULL,"stagename","ASC");
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_artiste";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$results = $p->getPaginatedResults($presult);
	if(empty($results)){ echo "<span class='err'>List is empty...<span>"; return false; }
?>
<table>
<tr><th colspan="4" class="header">Artiste/Producer list</th></tr>
<?php	
$alt = true;
foreach( $results as $row ){
$alt 	= ($alt)? false : true;
$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
    <tr class="<?php echo $style;?>">
		<td>
        <a href="javascript:deleteThis(<?php echo $row['id'] ?>); " ><img src="../images/icon-delete.gif"></a>
        <a href="index.php?action=add_artiste&id=<?php echo $row['id'] ?>" ><img src="../images/application_edit.png"></a>
       	</td>
        <td><img src="<?php echo ARTISTE_IMG_URL.ARTISTE_SML_TMB."_".$row['photo'];?>" /></td>
       	<td><?php echo "{$row['stagename']}";?></td> 
       	<td width="110"><?php echo date("d-M-Y", strtotime($row['date_added']));?></td>
    </tr> 
<?php
}
?>
<tr>
	<td colspan="4">
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
<script>
function deleteThis(id)
{
	if(confirm("Delete this record?"))
	{
		window.location = "index.php?action=delete_artise&id=" + id;
	}	
}
</script>