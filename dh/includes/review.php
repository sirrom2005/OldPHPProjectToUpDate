<style type="text/css">
<!--
@import url("<?php echo DOMAIN;?>css/tab.css");
@import url("<?php echo DOMAIN;?>js/ddtabmenufiles/ddtabmenu.css");
-->
</style>
<?php include_once("classes/image_resize.php"); ?>
<div id="products" class="contenPage soft_review">
    <div class="bg">
        <h2>Product Review</h2>
		<div id="hdr">  
			<img src="<?php echo $result['app_icon'];?>" />
			<h3><?php echo cleanText($result['title']);?></h3>
			<h4>"<?php echo cleanText($result['summary_80']);?>"</h4>
		</div>
		<table>
			<tr>
				<td class="title">Downloads</td>			<td>:Total <?php echo $downloads['downloadcount'];?></td>
				<td rowspan="9" valign="top">
					<table>
						<tr><td class="title">Popularity:</td></tr>
						<tr>
                        	<td style="padding:0;" valign="top">
                            	<table style="margin-left:0;">
                                	<tr><td width="110"><div style="width:<?php echo $barWidth;?>px;background:#768719;"><img src="<?php echo DOMAIN;?>images/bar2.gif" /></div></td><td style="color:#768719;font-weight:bold;"><?php echo $popularity;?>%</td></tr>
                                </table>
                        	</td>
                        </tr>
						<tr><td class="title">User Ratings:</td></tr>
						<tr><td><font><?php echo $rate['count'];?> votes</font><div id="clearStar"><div id="starValue" style="width:<?php echo $rating;?>px;">&nbsp;</div></div></td></tr>
						<tr><td class="title">Your Rating:</td></tr>
						<tr>
							<td>
							<form name="ratingfrm" method="post" action="">
								<span><a href="#" onclick="document.ratingfrm.submit();">&nbsp;</a></span>
								<select name="rating">
									<option value="5">Excellent</option>
									<option value="4">Better</option>
									<option value="3">Average</option>
									<option value="2">Good</option>
									<option value="1">Poor</option>
								</select>
							</form>							</td>
						</tr>
						<tr><td class="title">BookMark:</td></tr>
						<tr><td><img src="<?php echo DOMAIN;?>images/add_fav.jpg" style="cursor:pointer;" onclick="javascript:bookmarksite('<?php echo "DownloadHours.com - Free Software ".addslashes($pageTitle);?>', '<?php echo "http://www.downloadhours.com".$_SERVER['REQUEST_URI'];?>')"/></td></tr>
					</table>
                 </td>
			</tr>
			<tr>
				<td class="title">Publisher</td>
				<td>
					: <a href="<?php echo cleanString($result['app_website']);?>"><?php echo cleanString($result['app_developer']);?></a> 
					<?php if(count($pubList)>0){?>| <a href="<?php echo DOMAIN;?>search.php?pub=<?php echo base64_encode($result['app_developer']);?>">View <?php echo count($pubList);?> other products</a><?php }?></td>
			</tr>
			<tr><td class="title">OS</td>					<td><?php echo osFornat($result['operating_system']);?></td></tr>
			<tr><td class="title">Release Status</td>		<td>: <?php echo cleanString($result['release_status']);?></td></tr>
			<tr><td class="title">Install Support</td>		<td>: <?php echo cleanString($result['install_support']);?></td></tr>
			<tr><td class="title">License</td>      		<td>: <?php echo (!empty($result['program_type']))? cleanString($result['program_type']) : "Unknown"; if( !empty($result['app_price']) ){?><a href="<?php echo cleanString($result['app_buy_url']);?>" target="_blank" >| $<?php echo number_format($result['app_price'], 2, ".", ",");?> to buy</a><?php }?></td></tr>
			<tr><td class="title">Size</td>					<td>: <?php echo cleanString($result['app_filesize']);?> MB</td></tr>
			<tr><td class="title">Release Date</td>			<td>: <?php echo date("d/m/Y", strtotime($result['release_date']));?></td></tr>
			<tr><td class="title">Date Addede</td>			<td>: <?php echo date("d/m/Y", strtotime($result['date_added']));?></td></tr>
			<tr><td class="title">Last Updated</td>			<td>: <?php echo date("d/m/Y", strtotime($result['release_date']));?></td></tr>
		</table>
        <h5 style="clear:left;"><?php echo cleanString($result['title']);?> Description</h5>
        <p><?php echo cleanXmlString($result['app_desc']);?></p>
        <h5>System Requirements</h5>
        <p><?php echo cleanXmlString($result['system_requirements']);?></p>
        <h5>Related Tags</h5>
        <p id="keywords"><?php echo keyWordsFornat($result['keywords']);?></p>
      
      	<div id="ddtabs" class="basictab">
            <ul>
                <li><span><a href="javaScript:;" onclick="javaScript:expandcontent('sc1', this);"><font>Download</font></a></span></li>
                <li><span><a href="javaScript:;" onclick="javaScript:expandcontent('sc2', this);"><font>Buy</font></a></span></li>
                <li><span><a href="javaScript:;" onclick="javaScript:expandcontent('sc3', this);"><font>Screenshot</font></a></span></li>
                <li><span><a href="javaScript:;" onclick="javaScript:expandcontent('sc4', this);"><font>Publisher</font></a></span></li>
           </ul>
        </div>
        <div id="tabcontentcontainer">
            <div id="sc1" class="tabcontent">
            	Download <a href="<?php echo DOMAIN;?>download.php?file=<?php echo base64_encode(cleanString($result['app_download']));?>&id=<?php echo $result['id'];?>" target="_blank" title="Download <?php echo cleanString($result['title']);?> now!!!"><?php echo cleanString($result['title']);?></a> now!!!
            </div>
            <div id="sc2" class="tabcontent">
            	<?php if( !empty($result['app_buy_url']) ){ ?>
                    <p>Buy <a href="<?php echo cleanString($result['app_buy_url']);?>" target="_blank" title="Buy <?php echo cleanString($result['title']);?> now!!!"><?php echo cleanString($result['title']);?></a> just for <?php echo number_format($result['app_price'], 2, ".", ",");?></p>
                    <a href="<?php echo cleanString($result['app_buy_url']);?>" target="_blank" title="Buy <?php echo cleanString($result['title']);?> now!!!">Buy now!!!</a>
            	<?php }else{ ?>
                	<p>This software is Freeware</p>
                    Download <a href="<?php echo DOMAIN;?>download.php?file=<?php echo base64_encode(cleanString($result['app_download']));?>&id=<?php echo $result['id'];?>" target="_blank" title="Download <?php echo cleanString($result['title']);?> now!!!"><?php echo cleanString($result['title']);?></a> now!!!
                <?php } ?>
            </div>  
            <div id="sc3" class="tabcontent">
            	<img src="<?php echo $result['app_screenshot'];?>" />
            </div>
            <div id="sc4" class="tabcontent">
            	<h1>About <?php echo cleanString($result['app_developer']);?></h1>
                View Developer <a href="<?php echo cleanString($result['app_website']);?>" target="_blank" title="View developer website">website</a> for more information.
            </div>
        </div>
		<hr class="dot"/>
		<div>
				<?php if(true){ ?>
				 <form name="comment" method="post" action="">
					<div>
						<?php if(!empty($comments)){ ?>
						<ul style="margin-bottom:30px;">
							<li><h1>User Reviews</h1></li> 
							<?php foreach($comments as $row){ ?>
							<li><b><?php echo cleanString($row['name']); ?></b></li>
							<li><?php echo cleanString($row['comment']); ?></li>
							<li><i><?php echo date("l, F d. Y", strtotime($row['date_added'])); ?></i><hr /></li>
							<?php } ?>
						</ul>
						<?php } ?>
						<ul>
							<?php echo $msg;?>  
							<li><h1>Post Your Reviews</h1></li> 
							<li><input type="text" name="name" class="inputbox" value="<?php echo cleanString($rs['name']); ?>" /> <?php echo $errName;?></li>
							<li><input type="text" name="email" class="inputbox" value="<?php echo cleanString($rs['email']); ?>" /> <?php echo $errEmail;?></li>
							<li><?php echo $errComment;?><textarea name="comment"><?php echo cleanString($rs['comment']);?></textarea></li>
							<li>
								<input type="checkbox" name="remember" value="1" />Remember my personal information<br />
								<input type="checkbox" name="notify_email" value="1" />Notify me of follow-up comments?
							</li>
							<li>
								<small>Submit the words you see below:</small><br />
								<img src="<?php echo DOMAIN;?>captcha/button.php" style="border:solid 1px #D09B9D;" /><br />
								<input type="text" name="code" /><?php echo $errCode;?><br />
								<input type="submit" value="Submit" style="margin-top:5px;" />
							</li>
							<li></li>
						</ul>
					</div>				
					<span>&nbsp;</span>
				 </form>
				<?php }else{ ?>
					<p>You must <a href="#">login</a> or <a href="<?php echo DOMAIN;?>registration.html">register</a> to post reviews.</p>
				<?php } ?>
		</div>
    </div>
</div>
<script type="text/javascript" src="<?php echo DOMAIN;?>js/tab.js"></script>
<script type="text/javascript" src="<?php echo DOMAIN;?>js/ddtabmenufiles/ddtabmenu.js"></script>
<script type="text/javascript">
ddtabmenu.definemenu("ddtabs1", 0) //initialize Tab Menu #1 with 1st tab selected

/***********************************************
* Bookmark site script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
/* Modified to support Opera */
function bookmarksite(title,url)
{
	if (window.sidebar) // firefox
		window.sidebar.addPanel(title, url, "");
	else if(window.opera && window.print)
	{ // opera
		var elem = document.createElement('a');
		elem.setAttribute('href',url);
		elem.setAttribute('title',title);
		elem.setAttribute('rel','sidebar');
		elem.click();
	} 
	else if(document.all)// ie
		window.external.AddFavorite(url, title);
}
</script>