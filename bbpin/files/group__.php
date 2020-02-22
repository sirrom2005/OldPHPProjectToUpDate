<?php
include_once("config/config.php");
include_once(DOCROOT."includes/languages/$lang.php");
if(!isset($_SESSION['BBPINWORLD']) || empty($_SESSION['BBPINWORLD'])){ header("location: login.php"); return;}
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
$obj = new site();

$groupId 	= $_GET['id'];
$rs 		= $obj->getGroupInfo($groupId);
$interest 	= $obj->getUserInterest($groupId);
$proImg 	= $obj->getGroupPhotos($groupId);
$comments 	= $obj->getGroupComments($groupId);
$locPre		= '';
if(isset($_SESSION['BBPINWORLD'])){
	$loggedInUser = $_SESSION['BBPINWORLD']['id'];
}
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>">
<head>  
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="join the blackberry messenger group <?php echo $rs['group_name'];?>">
<meta name="description" content="<?php echo str_replace('"',"'",cleanString($rs['group_detail']));?>">
<meta name="keywords" content="jusbbmpins,blackberry,messenger,bbm,pinshare,connect,groups,black,berry,pin,request">
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>JusBBmPins.com :: bkackberry group <?php echo $rs['group_name'];?></title>
<link href="styles/layout.css" rel="stylesheet" type="text/css">
<link href="styles/profile.css" rel="stylesheet" type="text/css">
<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="styles/IE.css" />
<![endif]-->
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5039d3134bebc572"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<!--[if lt IE 9]>
	<script type="text/javascript" src="js/excanvas/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="js/spinners/spinners.js"></script>
<script type="text/javascript" src="js/lightview/lightview.js"></script>
<link rel="stylesheet" type="text/css" href="styles/lightview/lightview.css" />
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
    	<span id="topLink">
        	<b>Hello <?php echo $_SESSION['BBPINWORLD']['fname'];?>!,</b> <a href="<?php echo DOMAIN;?>change-password.html"><?php echo $locale['change.password'];?></a> &bull; <a href="logout.php"><?php echo $locale['logout'];?></a>
            <br><a class="en" title="view in website english" href="javaScript:setLang('en');">en</a><a class="es" title="view in website spanish" href="javaScript:setLang('es');">es</a><a class="fr" title="view in website french" href="javaScript:setLang('fr');">fr</a>
        </span>
        <a href="<?php echo DOMAIN;?>" title="Go to <?php echo SITE_NAME;?> home page" class="logo"></a>
        <ul id="menu">
            <li><a href="<?php echo DOMAIN;?>"><?php echo $locale['menu.home'];?></a></li>
            <li><a href="<?php echo DOMAIN;?>find-bbm-contact.html"><?php echo $locale['menu.find.people'];?></a></li>
            <li><a href="<?php echo DOMAIN;?>find-bbm-groups.html"><?php echo $locale['menu.find.groups'];?></a></li>
            <li><a href="<?php echo DOMAIN;?>messages.html" class="<?php echo (isset($_SESSION['BBPINWORLD']['newMessage']) && $_SESSION['BBPINWORLD']['newMessage']=='yes')? 'highlight' : '' ;?>" ><?php echo $locale['menu.messages'];?></a></li>
            <li><a href="<?php echo DOMAIN;?>pin-request.html"><?php echo $locale['menu.pin.request'];?></a></li>
            <li><a href="<?php echo DOMAIN;?>profile.html"><?php echo $locale['menu.my.profile'];?></a></li>
        </ul>
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
    </div>
    <br clear="all">
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
    	<?php include_once('includes/group.php'); ?>
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
<script language="javascript">
$('#sendcomment').bind('click', function(){
	var txt = $('#message').val();
	if(isEmpty(txt)){return false;}
	$('#ldr').css('visibility','visible'); 
	$('#sendcomment').attr('disabled',true);
  	$.get("includes/ajx_gca.php",{ti:txt,g:<?php echo $groupId;?>},
		function(data){
			$('#comments').prepend(data);
			$('#message').val('');
			$('#sendcomment').attr('disabled',false);
			$('#ldr').css('visibility','hidden');
		}
	);
});
function removePost(id){
	if(confirm('You are about to delete this post')){
		$.get("includes/ajx_gcd.php",{i:id},
		function(data){
				$('#cmm' + id).remove();
			}
		);
	}
} 
</script>
<script type="text/javascript" src="js/global.js"></script>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>