<?php
	if($_POST)
	{
		$rs = $_POST;
		if(empty($_POST['year'])){ unset($_POST);  echo "<center>Year is required.<br></center>"; }
		if(empty($_POST['month'])){ unset($_POST); echo "<center>Month is required.<br></center>"; }
		if(empty($_POST['day'])){ unset($_POST);   echo "<center>Day is required.<br></center>";}
	}
?>
<form name="f" method="post" action="">
<table style="border:solid 1px #999999; margin-bottom:5px;">
	<tr><th colspan="4">View Logs</th></tr>
		<td>
			<select name="year">
				<option value="">Select Year</option>
				<?php
					for($a=2009; $a<=date("Y"); $a++)
					{
				?>
						<option value="<?php echo $a;?>" <?php echo ($rs['year']==$a)? "selected" : "" ;?> ><?php echo $a;?></option>
				<?php
					}
				?>
			</select>
            <select name="month">
				<option value="">Select Month</option>
				<?php
					for($b=1; $b<=12; $b++)
					{
				?>
						<option value="<?php echo $b;?>" <?php echo ($rs['month']==$b)? "selected" : "" ;?> ><?php echo $b;?></option>
				<?php
					}
				?>
			</select>
            <select name="day">
				<option value="">Select Day</option>
				<?php
					for($c=1; $c<=31; $c++)
					{
				?>
						<option value="<?php echo $c;?>" <?php echo ($rs['day']==$c)? "selected" : "" ;?> ><?php echo $c;?></option>
				<?php
					}
				?>
			</select>
            <input type="submit" value="Go" />
		</td>
	</tr>
</table>
</form>
<center><a href="logs/memberlogs.csv" target="_blank">Download full members activity log</a></center>
<center><a href="logs/adminlogs.csv" target="_blank">Download full admin activity log</a></center>
<?php	
	if($_POST)
	{
		$filename = $_POST['year']."-".$_POST['month']."-".$_POST['day'];
		$date     = date("Y/m/d", strtotime($filename));
		$filename = date("Ymd", strtotime($filename)).".csv";
		$file1 = false;
		$file2 = false;
		if(file_exists("logs/$filename"))
		{
			echo "<center>Download admin log file [<a target='_blank' href='logs/$filename'>here</a>] [$date]</center>";
			$file1 = true;
		}
		
		$filename2 = "member_{$filename}";
		if(file_exists("logs/$filename2"))
		{
			echo "<center>Download member log file [<a target='_blank' href='logs/$filename2'>here</a>] [$date]</center>";
			$file2 = true;
		}
		
		if($file1 == false && $file2 == false)
		{
			echo "<center>Log files not found for date [$date].</center>";
		}
	}
?>