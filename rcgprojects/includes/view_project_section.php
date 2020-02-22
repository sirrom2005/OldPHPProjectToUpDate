<?
	$project = $siteObj->getProjectBySection( $_GET['id'] );
//echo "<pre>"; print_r($project);

	//array_rand(

?>


<table width="100%" border="0">
	<td height="10"></td></tr>
	<tr>
	  <td colspan="2"><span class="blue_text infoHeading"><?=$project[0]['project_type']?><font class="green_text"> PROJECTS</font></span></td>
	</tr><tr>
	<td height="1"></td>
	</tr>
	</tr>
	<tr>
		
		<td valign="top">
			<div class="proSection">
				<!--img src="images/bullet.gif" id="img<?=$rowType['id']?>" /-->
				<?=$rowType['project_type'] ?>
				<!--span class="clickForMenu" onclick="contracProject(<?=$rowType['id']?>)" >(Click for menu)</span-->
				<div class="proName" id="<?=$rowType['id']?>">
				<?	
					if( !empty($project) )
					{ 
						foreach( $project as $row )
						{ 
							?><span><a class="proLink" href="index.php?action=view_project&id=<?=$row['id'] ?>"><?=$row['title'] ?></a></span><br /><? 
						} 
					}
					else
					{
						echo "<a class='proLink' href='#'>No project to view</a>";
					}
				?>
				</div>
			</div>	
		</td>
	</tr>
		<!--td valign="top" align="right">
			<div align="center" id="proViewImageFrame"><a id="proLink"><img src="images/scrolltext.gif" id="proViewImage"/></a></div>
		</td-->
</table>