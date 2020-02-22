<?php
	include_once("../classes/software.class.php");
	include_once("../classes/pagination.class.php");
	
	$obj = new software();
	
	$data['sortby'] = (!empty($_GET['sortby']) )? $_GET['sortby'] : NULL;
	$data['ord'] 	= (!empty($_GET['ord'])    )? $_GET['ord']    : NULL;
	$data['status'] = (!empty($_GET['status']) )? base64_decode($_GET['status']) : NULL;
	$data['strdate']= (!empty($_REQUEST['strdate']))? $_REQUEST['strdate']: NULL;
	$data['enddate']= (!empty($_REQUEST['enddate']))? $_REQUEST['enddate']: NULL; 
	
	$status 	= $obj->getStatus();
	$presult 	= $obj->getTransactions($data);
	
	$_LIMIT 	= 20;
	$page 		= (!empty($_GET['page']))? $_GET['page'] : NULL ;	
	$totalrows 	= count($presult);
	$page 		= (empty($page)) ? 1 : $page ;
	$limitvalue = ($page * $_LIMIT) - ($_LIMIT);
		
	$paginationUrl = "index.php?action=transaction&status=".base64_encode($data['status'])."&sortby={$data['sortby']}&ord={$data['ord']}&strdate={$data['strdate']}&enddate={$data['enddate']}";
	$p = new Pagination($page,$_LIMIT,$totalrows,$paginationUrl,5);
	
	$results = $p->getPaginatedResults($presult);
?>
<h1>Transactions</h1>
<form name="f" method="post" action="" class="choose-date">
	<span style="width:60px; display:inline-block;">Start Date:</span>
	<input type="text" name="strdate" size="8" value="<?php echo $data['strdate']; ?>" />
	<a href="javascript:showCal('strdate')" title="Open calendar" ><img src="images/calendar.jpg"  border="0"/></a> <small>(Click image to open calendar)</small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<span style="width:60px; display:inline-block;">End Date:</span>
	<input type="text" name="enddate" size="8" value="<?php echo $data['enddate']; ?>" />
	<a href="javascript:showCal('enddate')" title="Open calendar" ><img src="images/calendar.jpg"  border="0"/></a>
	&nbsp;&nbsp;<input type="submit" value="Go" />
</form>
<table width="100%">
	<tr>
		<th>&nbsp;</th>
		<th>Account No.</th>
        <th>Account Name</th>
		<th nowrap="nowrap">
			Amount
			<a class="asc" href="index.php?action=transaction&status=<?php echo base64_encode($data['status']);?>&sortby=amount&ord=asc<?php echo "&strdate={$data['strdate']}&enddate={$data['enddate']}";?>"></a>
			<a class="desc" href="index.php?action=transaction&status=<?php echo base64_encode($data['status']);?>&sortby=amount&ord=desc<?php echo "&strdate={$data['strdate']}&enddate={$data['enddate']}";?>"></a>
		</th>
		<th>
			<select onchange="statusLink(this);">
				<option value="">All Status</option>
				<?php foreach($status as $row){ ?>
				<option value="<?php echo base64_encode($row['trans_states']);?>" <?php echo ($row['trans_states']==$data['status'])? "selected" : "" ;?> ><?php echo $row['trans_states']; ?></option>
				<?php } ?>
			</select>
		</th>
		<th nowrap="nowrap">
			Transaction Date
			<a class="asc" href="index.php?action=transaction&status=<?php echo base64_encode($data['status']);?>&sortby=trans_date&ord=asc<?php echo "&strdate={$data['strdate']}&enddate={$data['enddate']}";?>"></a>
			<a class="desc" href="index.php?action=transaction&status=<?php echo base64_encode($data['status']);?>&sortby=trans_date&ord=desc<?php echo "&strdate={$data['strdate']}&enddate={$data['enddate']}";?>"></a>
		</th>
		<th>IP - address</th>
		<th>Trans-Code</th>
	</tr>
<?php	
	if( !empty($results) )
	{
		foreach( $results as $row )
		{
?>
        <tr>
			<td width="10"><a href="javascript:del(<?php echo $row['id'];?>);" title="Delete"><img src="../images/icon-delete.gif" /></a></td>
			<td><?php echo $row['client_id'];?></td>
            <td><?php echo $row['telstar_account_name'];?></td>
			<td><?php echo number_format($row['amount'], 2, ".", ",");?></td>
			<td><?php echo $row['trans_states'];?></td>
			<td><?php echo date("l, F d. Y g:i:s", strtotime($row['trans_date']) );?></td>
			<td><?php echo $row['ipaddress'];?></td>
			<td><?php echo $row['transaction_code'];?></td>
        </tr> 
<?php
		}
	}else{ echo "<tr><td colspan='6' align='center' class='error'>No listing found...</td></tr> "; }
?>
<tr>
	<td colspan="7">
		<div class="pagination">
			 <?php
				if( count($presult) > $_LIMIT)
				{						
					$p->cleanPagination(false);
					$p->paginate();
				}
			?>
		</div>
	</td>
</tr>
</table>
<script>
function del(id)
{
	if( confirm("Delete this record.") ){ window.location = "includes/delete_transaction.php?id=" + id;}	
}
function statusLink(ele)
{
	window.location = "index.php?action=transaction&status=" + ele.value + "<?php echo "&sortby={$data['sortby']}&ord={$data['ord']}&strdate={$data['strdate']}&enddate={$data['enddate']}";?>";
}
</script>