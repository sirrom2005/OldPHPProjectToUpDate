<?php
include_once("../classes/pagination.class.php");
	
$presult = $siteObj->getCreditPurchase();

$_LIMIT 	= 20;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "index.php?action=credit_purchase";
$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$results 	= $p->getPaginatedResults($presult);

if(empty($results)){ echo "<span class='err'>list is empty...<span>"; return false; }
?>
<table>
<tr>
    <th>Client</th>
    <th>date</th>
    <th>Status</th>
    <th>Credit</th>
    <th>Cost</th>
    <th>Transaction code</th>
    <th>Order id</th>
    <th>ip-address</th>
</tr>
<?php 
	$alt = true;
	foreach($results as $row){ 
	$alt 	= ($alt)? false : true;
	$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
	<tr class="<?php echo $style;?>">
    	<td><?php echo cleanString($row['fullname']); ?></td>
    	<td><?php echo date("M-d-Y", strtotime($row['trans_date']));?></td>
    	<td><?php echo cleanString($row['trans_states']); ?></td>
    	<td><?php echo cleanString($row['credit_amount']); ?></td>
        <td><?php echo cleanString($row['amount']); ?></td>
        <td><?php echo cleanString($row['transaction_code']); ?></td>
        <td><?php echo cleanString($row['order_id']); ?></td>
    	<td><?php echo cleanString($row['ipaddress']); ?></td>
    </tr>
<?php } ?>
<?php
	if( count($presult) > $_LIMIT)
	{ 
		echo "<tr><td colspan='3' class='pagination'>";
		$p->cleanPagination(false); $p->paginate();
		echo "</td></tr>";
	}
?>  
</table>