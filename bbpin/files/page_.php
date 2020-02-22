<?php
include_once("config/config.php");
include_once(DOCROOT."includes/languages/$lang.php");
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
$obj = new site();
@$page = $_GET['action'].'.php';
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>">
<head> 
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="JusBBmPins.com :: meet your match on your blackberry messenger">
<meta name="description" content="Connect with new blackberry messenger individuals find BBM groups that share your similar interest">
<meta name="keywords" content="jusbbmpins,blackberry,messenger,bbm,connect,groups,black,berry,pin,request">
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>JusBBmPins.com :: Connect with new BBM individuals and groups that share your similar interest</title>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5039d3134bebc572"></script>
<link href="styles/layout.css" rel="stylesheet" type="text/css">
<style>
h1{font-size:1.3em; background-color:#1d2a5b;color:#FFFFFF;padding:2px 5px;background-image: url("images/glossy-mat.png");background-repeat: repeat-x;}
h3{background-color:#FFFFFF;border:0;border-bottom:solid 1px #333333;}
h4{margin:0;padding-bottom:10px;}
#content{padding:0;}
.contentText{ padding:10px;}
</style>
<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="styles/IE.css" />
<![endif]-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31035193-4']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body>
<div id="header">
	<div>
       <span class="shear">
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style ">
            <a class="addthis_button_facebook_like"></a>
            <a class="addthis_button_tweet"></a>
            <!--a class="addthis_button_pinterest_pinit"></a-->
            <a class="addthis_counter addthis_pill_style"></a>
            </div>
            <!-- AddThis Button END -->
        </span>
        <a href="<?php echo DOMAIN;?>" title="Go to <?php echo SITE_NAME;?> home page" class="logo"></a>
    </div>
</div>
<span id="leaderboard">
    <script type="text/javascript"><!--
    google_ad_client = "ca-pub-9222115009045453";
    /* leaderboard_image */
    google_ad_slot = "6203768677";
    google_ad_width = 728;
    google_ad_height = 90;
    //-->
    </script><script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
</span>
<div id="container">
    <div id="content">
    	<?php @include_once('includes/'.$page); ?>
        <hr style="visibility:hidden;">
    </div>
    <div id="footer">
    	<p> 
        	<a class="ft-facebook" href="http://www.facebook.com/jusbbmpins" target="_blank" title="like our page on facebook"><?php echo $locale['fb.follow'];?></a>
            <a class="ft-twitter" href="https://twitter.com/jusbbmpins"  data-show-count="false"><?php echo $locale['tw.follow'];?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </p>
        <a href="<?php echo DOMAIN;?>about-us.htm"><?php echo $locale['about'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>faqs.htm"><?php echo $locale['faqs'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>privacy-policy.htm"><?php echo $locale['privacy'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>terms.htm"><?php echo $locale['terms'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>feedback.htm"><?php echo $locale['feedback'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>contact-us.htm"><?php echo $locale['contact'];?></a>
        <br>
        <?php echo SITE_NAME;?> &copy; <?php echo date('Y');?>
    </div>
</div>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>