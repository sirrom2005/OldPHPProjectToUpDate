<?php
	$result = $comObj->getAllRecordFrmThisTable( "projects", NULL, "id = ", $_GET['id'] ); 
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
		?><span class="<?=($alternat)? "blue_text" : "green_text" ?>"> <?=ucfirst(trim($value))?> </span><? } ?>
		</td>
	</tr>
	<tr>
		<td height="120">
			<img src="images/projects/<?=$image?>" style="border: 1px solid black;" height="100" width="200">
		</td>
	</tr>
	<tr>
		<td valign="top" height="170">
			<div class="viewProText"><?=$result['details']?></div>
		</td>
	</tr>
	<tr>

		<td height="20">
			<table width="101%">
			<tbody><tr>
				<td width="15%"><a href="javascript:open_gellery(<?=$result['id']?>);" style="font-weight: normal; color: rgb(74, 142, 132);"></a></td>
				<td width="85%"><div align="right"><a href="index.php?action=projects" style="font-weight: bold; color: rgb(74, 142, 132);">.:: See More Projects</a></div></td>
			</tr>
		  </tbody></table>

		</td>
	</tr>
</table>