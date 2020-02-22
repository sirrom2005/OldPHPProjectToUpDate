<?php
	$searchRs = $siteObj->searchNews( $_POST['search'] );
	$projectRs = $siteObj->searchproject( $_POST['search'] );
	$contentRs = $siteObj->searchContent( $_POST['search'] );	
	
?>
<table align="center" width="395" height="351" cellpadding="0" cellspacing="0" border=0>
	<tr><td height="10"></td></tr>
	<tr>
		<td class="infoHeading" valign="top" height="25">
			<span class="blue_text">Search </span><span class="green_text">Results</span>		</td> 
	</tr>
	<tr>
	</tr>
	<tr>
		<td valign="top">
			<div class="readingArea">
				<? 
					if( empty($searchRs) AND empty($projectRs) AND empty($contentRs) )
					{
						echo "<div class='message'>No result found.<div>";
					}
					
					if(!empty($searchRs)){
						foreach( $searchRs as $row  ){ 
				?>
							<div class="tips"><a href="index.php?action=view_news&id=<?=$row['id']?>"><?=$row['title']?></a></div>
				<? 		} 
					} 
					if(!empty($projectRs)){
						foreach( $projectRs as $row  ){ 
				?>
							<div class="tips"><a href="index.php?action=view_project&id=<?=$row['id']?>"><?=$row['title']?></a></div>
				<? 		} 
					}
					if(!empty($contentRs)){
						foreach( $contentRs as $row  ){ 
				?>
							<div class="tips"><a href="index.php?action=info&section=<?=$row['section']?>"><?=$row['title']?></a></div>
				<? 			
						}
					}
				?>
			</div>
		</td>
	</tr>
</table>
