<?php
$current = (isset($current))? $current : "home";
?>
<div id="MenuBar">
    <div class="container">
        <div class="lft">
            <ul class="navi top">
                <li <?php if($current=="home"  ){ echo "class='current'";}?> ><a href="<?php echo DOMAIN;?>" title="buy music">Buy Music</a></li>
                <li <?php if($current=="new"   ){ echo "class='current'";}?> ><a href="<?php echo DOMAIN;?>new_releases.php" title="new releases and more">New Releases</a></li>
                <?php if(!empty($_SESSION['USER'])){ ?>
                <li <?php if($current=="mymusic"){ echo "class='current'";}?> ><a href="<?php echo DOMAIN;?>my_music.html" title="my music">My Music</a></li>
                <?php } ?>
                <li <?php if($current=="credit"){ echo "class='current'";}?> ><a href="<?php echo DOMAIN;?>buycredits.html" title="buy credits">Buy Credits</a></li>
                <li <?php if($current=="faq"   ){ echo "class='current'";}?> ><a href="<?php echo DOMAIN;?>faq.html" title="frequently asked questions">FAQs</a></li>
            </ul><!-- navi -->
        </div><!-- left -->
         <div class="rgt">
            <div class="login-area">
               	<?php if(empty($_SESSION['USER'])){ ?>
                       	<a href="<?php echo DOMAIN;?>notamember.php" class="sign-up" rel="facebox" title="not a member? sign up">Not a Member? Sign Up</a>
						<a href="<?php echo DOMAIN;?>control/" class="btn login" title="member's login"><img alt="login" src="<?php echo DOMAIN;?>images/btn_login.jpg" /></a>
                    <?php }else{ ?>
                        <a>Hi <?php echo $_SESSION['USER']['fname'];?> (<span id="mycamount"><?php echo $_SESSION['USER']['credit_amount'];?></span>) |&nbsp;</a>  
                        <a href="<?php echo DOMAIN;?>buycredits.html" title="refill/buy credits">Refill credits</a><br /> 
                        <a href="<?php echo DOMAIN;?>control/" title="control panel">Control panel |&nbsp;</a> 
                        <a href="<?php echo DOMAIN;?>logout.html" title="logout">Logout</a>
                    <?php } ?>
            </div><!-- login -->
        </div><!-- right -->	
    </div><!-- container -->
</div><!-- MenuBar -->