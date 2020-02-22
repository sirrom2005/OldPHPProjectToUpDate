<?php
	include_once("../classes/events.class.php");
	include_once("../classes/pagination.class.php");
	
	$eventsObj = new events();
		
	$presult = $eventsObj->getEventsListing();
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_events";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
?>
<table width="95%">
	<tr><th colspan="2" class="header">Event Listing</th></tr>
    <tr>
        <td colspan="3" class="pagination">
            <?
                if( count($presult) > $_LIMIT)
                {						
                    $p->cleanPagination(false);
                    $p->paginate();
                }
            ?>
        </td>
    </tr>
<?	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr><th>Title</th><td><?=cleanString($row['title'])?></td></tr>
        <tr><th>Date</th><td><?=$row['date'] ?></td></tr>
        <tr><th>Description</th><td><?=cleanString($row['description']) ?></td></tr>
		<tr><th>Free Post</th><td><?=(empty($row['free_post']))? "No" : "Yes"; ?></td></tr>
        <tr>
        	<th>&nbsp;</th>
        	<td>
            	[<a href="index.php?action=add_events&id=<?=$row['id'] ?>" >Edit</a>]&nbsp;
                [<a href="javascript:removeEvents(<?=$row['id']?>, '<?=base64_encode($row['banner'])?>'); " >Delete</a>]
           </td>
        </tr> 
        <tr><td colspan="2">&nbsp;</td></tr> 
<?
		}
	}else{ echo "<tr><td colspan='2' align='center'>No listing found...</td></tr> "; }
?>
    <tr>
        <td colspan="3" class="pagination">
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
function removeEvents(id, file)
{
	if(confirm("Are you sure you want to delete this record?"))
	{
		window.location = "includes/delete_event.php?id=" + id + "&file=" + file;
	}	
}
</script>