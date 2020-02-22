<?php
	$result = $comObj->getAllRecordFrmThisTable( "prospects", NULL, "id = ", $_GET['id'] ); 
	$result = $result[0];
	$title = explode(" ", $result['title'] );
	
	if(!empty($result['image']))
	{
		$image = ( file_exists( "images/projects/".$result['image'] ) )? $result['image'] : "default.jpg";
	}
	else
	{
		$image = "default.jpg";
	}
?>
<table border="0">
	<tr><td height="10"></td></tr>
	<tr>
		<td class="textTitle"  height="20">
		<? 
			$alternat = false;
			foreach( $title as $value ){ 
				$alternat =($alternat)?false : true;
		?><span class="<?=($alternat)? "blue_text" : "green_text" ?>"><?=ucfirst(trim($value))?></span><? } ?>
		</td>
	</tr>
	<tr>
		<td height="120">
			<img src="images/projects/<?=$image?>" style="border: 1px solid black;" height="100" width="200">
		</td>
	</tr>
	<tr>
		<td valign="top">
			<div class="viewProText"><?=$result['details']?></div>
		</td>
	</tr>
	<tr>
	</tr>
</table>