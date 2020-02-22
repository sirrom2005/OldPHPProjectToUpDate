<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-5576813-13']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<style>
/* tooltip styling. by default the element to be styled is .tooltip  */
.tooltip {
	display:none;
	background:transparent url(themes/default/images/black_arrow.png) no-repeat;
	font-size:12px;
	font-weight:bold;
	line-height:1.4em;
	height:70px;
	width:140px;
	padding:30px 15px 20px 15px;
	color:#fff;	
}

/* style the trigger elements */
#demo img {
	border:0;
	cursor:pointer;
	margin:0 8px;
}
</style>
<script src="themes/default/js/jquery.tooltips.min.js"></script>
<?php
$headerAds 	= disPlayHeaderBanner();
$footerAds = disPlayFooterBanner();
$leftAds 	= disPlayLeftBanner();
$rightAds 	= disPlayRightBanner();
$leftAds2 	= disPlayLeftBanner2();
$rightAds2 	= disPlayRightBanner2();
$leftAds3 	= disPlayLeftBanner3();
$rightAds3 	= disPlayRightBanner3();
?>
<div id="container">
<div id="banner">
	<?php if (getOption('Allow_search')){printSearchForm(''); } ?>
    <a id="logo" href="/index.php"></a> 
    <br class="clear" />       
	<ol>
        <li><a class="fbook" title="Follow partyaad.com.com on <a href='http://www.facebook.com/partyyaadcom.lucius' target='_blank'>facebook.com</a>" href="http://www.facebook.com/partyyaadcom.lucius" target="_blank"></a></li>
        <li><a class="tweet" title="Follow partyaad.com on twitter.com <br/><a href='https://twitter.com/@partyyaadlucius' target='_blank'>@partyyaadlucius</a>" href="http://twitter.com/partyyaadlucius" target="_blank"></a></li>
        <li><a class="skype" title="Connect on skype username: <u>drlucius2</u>" href="index.php?p=contact#skype"></a></li>
        <li><a class="email" title="Send partyaad.com a instant message." href="index.php?p=contact#email"></a></li>
        <li><a class="phone" title="Call (876)853-3345 or (876)770-6966 for more information on booking" href="index.php?p=contact#telephone"></a></li>
        <li><a class="bbpin" title="Connect to us on Blackberry messenger: BBPin: <u>324CF926</u>" href="index.php?p=contact#bbpin"></a></li>
    </ol>
    <br class="clear" />    
</div>
<div id="addbanner">
<?php if(empty($headerAds)){ ?>
	<script type="text/javascript"><!--
    google_ad_client = "ca-pub-9222115009045453";
    /* leaderboard_image */
    google_ad_slot = "6203768677";
    google_ad_width = 728;
    google_ad_height = 90;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
<?php }else{ ?> 
    <a <?php echo (empty($headerAds[0]['location']))? '' : 'href="'.$headerAds[0]['location'].'" target="_blank"' ;?> ><img src="<?php echo albums.'/'.$headerAds[0]['folder'].'/'.$headerAds[0]['filename']; ?>" title="<?php echo strip_tags($headerAds[0]['title']);?>" alt="<?php echo strip_tags($headerAds[0]['title']);?>" style="width:728px; height:90px;" /></a>
<?php } ?>  
</div>    
<div id="header">
<ul>
	<li class="menu1" ><a href="/index.php">Home</a></li>
    <li class="menu2" ><a href="/index.php?p=gallery">Gallery</a></li>
    <li class="menu1" ><a href="/index.php?p=events">Events</a></li>
    <li class="menu2" ><a href="/index.php?album=promotions">Promotion</a></li>
    <li class="menu1" ><a href="/index.php?p=contact">Contact us</a></li>
</ul>
<br class="clear" />
</div>
<?php getGalleryMenu(); ?>
<?php include_once('left_banner.php'); ?>