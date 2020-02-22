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
$presult 	= $repObj->getReportByDate();

$_LIMIT 	= 20;
$page 		= $_GET['page'];	
$totalrows 	= count($presult);
$page 		= (empty($page)) ? 1 : $page ;
$limitvalue = ($page * $_LIMIT) - ($_LIMIT);

$paginationUrl = "index.php?action=sales_report_date";
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
		<h2 <?php echo $class;?>><?php echo $rs['tdate'];?></h2>
<?php
		$report = $repObj->getReportByTransactionDate($rs['tdate']);	
		$alt = true;
		echo "<div class='pane' $style><table>";
		echo "<tr>
				<th>Name</th>
            	<th>Purchase date/time</th>
            	<th>&nbsp;</th>
            </tr>";
		foreach($report as $row)
		{
			$alt 	= ($alt)? false : true;
			$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
            <tr class="<?php echo $style;?>">
				<td valign="top"><a href="index.php?action=account_info&id=<?php echo $row['cid'];?>"><?php echo $row['fname'];?></a></td>
            	<td valign="top"><?php echo date("M/j/Y H:i:s", strtotime($row['transaction_date']));?></td>
            	<td>
                	<table width="100%">
						<tr><td>Song title</td><td>Credit</td></tr>
					<?php 
						$songs = $repObj->getMP3ByItems($row['items']);
						foreach($songs as $mp3)
						{
							echo "<tr><td>{$mp3['title']}</td><td  width='20'>{$mp3['credit_amount']}</td></tr>";
						}
					?>
                    </table>
                </td>
            </tr>
<?php 
		}
		echo "</table></div>";
		$i++;
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
