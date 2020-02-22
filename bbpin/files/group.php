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
$pageFBImg = ($proImg) ? 'images/profile/group_'.$groupId.'/'.$proImg[0]['image_name'] : 'images/profile/profile.png';
$thisURL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>">
<head>  
<meta property="og:title" content="join the (bbm) blackberry messenger group <?php echo $rs['group_name'];?>"/>
<meta property="og:url" content="<?php echo $thisURL;?>"/>
<meta property="og:image" content="<?php echo DOMAIN.$pageFBImg;?>"/>
<meta property="og:site_name" content="<?php echo SITE_NAME;?>"/>
<meta property="og:description" content="<?php echo str_replace('"',"'",substr(cleanHTML($rs['group_detail']),0,200));?>"/>
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="join the (bbm) blackberry messenger group <?php echo $rs['group_name'];?>">
<meta name="description" content="<?php echo str_replace('"',"'",substr(cleanHTML($rs['group_detail']),0,200));?>">
<meta name="keywords" content="jusbbmpins,blackberry,messenger,bbm,pinshare,group,black,berry,pin,request">
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>JusBBmPins.com :: blackberry group <?php echo $rs['group_name'];?></title>
<link href="styles/layout1.1.css" rel="stylesheet" type="text/css">
<link href="styles/profile.css" rel="stylesheet" type="text/css">
<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="styles/IE.css" />
<![endif]-->
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/swfobject.js"></script>
<!--[if lt IE 9]>
	<script type="text/javascript" src="js/excanvas/excanvas.js"></script>
<![endif]-->
<script type="text/javascript" src="js/spinners/spinners.js"></script>
<script type="text/javascript" src="js/lightview/lightview.js"></script>
<link rel="stylesheet" type="text/css" href="styles/lightview/lightview.css" />
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
        	<b><?php echo $locale['hello'];?> <?php echo $_SESSION['BBPINWORLD']['fname'];?>!,</b> <a href="<?php echo DOMAIN;?>change-password.html"><?php echo $locale['change.password'];?></a> &bull; <a href="logout.php"><?php echo $locale['logout'];?></a>
        </span>
		<ul id="menu">
            <li class="mhome" style="border-left:solid 1px #FFFFFF;"><a title="<?php echo $locale['goto.home'];?>" href="<?php echo DOMAIN;?>"><?php echo $locale['menu.home'];?></a></li>
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
        <?php if($_SESSION['BBPINWORLD']['id'] == $rs['groupUser']){ ?>
            <a class="linkStyle1" href="index.php?action=add-bbm-group&id=<?php echo $groupId;?>"><?php echo $locale['group.edit'];?></a>
            <a class="linkStyle1" href="index.php?action=edit-group-gallery&id=<?php echo $groupId;?>"><?php echo $locale['group.edit.gallery'];?></a>
        <?php }else{ ?>
            <a class="linkStyle1" href="index.php?action=group-request&groupid=<?php echo $groupId;?>&ge=<?php echo base64_encode(base64_encode($rs['email']));?>"><?php echo $locale['group.request'];?></a>
        <?php } ?>
		<?php 
            $imgLoc = $locPre.'images/profile/group_'.$groupId.'/';
            if($proImg)
            {
                $imgPre = 250;
                foreach($proImg as $row){ 
        ?>
                    <a target="_blank" href="<?php echo $imgLoc.$row['image_name'];?>" class="lightview" data-lightview-group="album" data-lightview-options="viewport:'scale'" data-lightview-title="<?php echo $row['description'];?>" ><img src="<?php echo $imgLoc.$imgPre.'_'.$row['image_name'];?>" alt="" title="" class="img<?php echo $imgPre;?>" /></a>
        <?php 
                    $imgPre = 80;
                }
            }
            else{
                echo "<img src='images/profile/profile.png' alt='' title='profile picture' class='img250' />";
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
    <div id="content"><?php include_once('includes/group.php'); ?></div>
	<?php include_once('includes/footer.php'); ?>
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
<?php echo "<style>.$lang{background-color:#aecdff; color:#000;}</style>"; ?>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>
