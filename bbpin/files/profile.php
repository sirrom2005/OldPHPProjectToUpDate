<?php 
include_once("config/config.php"); //echo "<pre>";print_r($_SESSION['BBPINWORLD']);
include_once(DOCROOT."includes/languages/$lang.php");
$loggedInUser = NULL;
if(isset($_SESSION['BBPINWORLD'])){
	$sesionStr = "<b>".$locale['hello']." {$_SESSION['BBPINWORLD']['fname']}!,</b> <a href='".DOMAIN."change-password.html'>".$locale['change.password']."</a> &bull; <a href='logout.php'>".$locale['logout']."</a>"; 
}else{
	$sesionStr = "<a href='".DOMAIN."login.php'>".$locale['login']."</a>";
}
$userId = (isset($_GET['id']))? $_GET['id'] : $_SESSION['BBPINWORLD']['id'];

if($layout=="mobile"){
	echo '<link href="styles/dds.css" rel="stylesheet" type="text/css">';
}
                
if(isset($_GET['id'])){
	if( file_exists("cache/$lang/profile_{$userId}.html") ){
		include("cache/$lang/profile_{$userId}.html"); 		
		postHTML();
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
<meta name="title" content="meet <?php echo $fullname;?> on jusbbmpins.com | the blackberry pin yellow page">
<meta name="description" content="view <?php echo $fullname;?> blackberry profile on jusbbmpins.com, share blackberry messenger pins, meet new interesting people to connect and chat with on your blackberry messenger, join now, fast, free, and easy. connecting the world one pin at a time">
<meta name="keywords" content="blackberry,messenger,pin,bbm,pinshare,connect,groups,share,black,berry,request">
<meta name="generated" content="<?php echo date('l, F d Y. h:i:s a');?>" />
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>JusBBmPins.com :: meet <?php echo $fullname;?> on jusbbmpins.com | the blackberry pin yellow page</title>
<script type="text/javascript" src="js/jquery.js"></script>
<link href="styles/layout1.1.css" rel="stylesheet" type="text/css">
<link href="styles/profile.css" rel="stylesheet" type="text/css">
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
	<div>
    	<span id="topLink">
        	<a href="<?php echo DOMAIN;?>index.php" title="<?php echo $locale['goto.home'];?>" class="logo"></a>
            <span>&nbsp;</span>
        </span>
		<ul id="menu">
            <li class="mhome" id="mhome" style="border-left:solid 1px #FFFFFF;"><a title="<?php echo $locale['goto.home'];?>" href="<?php echo DOMAIN;?>"><?php echo $locale['menu.home'];?></a></li>
            <li class="mfindpins"><a title="<?php echo strtolower($locale['menu.find.people']);?>" href="<?php echo DOMAIN;?>find-bbm-contact.html"><?php echo $locale['menu.find.people'];?></a></li>
            <li><a title="<?php echo strtolower($locale['menu.find.groups']);?>" href="<?php echo DOMAIN;?>find-bbm-groups.html"><?php echo $locale['menu.find.groups'];?></a></li>
            <li><a title="<?php echo strtolower($locale['menu.messages']);?>" href="<?php echo DOMAIN;?>messages.html" class="<?php echo (isset($_SESSION['BBPINWORLD']['newMessage']) && $_SESSION['BBPINWORLD']['newMessage']=='yes')? 'highlight' : '' ;?>" ><?php echo $locale['menu.messages'];?></a></li>
            <li><a title="<?php echo strtolower($locale['menu.pin.request']);?>" href="<?php echo DOMAIN;?>pin-request.html"><?php echo $locale['menu.pin.request'];?></a></li>
            <li><a title="<?php echo strtolower($locale['menu.my.profile']);?>" href="<?php echo DOMAIN;?>profile.html"><?php echo $locale['menu.my.profile'];?></a></li>
        </ul>
    </div>
</div>
<div id="container">
    <div id="infobar" class="boxStyle1">
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_facebook_like"></a>
        <a class="addthis_button_tweet"></a>
        </div>
        <!-- AddThis Button END -->
        <div class="gallery">
            <?php
                if($proImg)
                {
                    $imgLoc = 'images/profile/'.$userId.'/';
                    $imgPre = 250;
                    foreach($proImg as $row){ 
            ?>
                        <a href="profile-photo-<?php echo $userId;?>-<?php echo $row['image_name'];?>.html" ><img src="<?php echo $imgLoc.$imgPre.'_'.$row['image_name'];?>" class="img<?php echo $imgPre;?>" title="<?php echo strtolower($fullname);?> profile picture" alt="<?php echo strtolower($fullname);?>" /></a>
            <?php 
                        $imgPre = 80;
                    }
                }
                else{
                    echo "<img src='".DOMAIN."images/profile/".strtolower($rs['gender'])."_silhouette.jpg' alt='' title='' class='img250' />";
                } 
            ?>
            <?php if($loggedInUser == $userId){ ?>
                <a class="linkStyle1" href="<?php echo DOMAIN;?>edit-profile.html"><?php echo $locale['edit.profile'];?></a>
                <a class="linkStyle1" href="<?php echo DOMAIN;?>edit-my-gallery.html"><?php echo $locale['edit.gallery'];?></a>
                <a class="linkStyle1" href="<?php echo DOMAIN;?>add-bbm-group.html"><?php echo $locale['add.bbm.group'];?></a>
                <a class="linkStyle1" href="<?php echo DOMAIN;?>your-group.html">Edit/Delete Your BBM Group</a>
            <?php }else{
            ?>
                <a class="linkStyle1" onClick="location='<?php echo DOMAIN;?>index.php?action=send-message&id=<?php echo $userId;?>'"><?php echo $locale['send.message'];?></a>
                <a class="linkStyle1" onClick="location='<?php echo DOMAIN;?>index.php?action=request-pin&id=<?php echo $userId;?>&ed=<?php echo base64_encode(base64_encode($rs['email']));?>'"><?php echo $locale['request.bbm.pin'];?></a>
            <?php
                } 
            ?>
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
    </div>
    <div id="content"><?php if($rs){ include('includes/profile.php'); }else{ echo "<span class='warning'>Profile not found...</span>";}  ?></div>
	<?php include_once('includes/footer.php'); ?>
</div>
<script language="javascript">
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
		$("#reply"+this.id+"Div").html("<p><textarea id='replyTxt"+this.id+"'></textarea></p><p align='right'><input type='button' id='sendreply' value='Reply' class='button' onclick='sendReply("+this.id+")' /><img src='images/loading.gif' class='ldr' /></p>");
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
<?php echo "<style>.$lang{background-color:#aecdff; color:#000;}</style>"; ?>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>
<?php
	if(isset($_GET['id'])){
		$fp=fopen(DOCROOT."cache/$lang/profile_{$userId}.html",'w'); 
		$cachecontents=ob_get_contents();
		$cachecontents = str_replace("\t",'',$cachecontents);
		//$cachecontents = str_replace('   ','',$cachecontents);
		$cachecontents = str_replace("\r\n",'',trim($cachecontents));
		fwrite($fp,$cachecontents,strlen($cachecontents));
		fclose($fp);
		ob_end_flush();
		chmod(DOCROOT."cache/$lang/profile_{$userId}.html",0755);
	}
	echo "<script>$('#topLink span').html(\"$sesionStr\");</script>";
	postHTML();
	function postHTML(){
		global $rs,$userId;
?>
		<script>
        $('#sendcomment').bind('click', function(){
            var txt = $('#message').val();
            if(isEmpty(txt)){return false;}
            $('#ldr').css('visibility','visible'); 
            $('#sendcomment').attr('disabled',true);
            $.get("includes/ajx_ca.php",{ti:txt,s:<?php echo (isset($_SESSION['BBPINWORLD']['id']))? $_SESSION['BBPINWORLD']['id'] : 0;?>,p:<?php echo $userId;?>,e:"<?php echo base64_encode($rs['email']);?>" },
                function(data){
                    $('#comments').prepend(data);
                    $('#message').val('');
                    $('#sendcomment').attr('disabled',false);
                    $('#ldr').css('visibility','hidden');
                }
            );
        });
        </script>	
<?php
	}
?>