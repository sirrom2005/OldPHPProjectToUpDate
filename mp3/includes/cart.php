<?php	
	$current = "music";
	if(!empty($_SESSION['CARTITEM']))
	{
		$cartItems = $siteObj->getCartItems($_SESSION['CARTITEM']);
	}
?>
<?php 
if(!empty($cartItems))
{
?>
<!--ul id="cartlist">
	<?php foreach($cartItems as $row){?>
        <li onclick="removefromcart(this, <?php echo $row['id'];?>);"><a href="#" class="removefromcart"></a><?php echo $row['title'];?> &cent;<?php echo $row['credit_amount'];?></li>
    <?php }?>
</ul-->

	<ul id="cartlist">
	<?php foreach($cartItems as $row){?>
    <li onclick="removefromcart(this, <?php echo $row['id'];?>);">
       <div class="track sample">
            <img alt="<?php echo $row['title'];?>" height="48" width="50" class="thumb" src="<?php echo (empty($row['photo']))? ARTISTE_IMG_URL.'default.png' : ARTISTE_IMG_URL.ARTISTE_SML_TMB."_".$row['photo'];?>" />
            <a href="#" class="play">
            <object type="application/x-shockwave-flash" data="player/player_mp3_maxi.swf" width="25" height="20">
                <param name="movie" value="player/player_mp3_maxi.swf" />
                <param name="bgcolor" value="#ffffff" />
                <param name="FlashVars" value="mp3=<?php echo MP3LOCATION."sample_{$row['id']}.mp3";?>&amp;width=25&amp;autoload=0&amp;showslider=0&amp;showloading=always" />
            </object>
            </a>
            <span class="track info">
                <span class="track title"><?php echo $row['title'];?></span>
                <span class="track sub-title"><?php echo $row['riddim'];?> (<?php echo $row['producerfname'];?>)</span>
            </span>
            <span class="credit info">
                <span class="credit amount"><?php echo $row['credit_amount'];?></span>
                <span class="credit text">Credits</span>
            </span>
            <a class="remove from cart">remove from cart</a>
        </div>
    </li>
	<?php }?>
    </ul>
    <form action="buy_mp3.html" method="post" id="buynow">
        <?php
        if(empty($_SESSION['USER']))
        {
            echo "You must <a href='control/'>login</a> to make your purchase.";
        }
        else
        {
        ?>
            <input type="hidden" name="pay_now" value="1" />
            <input type="submit" value="Pay now" />
        <?php
        }
        ?>
    </form> 	
<?php 
	}
	else
	{ 
		echo "<span class='msg'>Cart is empty...</span>";
	}
?>
<script>
function removefromcart(key, id)
{
	$.get("<?php echo DOMAIN;?>includes/removefromcart.php",
		{id:id},
		function(data)
		{
			$(key).remove();  
			var ciLen = $("#cartlist>li").length;
			if(ciLen == 0)
			{
				$("#buynow").html("<span class='msg'>Cart is empty...</span>");	
			}
		}
	)
	var str = document.getElementById("cartItemCount").innerHTML
	str = str.replace(str,"(");
	str = str.replace(str,")");					
	str = parseInt(str);
	str--;
	alert(parseInt("()"));
	document.getElementById("cartItemCount").innerHTML = str;
}
</script>