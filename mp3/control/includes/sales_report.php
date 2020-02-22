<?php
include_once("../classes/report.class.php");
include_once("../classes/pagination.class.php");

$repObj 	= new report();

$presult 	= $repObj->getReport($_SESSION['USER']['id']);

$_LIMIT 	= 10;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "index.php?action=sales_report";
$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$results = $p->getPaginatedResults($presult);
?>
<table>
<tr class="<?php echo $style;?>">
    <td>Client</td>
    <td>Music title</td>
    <td>Transaction date</td>
    <td>Credit amount</td>
</tr> 
<?php
if(!empty($results))
{
	$alt = true;
	foreach($results as $row)
	{
		$alt 	= ($alt)? false : true;
		$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
        <tr class="<?php echo $style;?>">
            <td><?php echo $row['fullname'];?></td>
            <td><?php echo $row['title'];?></td>
            <td><?php echo date("D, M d Y", strtotime($row['date']));?></td>
            <td><?php echo $row['credit_amount'];?></td>
        </tr> 
<?php 
	}
}else{ echo "<tr><td colspan='5' align='center'>No transaction now.</td></tr>";}
?>
<?php if( count($presult) > $_LIMIT){ ?><tr><td colspan="4"><?php $p->cleanPagination(false);$p->paginate(); ?></td></tr><?php }?>
</table>