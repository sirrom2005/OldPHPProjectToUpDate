<div id="products" class="contenPage">
    <div class="bg">
		<?php 
			if($_GET['order']=="aprove")
			{
				echo "<h2>Advertising Order purchase.</h2>";
				echo $msg;
			}
			else
			{
		?>
        <h2>Advertising Order Review</h2>
		<ul class="table">
			<li class="title">Banner Size</li> <li>: <?php echo $rs['size'];?></li>
			<li class="title">Cost</li> <li>: USD $<?php echo number_format($rs['price'], 2, ".", ",");?> per month</li>
			<li class="title">Rotating Banner</li> <li>: <?php echo (empty($rs['rotating']))? "Yes" : "No" ;?></li>
			<li class="title">Name</li> <li>: <?php echo $_SESSION['advertising_order']['name'];?></li>
			<li class="title">Website</li> <li>: <?php echo $_SESSION['advertising_order']['website'];?></li>
			<li class="title">Email</li> <li>: <?php echo $_SESSION['advertising_order']['email'];?></li>    
			<li class="title">Paypal Email</li> <li>: <?php echo $_SESSION['advertising_order']['paypal_email'];?></li>
			<li class="title">&nbsp;</li><li><b>Banner Code</b><code><?php echo htmlentities($_SESSION['advertising_order']['banner_code']);?></code></li>
            <li class="title">&nbsp;</li><li><input type="button" value="Back" onclick="history.back(-1);" /></li>
            <li class="title">&nbsp;</li>
            <li><p>&nbsp;</p>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                <input type="hidden" name="cmd" value="_xclick">
                <input type="hidden" name="business" value="iceman@odesk.com">
                <input type="hidden" name="lc" value="US">
                <input type="hidden" name="item_name" value="Advertising Space - Banner <?php echo $rs['size'];?>">
                <input type="hidden" name="amount" value="<?php echo number_format($rs['price'], 2, ".", ",");?>">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="return" value="<?php echo DOMAIN;?>advertising_order_review.html?order=aprove">
                <input type="hidden" name="cancel_return" value="<?php echo DOMAIN;?>cancel_payment.html">
                <input type="hidden" name="button_subtype" value="products">
                <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
                <input type="image" src="images/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
            </li>
		</ul>
		<?php } ?>
        <div class="clear"></div>
    </div>
</div>