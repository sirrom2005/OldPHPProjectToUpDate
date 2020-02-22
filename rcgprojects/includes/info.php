<?php
	$result = $comObj->getAllRecordFrmThisTable( "content", NULL, "section = ", "'{$_GET[section]}'" ); 
	$result = $result[0];
	$title = explode(" ", $result['title'] );
	
	if( empty($result['details']) )
	{
		echo "<script>location='index.php'</script>";
	}
?>
<table align="center" width="395" height="343" cellpadding="0" cellspacing="0" border=0>
	<tr><td height="10"></td></tr>
	<tr>
		<td class="infoHeading" height="18">
			<?php 
				$alternat = false;
				foreach( $title as $value ){ 
					$alternat =($alternat)?false : true;
			?> <span class="<?php echo ($alternat)? "blue_text" : "green_text" ?>"><?php echo trim($value)?> </span><?php } ?>		</td>
	</tr>
	<tr>
	</tr>
	<tr>
		<td valign="top">
			<div class="readingArea"><?php echo $result['details']?></div>
		</td>
	</tr>
</table>
