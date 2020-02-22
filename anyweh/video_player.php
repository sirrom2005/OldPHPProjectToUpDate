<?php 
	include_once("config/global.php"); 
	include_once("config/config.php"); 
	include_once("classes/mySqlDB__.class.php" );
	include_once("classes/banner.class.php");
	
	$bannerObj 	= new banner();
	$id 		= $_GET['id'];
	$rs 		= $bannerObj->getVideoById($id);
	$ads 		= $bannerObj->getVideoBanner();

	$filename 	= explode(".", $rs['filename']);
	$filename	= $filename[0];
	$image		= (fileExists("gallery/albums/videos/images/$filename.jpg"))? "$filename.jpg" : "video_default.jpg";	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="EXPIRES" CONTENT="Mon, 22 Jul 2002 11:12:01 GMT" />
<meta http-equiv="PRAGMA" CONTENT="NO-CACHE" />
<meta name="Author" content="Rohan (Iceman) Morris : sirrom2005@gmail.com" />
<meta name="sitename" content="www.anyweh.com" />
<meta name="copyright" content="Anyweh.com <?php echo date("Y"); ?>" />
<meta name="language" content="en" />
<meta http-equiv="keywords" name="keywords" content="jamaica, jamaican, video, videos, party, events, event" />
<meta http-equiv="description" name="description" content="jamaica anyweh video player, anywah videos, jamaica video, how jamaican people party, anyweh.com video, anyweh party video" />
<style>
html{height:100%;}
body{margin:0;padding:0; height:100%; background:#000000;}
<?php
for($i=0; $i<count($ads); $i++)
{
	$logo_type	= $ads[$i]['banner_file_type'];
	$ext 		= str_replace("image/", "", $logo_type);
	$imgname 	= "images/tmp_ads/{$ads[$i]['id']}_{$ads[$i]['banner_size']}.$ext";
	echo "#ads{$i}{background:url($imgname) fixed 0 22px;}";
}
?>
#menu{background-color:#000000; text-align:center;}
#menu a{color:#31A431; font-size:1em; font-weight:bold; text-transform:uppercase; text-decoration:none; padding:2px 3px 2px 3px; display:inline-block;}
#menu a:hover{background-color:#ff0000; color:#FFFFFF;}
h1{text-align:center; font-size:1em; margin:0; padding:0 0 4px 0; color:#FFFFFF; text-transform:uppercase; }
h2{font-size:0.8em; font-weight:normal; margin:0; padding:0 0 0 30px; color:#FFFFFF;  }
#player{position:absolute;z-index:100;width:100%;}
#area{ width:470px; background-color:#000000; margin:0 auto;}
#videoPlayerAds{ width:468px; margin:0 auto; border:solid 1px #999999; background-color:#FFFFFF; }

.scrollable 
{
	/* required settings */
	position:relative;
	overflow:hidden;
	height:100%;
}
/*
	root element for scrollable items. Must be absolutely positioned
	and it should have a extremely large width to accommodate scrollable items.
	it's enough that you set width and height for the root element and
	not for this element.
*/
.scrollable .items {
	/* this cannot be too large */
	width:30000em;
	position:absolute;
	height:100%;
}
/*
	a single item. must be floated in horizontal scrolling.
	typically, this element is the one that *you* will style
	the most.
*/
.items div
{
	float:left;
	width:1%;
	height:100%;
}
</style>
<title>Anyweh.com : <?php echo cleanString($rs['title']); ?></title>
</head>
<body>
<div id="player">
    <div id="menu">
        <a href="<?php echo DOMAIN;?>index.html" title="www.anyweh.com">Home</a>
        <a href="<?php echo DOMAIN;?>party_videos.html" title="party and music video page">Videos</a>  
        <a href="<?php echo DOMAIN;?>gallery/" title="photo gallery">Gallery</a>
        <a href="<?php echo DOMAIN;?>blog/" title="Entertainment News">Entertainment News</a>
        <a href="<?php echo DOMAIN;?>events_calendar.html" title="events and party calendar">Calendar</a>
        <a href="<?php echo DOMAIN;?>advertise_with_us.html" title="advertise with us now!!!">Advertise With Us</a>
    </div>
	<div id="area">
        <h1><?php echo cleanString($rs['title']); ?></h1>
        <div id="videoPlayerAds">
            <script type="text/javascript"><!--
            google_ad_client = "pub-7769573252573851";
            /* wide_image_banner */
            google_ad_slot = "7284682713";
            google_ad_width = 468;
            google_ad_height = 60;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
            
            <script type="text/javascript"><!--
            google_ad_client = "pub-7769573252573851";
            /* blog_468x15_ad_links */
            google_ad_slot = "0424525984";
            google_ad_width = 468;
            google_ad_height = 15;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
        </div>
        <div name="mediaspace" id="mediaspace"><a href="http://www.adobe.com/go/getflashplayer">get flash player</a></div>
    </div>
</div>
<div class="scrollable">
<div class="items">
<?php
for($i=0; $i<count($ads); $i++)
{
	echo "<div id='ads{$i}'></div>";
}
?>
</div>
</div>
</body>

<script language="javascript" type="text/javascript" src="<?php echo DOMAIN; ?>js/swfobject.js"></script>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
var s1 = new SWFObject("flash/videoplayer/player.swf","tv","468","350","8","#000000");
s1.addParam("allowfullscreen","true");
s1.addParam("wmode","transparent");
s1.addParam("allowscriptaccess","always");
s1.addVariable('file', "<?php echo DOMAIN; ?>gallery/albums/videos/<?php echo $rs['filename']; ?>");
s1.addVariable("skin", "<?php echo DOMAIN;?>player/modieus/modieus.swf");
s1.addVariable('autostart', 'true');
s1.addVariable('title', "<?php echo $rs['title'];?>");
s1.addVariable("channel", "15329");
s1.addVariable('plugins', 'rateit-2,ltas'); //dsharing-1
s1.addVariable('dsharing.sharetoolbar', false);	
s1.addVariable('dsharing.thumb', 'gallery/albums/videos/images/<?php echo $image;?>');	
s1.write("mediaspace");
/* ]]> */
</script>
<script language="JavaScript" src="http://www.ltassrv.com/serve/api5.4.asp?d=43636&s=19772&c=15329&v=1"></script>
<script language="javascript" type="text/javascript" src="js/jquery.custom.js"></script>
<?php if(count($ads)>1){ ?>
<script type="text/javascript">
// execute your scripts when the DOM is ready. this is mostly a good habit
$(function() {
	// initialize scrollable
	$(".scrollable").scrollable({circular:true,mousewheel:false}).autoscroll({autoplay:true,interval:10000,autopause:true});
});
</script>
<?php } ?>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-5576813-1");
pageTracker._trackPageview();
</script>
</html>