<?php
	include_once("classes/pagination.class.php");
	
	$rs = $_POST;
	$presult = $siteObj->searchMP3($rs);
	
	$_LIMIT 	= 2;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=search";
	$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$results 	= $p->getPaginatedResults($presult);
?>
<table>
	<tr>
    	<th>&nbsp;</th>
        <th>artise</th>
        <th>riddim</th>
        <th>song name</th>
        <th>label</th>
    </tr>
<?php 
	if(!empty($results))
	{
		foreach($results as $row)
		{ 
			$artiste = $siteObj->getArtisteByMusic($row['id'])
?>
        <tr>
            <td>play</td>
            <td>
                <?php
                if(!empty($artiste))
                {
                    foreach($artiste as $key => $value)
                    {
                        echo $value." ";
                    }
                }
                ?>
            </td>
            <td><?php echo $row['riddim'];?></td>
            <td><?php echo $row['title'];?></td>
            <td><?php echo $row['label'];?></td>
        </tr>
<?php 
		} 
	}else{ echo "<tr><td>No results found...</td></tr>";}
?>
    <tr>
        <td colspan="5" class="pagination">
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