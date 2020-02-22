<?
	$news = $siteObj->getAllNews();
?>
<table>
	<td height="10"></td></tr>
	<tr>
	  <td style="font-family: lucida console;" height="20"><b><span class="blue_text">NEWS</span><span class="green_text"> LISTING</span></b></td>
	</tr><tr>
	</tr><tr>
		<td valign="top">
		<div class="readingArea">
			<table cellpadding="0" cellspacing="0">
			
			<? foreach( $news as $row ){ 
				$title = explode(" ", $row['title']); 
			?>
				<tr>
				<td class="project_list">
					<a href="index.php?action=view_news&id=<?=$row['id'] ?>">
					<? 
						$alternat = false;
						foreach( $title as $value ){ 
							$alternat =($alternat)?false : true;
					?><span class="<?=($alternat)? "blue_text" : "green_text" ?>"><?=ucfirst(trim($value))?></span><? } ?></a>
				</td>
				</tr>
				<tr><td class="project_list" style="padding-left: 10px;"><?=substr(strip_tags(trim($row['details'])), 0, 100) ?></td></tr>
				<tr><td height="10"></td></tr>
			<? } ?>
			
			</table>
			</div>
		</td>
	</tr>
</table>