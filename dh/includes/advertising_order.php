<div id="products" class="contenPage">
    <div class="bg">
        <h2>Advertising Order</h2>
		<form name="order" method="post">			
			<ul class="table">
			  <li class="title">Rotating Banner</li>
			  <li>
			  	<input type="radio" name="ads" value="1" id="ads1" checked="checked" /> <label for="ads1">(728 x 90 )</label> USD $13.00 per month<br />
				<input type="radio" name="ads" value="2" id="ads2" <?php echo ($ads=="2")? "checked" : "" ;?> /> <label for="ads2">(300 x 250)</label> USD $13.00 per month<br />
				<input type="radio" name="ads" value="3" id="ads3" <?php echo ($ads=="3")? "checked" : "" ;?> /> <label for="ads3">(125 x 125)</label> USD $13.00 per month
			  </li>
			  <li class="title">No Rotating Banner</li>
			  <li>
			  	<input type="radio" name="ads" value="4" id="ads4" <?php echo ($ads=="4")? "checked" : "" ;?> /> <label for="ads4">(300 x 250)</label> USD $35.00 per month
			  </li>
			  <li class="title">Full Name</li><li><input type="text" name="name" value="<?php echo $name;?>" class="inputbox" /><?php echo $errName;?></li>
			  <li class="title">Website</li><li><input type="text" name="website" value="<?php echo $website;?>" class="inputbox" /></li>
			  <li class="title">Email</li><li><input type="text" name="email" value="<?php echo $email;?>" class="inputbox" /><?php echo $errEmail;?></li>
			  <li class="title">PayPal Email<br /><small>If differnt from above</small></li><li><input type="text" name="paypal_email" value="<?php echo $paypal_email;?>" class="inputbox" /><?php echo $errpaypal_email;?><p></p></li>
			  <li class="title">Banner Code</li><li><textarea name="banner_code"><?php echo $banner_code;?></textarea><?php echo $errbanner_code;?>
					<code>
						eg: <?php echo htmlentities( "<a href=\"www.somewebsite.com\"><img src=\"www.somewebsite.com/banner_ads.jpg\"/></a>"); ?>
						<br /><i>As your web developer to provide you with your own code.</i>
					</code>
			 </li>
			 <li class="title"></li><li><input type="submit" value="Order Now!!" /></li>
			</ul>
		</form>
		<div class="clear"></div>
    </div>
</div>