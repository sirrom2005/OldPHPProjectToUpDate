<?php 
include_once("config/config.php");
include_once(DOCROOT."includes/languages/$lang.php");
$loggedInUser = NULL;
if(isset($_SESSION['BBPINWORLD'])){
	$sesionStr = "<b>".$locale['hello']." {$_SESSION['BBPINWORLD']['fname']}!,</b> <a href='".DOMAIN."change-password.html'>".$locale['change.password']."</a> &bull; <a href='logout.php'>".$locale['logout']."</a>"; 
}else{
	$sesionStr = "<a href='".DOMAIN."login.php'>".$locale['login']."</a>";
}

$userId = (isset($_GET['id']))? $_GET['id'] : $_SESSION['BBPINWORLD']['id'];

if(isset($_GET['id'])){
	if( file_exists("cache/$lang/profile_{$userId}.html") ){
		include("cache/$lang/profile_{$userId}.html"); 		
		exit("<script>$('#topLink span').html(\"$sesionStr\");</script>");
	}
	/*header("Vary: Accept-Encoding");
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
	ob_start('ob_gzhandler');
	else*/
	ob_start();
}else{
	if(isset($_SESSION['BBPINWORLD'])){
		$loggedInUser = $_SESSION['BBPINWORLD']['id'];
	}
	else{
		header("location: login.php");
	}
}

include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
$obj = new site();

$rs 		= $obj->getProfileInfo($userId);
$proImg 	= $obj->getProfilePhotos($userId);
$lookFor 	= $obj->getUserLookFor($userId);
$interest 	= $obj->getUserInterest($userId);
$comments 	= $obj->getProfileComments($userId);
$fullname 	= trim($rs['fname'].' '.$rs['lname']);
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>">
<head>  
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="meet <?php echo $fullname;?> on jusbbmpins.com">
<meta name="description" content="view <?php echo $fullname;?> blackberry profile on jusbbmpins.com, share blackberry messenger pins, meet new interesting people to connect and chat with on your blackberry messenger, join now, fast, free, and easy. connecting the world one pin at a time">
<meta name="keywords" content="blackberry,messenger,pin,bbm,pinshare,connect,groups,share,black,berry,request">
<meta name="generated" content="<?php echo date('l, F d Y. h:i:s a');?>" />
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>JusBBmPins.com :: meet <?php echo $fullname;?> on jusbbmpins.com</title>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<!--[if lt IE 9]>
	<script type="text/javascript" src="js/excanvas/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="js/spinners/spinners.js"></script>
<script type="text/javascript" src="js/lightview/lightview.js"></script>
<link rel="stylesheet" type="text/css" href="styles/lightview/lightview.css" />
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5039d3134bebc572"></script>
<link href="styles/layout.css" rel="stylesheet" type="text/css">
<link href="styles/profile.css" rel="stylesheet" type="text/css">
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
    	<span id="topLink">
        	<span><?php echo $sesionStr;?></span>
            <br><a class="en" title="view in website english" href="javaScript:setLang('en');">en</a><a class="es" title="view in website spanish" href="javaScript:setLang('es');">es</a><a class="fr" title="view in website french" href="javaScript:setLang('fr');">fr</a>
        </span>
        <a href="<?php echo DOMAIN;?>" title="<?php echo $locale['goto.home'];?>" class="logo"></a>
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
    	<?php if($rs){ include('includes/profile.php'); }else{ echo "<span class='warning'>Profile not found...</span>";}  ?>
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
  	$.get("includes/ajx_ca.php",{ti:txt,s:<?php echo $_SESSION['BBPINWORLD']['id'];?>,p:<?php echo $userId;?>,e:"<?php echo base64_encode($rs['email']);?>" },
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
		$.get("includes/ajx_cd.php",{i:id},
		function(data){
				$('#cmm' + id).remove();
			}
		);
	}
} 

$(".reply").toggle(function(){
		$("#reply"+this.id+"Div").html("<p><textarea id='replyTxt"+this.id+"'></textarea></p><p align='right'><input type='button' id='sendreply' value='reply' onclick='sendReply("+this.id+")' /><img src='images/loading.gif' class='ldr' /></p>");
	},
	function(){ $("#reply"+this.id+"Div").html(""); }
);

function sendReply(id){
	var txt = $("#replyTxt"+id).val();
	if(isEmpty(txt)){return false;}
	$("#reply"+id+"Div .ldr").css('visibility','visible'); 
	$("#reply"+id+"Div #sendreply").attr('disabled',true);
	$.get("includes/ajx_cr.php",{ti:txt,cid:id},
		function(data){
			$('#comments').prepend(data);
			$("#reply"+id+"Div").html("");
		}
	);
}
</script>
<script type="text/javascript" src="js/global.js"></script>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>
<?php
	if(isset($_GET['id'])){
		$fp=fopen(DOCROOT."cache/$lang/profile_{$userId}.html",'w'); 
		$cachecontents=ob_get_contents();
		$cachecontents = str_replace("\t",'',$cachecontents);
		//$cachecontents = str_replace('  ','',$cachecontents);
		$cachecontents = str_replace("\r\n",'',trim($cachecontents));
		fwrite($fp,$cachecontents,strlen($cachecontents));
		fclose($fp);
		ob_end_flush();
		chmod(DOCROOT."cache/$lang/profile_{$userId}.html",0755);
	}
?>