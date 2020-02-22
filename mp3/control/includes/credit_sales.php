<?php
	include_once("../classes/pagination.class.php");
		
	$presult = $siteObj->getTransaction();
	
	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=list_riddims";
	$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$results 	= $p->getPaginatedResults($presult);
	
	if(empty($results)){ echo "<span class='err'>No transaction found...</span>"; return false; }
?>
<table>
	<tr><th colspan="2" class="header"> </th></tr>
    <tr>
    	<th>&nbsp;</th>
        <th>Date</th> 
        <th>Client</th>
        <th>Status</th>
        <th>Credit amount</th>
        <th>Amount</th>
        <th>ip-address</th>
        <th>Transaction code</th>
        <th>Order Id</th>
    </tr>
<?php	
$alt = true;
foreach( $results as $row ){
$alt 	= ($alt)? false : true;
$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
    <tr class="<?php echo $style;?>">
        <td><a href="javascript:removeNews(<?php echo $row['id'] ?>); " ><img src="../images/icon-delete.gif"></a></td>
        <td><?php echo cleanString($row['trans_date']);?></td> 
        <td><?php echo cleanString($row['fname']." ".$row['lname']);?></td>
        <td><?php echo cleanString($row['trans_states']);?></td>
        <td><?php echo cleanString($row['credit_amount']);?></td>
        <td><?php echo number_format($row['amount'], 2, ".", ",");?></td>
        <td><?php echo cleanString($row['ipaddress']);?></td>
        <td><?php echo cleanString($row['transaction_code']);?></td>
        <td><?php echo cleanString($row['order_id']);?></td>
    </tr>
<?php
}
?>
    <tr>
        <td colspan="2" class="pagination">
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
function removeNews(id)
{
	if(confirm("Are you sure you want to delete this record?"))
	{
		window.location = "index.php?action=delete_riddims&id=" + id;
	}	
}
</script>