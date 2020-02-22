<script src="../js/jquery_tabs.js"></script>
<style>
/* accordion header */
#accordion h2 {cursor:pointer;}
/* currently active header */
#accordion h2.current {
	cursor:default;
	background-color:#fff;
}
/* accordion pane */
#accordion .pane {
	display:none;
}
</style>
<?php
include_once("../classes/report.class.php");
include_once("../classes/pagination.class.php");

$repObj 	= new report();
$opt 		= (isset($_GET['report']))? $_GET['report'] : NULL;
$presult 	= $repObj->getReportByProducer();

$_LIMIT 	= 20;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "index.php?action=sales_report_artist";
$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
$results = $p->getPaginatedResults($presult);
?>
<div id="accordion">
<?php
if(!empty($results))
{
	$i=0;
	foreach($results as $rs)
	{
		if($i==0)
		{
			$class = "class='current'"; 
			$style = "style='display:block'";
		}
		else
		{ 
			$class = ""; $style = ""; 
		}
?>
		<h2 <?php echo $class;?>><?php echo $rs['stagename'];?></h2>
<?php
		$report = $repObj->getReportByArtisteId($rs['id']);	
		if(!empty($report))
		{
			$alt = true;
			echo "<div class='pane' $style><table>";
			echo "<tr>
					<th>Name</th>
					<th>Purchase date/time</th>
					<th>Title</th>
					<th>Credit amount</th>
				</tr>";
			foreach($report as $row)
			{
				$alt 	= ($alt)? false : true;
				$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
                <tr class="<?php echo $style;?>">
                    <td><a href="index.php?action=account_info&id=<?php echo $row['cid'];?>"><?php echo $row['fname'];?></a></td>
                    <td><?php echo date("M/j/Y H:i:s", strtotime($row['transaction_date']));?></td>
                    <td><?php echo $row['title'];?></td>
                    <td><?php echo $row['credit_amount'];?></td>
                </tr>
<?php 
			}
			echo "</table></div>";
			$i++;
		}
		else
		{
			echo "<div class='pane' align='center'>No purchases found for this artise.</div>";
		}
	}
}
?>
</div>
<?php if( count($presult) > $_LIMIT){ ?><tr><td colspan="2"><?php $p->cleanPagination(false);$p->paginate();?></td></tr><?php }?>

<script>
$(function(){ 
$("#accordion").tabs("#accordion div.pane", {tabs: 'h2', effect: 'slide', initialIndex: null});
});
</script>