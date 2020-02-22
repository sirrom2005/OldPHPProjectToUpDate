<?php
	
$pType = $siteObj->getProjectTypeList();
$project = $siteObj->getAllProject( $_GET['type'] );

if( !$_GET['type'] ){
?>
<style type="text/css">
<!--
.style1 {font-size: 12px}
-->
</style>



<table width="100%" border="0">
	<td height="10"></td></tr>
	<tr>
	  <td colspan="2"><span class="blue_text infoHeading"><font class="green_text">OUR</font> PROJECTS<font class="green_text"></font></span></td>
	</tr><tr>
	<td height="5"></td></tr>
	</tr>
	
	<?php 
		if( !empty($pType) )
		{
			foreach( $pType as $rowType ){ 
	?>
	<tr>
		<td class="proFrame"><a href="index.php?action=view_project&id=<?php echo $rowType['proId']?>"><img src="images/projects/<?php echo $rowType['proImage']?>" width="120" height="90" class="imgborder" ></a></td>
		<td valign="top">
					<div class="proSection">
						<!--img src="images/bullet.gif" id="img<?php echo $rowType['id']?>" /-->
						<?php echo $rowType['project_type'] ?>
						<!--span class="clickForMenu" onclick="contracProject(<?php echo $rowType['id']?>)" >(Click for menu)</span-->
					  <div class="proName" id="<?php echo $rowType['id']?>">
						<?php	
							if( !empty($project[ $rowType['id'] ]))
							{ 
								$count = 0;
								foreach( $project[ $rowType['id'] ] as $row ){
									 
						?>		
									 <span><a class="proLink" href="index.php?action=view_project&id=<?php echo $row['id'] ?>"><?php echo $row['title'] ?></a></span><br />
						<?php 
									if( $count == 3 )
									{
										break;
									}
									else
									{
										$count++;
									}
								}
						?>
						  <a href="index.php?action=view_project_section&id=<?php echo $rowType['id'] ?>" class="proLink2 style1">View all projects from this section</a>
						<?php 
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
			<?php 
					}
				} 
			?>
		<!--td valign="top" align="right">
			<div align="center" id="proViewImageFrame"><a id="proLink"><img src="images/scrolltext.gif" id="proViewImage"/></a></div>
		</td-->
</table>

<? }else{ 

if( $_GET['type'] == 1 )
{
	$groupName = "hospitality";
}elseif( $_GET['type'] == 2 )
{
	$groupName = "commercial";
}elseif( $_GET['type'] == 3 )
{
	$groupName = "residential";
}elseif( $_GET['type'] == 4 )
{
	$groupName = "broadcast";
}
?>

<table width="100%" border="0" cellspacing="1">
	<td height="10"></td></tr>
	<tr><td height="35" colspan="2" ><span class="blue_text infoHeading"><?php echo $groupName ?></span></td>
	</tr><tr>
	</tr><tr>
		<td valign="top" width="45%">
			<div class="readingArea">
				<?php 
					if( !empty($project[ $_GET['type'] ]) ){
						foreach( $project[ $_GET['type'] ] as $row ){					 
				?>	
						- <span onmouseover="showProImage('<?php echo $row['image'] ?>', <?php echo $row['id'] ?> );"><a href="index.php?action=view_project&id=<?php echo $row['id'] ?>"><?php echo $row['title'] ?></a></span><br />
				<?php 
						}
					}
					else
					{
						echo "- <a>No project to view</a>";
					}
				?>
			</div>
		</td>
		<td valign="top" align="right">
			<div align="center" id="proViewImageFrame"><a id="proLink"><img src="images/scrolltext.gif" id="proViewImage"/></a></div>
		</td>
	</tr>
</table>

<?php } ?>