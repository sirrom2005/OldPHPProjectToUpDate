<?php
	include_once("connection.php");
	include_once("classes/common.class.php");
	include_once("classes/site.class.php");
	
	$siteObj = new site($db);
	$comObj  = new common($db);
	
	$latestPro = $siteObj->getLatestProject();
	$topNews   = $siteObj->getTopNews();
	$page      = ( file_exists( "includes/{$_GET['action']}.php" ) )? "{$_GET['action']}.php" : "home.php";
?>
<HTML>
<HEAD><TITLE>RCG Projects</TITLE>
<LINK href="css/default.css" type=text/css rel=stylesheet>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.style1 {font-size: 14px}
.style2 {font-family: verdana}
-->
</style>
</HEAD>
<BODY >

<table align="center" cellSpacing="0" cellPadding=0 border="0" >
	<tr>
		<td rowspan="5" width=14 background="images/lbar.jpg" valign="top" ><img src="images/home2_slice_02.jpg" style="background-repeat:no-repeat" /></td>
		<td background=images/home2_slice_03.jpg height=85 width="681">&nbsp;</td>
		<td rowspan="5" width=17 background="images/rbar.gif" style="background-repeat:repeat-y" valign="top"><img src="images/home2_slice_04.jpg" /></td>
	</tr>
	<tr>
		<td height="58" background=images/home2_slice_06.jpg><TABLE cellSpacing=0 cellPadding=0 width=681>
          <TBODY>
            <TR>
              <TD width="477"><TABLE style="MARGIN-LEFT: 5px">
                  <TBODY>
                    <TR>
                      <TD style="FONT: 10px verdana; COLOR: white">NEWS: <A class=top_links id=news_text href="#"></A></TD>
                    </TR>
                  </TBODY>
              </TABLE></TD>
              <TD width="202"><TABLE width="174" align=right style="MARGIN-RIGHT: 10px">
                  <TBODY>
                    <TR>
                      <TD width="52" align=middle><span class="style1">Search:</span></TD>
                      <TD width="110" class=top_links><form name="f" method="post" action="index.php?action=search_page">
                        <input type="text" name="search" class="searchText" title="Please enter keywords or phrases to search the contents of this website">
  &nbsp;
                      </form></TD>
                    </TR>
                  </TBODY>
              </TABLE></TD>
            </TR>
          </TBODY>
		  </TABLE>		</td>
	</tr>
	<tr>
		<td height=236 id="flashBorder" valign="top">
		<?php 
			$changBanner = false;
			if( $_GET['action'] == "view_project" )
			{
				$banner = $siteObj->getProjectBanner( $_GET['id'] );
				if( !empty($banner['banner']) )
				{
					if( file_exists( "images/projects/banner/".$banner['banner'] ) )
						$changBanner = true;
				}
			}
			
			if( $changBanner ){
		 ?>
		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="681" height="236">
          <param name="movie" value="images/projects/banner/<?php echo $banner['banner']?>">
          <param name="quality" value="high">
		  <param name="SCALE" value="exactfit">
          <embed src="images/projects/banner/<?php echo $banner['banner']?>" width="681" height="236" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" scale="exactfit"></embed>
        </object>
		<?php }else{ ?>
		 <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="681" height="236">
			<param name="movie" value="images/flash/home_movie.swf">
			<param name="quality" value="high"><param name="SCALE" value="exactfit">
			<embed src="images/flash/home_movie.swf" width="681" height="236" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" scale="exactfit"></embed>
		  </object>
		 <?php } ?>	  </td>
	</tr>
	<tr>
	  <td height="1"></td>
	</tr>
	<tr>
		<td height="345" valign="top">
			<table align="center" cellpadding="0" cellspacing="0">
				<tr>
					<td width=223 background="images/home2_slice_09.jpg" style="background-repeat:no-repeat" height=232 valign="top"><?php include_once("includes/menu.php"); ?></td>
					<td width=15></td>
					<td width=424 height=345 rowSpan=2 valign="top">
						<?php include_once("includes/".$page); ?>					</td>
				</tr>
				<tr>
					<td valign="top">
						<TABLE height=113 cellSpacing=0 cellPadding=0 width=223 border=0>
							<TBODY>
							<TR>
							  <TD height=10></TD></TR>
							<TR>
							  <TD width=178 height=16><span class="blue_text style2"><strong>Latest   </strong></span> <span class="green_text style2"><strong>Projects</strong></span><span class="style2"><strong>&nbsp;</strong></span></TD>
							</TR>
							<TR>
							  <TD vAlign=top>
								<TABLE border="0" cellpadding="0" cellspacing="0">
								  <?php foreach( $latestPro as $row ){ ?>
								  <TR>
									<TD class="lp"><A class="lpLinks" href="index.php?action=view_project&id=<?=$row['id'] ?>"><?=ucwords( strtolower(trim($row['title'])) )?></A></TD>
								  </TR>
								  <?php } ?>
								</TABLE></TD></TR></TBODY>
						</TABLE>
					</td>
				</tr>
			</table>
            </td>
	</tr>
	<tr>
		<td height="101" rowspan="2" background="images/lc.jpg" style="background-repeat:no-repeat" ></td>
		<td height="36" background=images/home2_slice_13.jpg>
			<table cellspacing="0" cellpadding="0" width="450" align="center" border="0">
			  <tbody>
				<tr style="COLOR: #4a8e84">
				  <td align="middle"><a class="tail_links" 
				href="index.php?action=home">Home</a></td>
				  <td>|</td>
				  <td align="middle"><a class="tail_links" 
				href="index.php?action=info&section=about">About Us</a></td>
				  <td>|</td>
				  <td align="middle"><a class="tail_links" 
				href="index.php?action=services">Services</a></td>
				  <td>|</td>
				  <td align="middle"><a class="tail_links" 
				href="index.php?action=projects">Projects</a></td>
				  <td>|</td>
				  <!--td align="middle"><a class="tail_links" 
				href="index.php?action=prospects">Propects</a></td>
				  <td>|</td-->
				  <!--<td align="center"><a href="" class="tail_links">Careers</a></td>
			<td>|</td>-->
				  <td align="middle"><a class="tail_links" 
				href="index.php?action=contact">Contact 
					Us</a></td>
				  <td>|</td>
				  <td align="middle"><a class="tail_links" href="index.php?action=info&section=career">Career</a></td>
				</tr>
			  </tbody>
			  </table>		</td>
		<td rowspan="2" background="images/rc.jpg" style="background-repeat:no-repeat"></td>
	</tr>
	<tr>
		<td height="75" background=images/home2_slice_14.jpg id="footerUpdate" ><p>&nbsp;</p><center><small><b>Last updated: Monday July 18, 2011.</b></small></center></td>
	</tr>
</table>
<script>
var news_items = 	[
					["<?php echo ucfirst( strip_tags(stripslashes($topNews[0]['title'])))?>", "index.php?action=view_news&id=<?php echo $topNews[0]['id']?>" ],
					["<?php echo ucfirst( strip_tags(stripslashes($topNews[1]['title'])))?>", "index.php?action=view_news&id=<?php echo $topNews[1]['id']?>" ],
					["<?php echo ucfirst( strip_tags(stripslashes($topNews[2]['title'])))?>", "index.php?action=view_news&id=<?php echo $topNews[2]['id']?>" ]
					];
</script>
</html>
