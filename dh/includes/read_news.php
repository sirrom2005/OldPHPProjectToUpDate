<style type="text/css">
<!--
@import url("<?php echo DOMAIN;?>css/tab.css");
-->
</style>
<div id="products" class="news soft_review">
    <div class="bg">
        <h2>Download Hours News Center</h2>
         <h1><?php echo $result['title'];?></h1>
         <p><?php echo cleanHtml($result['detail']);?></p>
         <div id="newsAds">
			<script type="text/javascript"><!--
            google_ad_client = "pub-7769573252573851";
            /* downloadhours_link_ads */
            google_ad_slot = "8851136611";
            google_ad_width = 468;
            google_ad_height = 15;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
         </div>
         <div class="clear"></div>
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