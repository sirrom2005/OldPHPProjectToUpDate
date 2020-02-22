<?php
	include_once("../classes/pagination.class.php");
	include_once("../classes/report.class.php");
	$reportObj = new report();

	$presult = $reportObj->getUserPaymentHistory($_SESSION['USER']['id']);

	$_LIMIT 	= 20;
	$page 		= $_GET['page'];	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
	
	$paginationUrl = "index.php?action=payment_report";
	$p 			= new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	$result 	= $p->getPaginatedResults($presult);
?>

<table>
<tr class="<?php echo $style;?>">
    <td>Date</td>
    <td>Credit Amount</td>
</tr> 
<?php
if(!empty($result))
{
	$alt = true;
	foreach($result as $row)
	{
		$alt 	= ($alt)? false : true;
		$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
        <tr class="<?php echo $style;?>">
            <td><?php echo date("d F, Y", strtotime($row['payment_date_period'])) ;?></td>
            <td><?php echo $row['credit_total'];?></td>
        </tr> 
<?php 
	}
}else{ echo "<tr><td colspan='5' align='center'>You have no payment history.</td></tr>";}
?>
<?php if( count($presult) > $_LIMIT){ ?><tr><td colspan="4"><?php $p->cleanPagination(false);$p->paginate(); ?></td></tr><?php }?>
</table>