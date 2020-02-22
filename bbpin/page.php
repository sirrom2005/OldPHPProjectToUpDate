<?php
include_once("config/config.php");
include_once("includes/languages/$lang.php");
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
$obj = new site();
@$page = $_GET['action'].'.php';
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>">
<head> 
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="JusBBmPin find new bbm pins for your blackberry messenger">
<meta name="description" content="Connect with new blackberry messenger individuals find BBM pins and bbm groups that share your similar interest">
<meta name="keywords" content="jusbbmpins,jusbbmpin,blackberry,messenger,bbm,pinshare,connect,facebook,twitter,groups,black,berry,pin,request">
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>JusBBmPins.com :: Connect with new BBM individuals and groups that share your similar interest</title>
<link href="styles/layout1.1.css" rel="stylesheet" type="text/css">
<style>
.boxStyle1 h1{font-size:1em; border-bottom:solid 1px #999999; margin-bottom:4px; text-decoration:none; color:#333333;}
p{margin-bottom:5px;}
</style>
<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="styles/IE.css" />
<![endif]-->
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5039d3134bebc572"></script>
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
	<span id="topLink">
		<a href="<?php echo DOMAIN;?>index.php" title="<?php echo $locale['goto.home'];?>" class="logo"></a>
    </span>
</div>
<div id="container">
    <div id="infobar" class="boxStyle1">
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_facebook_like"></a>
        <a class="addthis_button_tweet"></a>
        </div>
        <!-- AddThis Button END -->
		<script type="text/javascript"><!--
        google_ad_client = "ca-pub-9222115009045453";
        /* 250x250_ads */
        google_ad_slot = "7923102952";
        google_ad_width = 250;
        google_ad_height = 250;
        //-->
        </script>
        <script type="text/javascript"
        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
        <script type="text/javascript"><!--
        google_ad_client = "ca-pub-9222115009045453";
        /* 250x250_ads */
        google_ad_slot = "7923102952";
        google_ad_width = 250;
        google_ad_height = 250;
        //-->
        </script>
        <script type="text/javascript"
        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
    </div>
    <div class="boxStyle1" id="content"><?php include_once('includes/'.$page); ?></div>
	<?php include_once('includes/footer.php'); ?>
</div>
<script type="text/javascript" src="js/global.js"></script>
<script>
function showLangMenu(){
	if(document.getElementById('ulLangMenu').style.display == 'none'){
		document.getElementById('ulLangMenu').style.display = '';
	}else{
		document.getElementById('ulLangMenu').style.display = 'none';
	}
}
</script>
<?php echo "<style>.$lang{background-color:#aecdff; color:#000;}</style>"; ?>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>
