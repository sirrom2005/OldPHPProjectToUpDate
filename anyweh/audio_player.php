<?php	
	include_once("config/global.php");
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
<meta http-equiv="description" name="description" content="jamaica anyweh audio plarer, any where audio, jamaica music player, how jamaican people party, anyweh.com video, anyweh video, any weh video, party video" />
<style>
body
{ 
	margin:0;
	padding:0;
	background-color:#333333;
}
h1{ text-align:center; font-size:1em; margin:0; padding:0 0 4px 0; color:#FFFFFF; text-transform:uppercase; }
h2{ font-size:0.8em; font-weight:normal; margin:0; padding:0 0 0 30px; color:#FFFFFF;  }
#player
{
	padding-top:5px;
	text-align:center;
}
#videoPlayerAds{ width:468px; height:75px; margin:0 auto; border:solid 1px #999999; background-color:#FFFFFF; }
</style>
<title>Anyweh.com : Audio Player</title>
</head>
<body id="audio_player">
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
    <script type="text/javascript" src="images/ads/page_ads.js"></script>
    <div id="player">
        <script language="javascript" type="text/javascript" src="<?php echo DOMAIN; ?>player/swfobject.js"></script>
        <div name="mediaspace" id="mediaspace"><a href="http://www.adobe.com/go/getflashplayer">get flash player</a></div>
        <script language="javascript" type="text/javascript">
        /* <![CDATA[ */
        var s1 = new SWFObject("player/player.swf","tv","468","250","8","#000000");
        s1.addParam("allowfullscreen","true");
		s1.addParam("allowscriptaccess","always");
		s1.addParam("wmode","transparent");
        s1.addVariable("channel", "17535");
		s1.addVariable("plugins", "revolt-1,ltas");
		s1.addVariable("file", "<?php echo DOMAIN;?>gallery/albums/videos/audio_player.xml");
		s1.addVariable("repeat", "list");
		s1.addVariable("autostart", "true");
		s1.addVariable("skin", "<?php echo DOMAIN;?>player/modieus/modieus.swf");
	   	s1.write("mediaspace");
        /* ]]> */
        </script>
	<script language="JavaScript" src="http://www.ltassrv.com/serve/api5.4.asp?d=43636&s=22693&c=17535&v=1"></script>
    </div>
</body>

<script type="text/javascript">
	function setCookie(c_name,value,expiredays)
	{
		var exdate=new Date();
		exdate.setDate(exdate.getDate()+expiredays);
		document.cookie=c_name+ "=" +escape(value)+
		((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
	}
	setCookie('player','open_player',1);
</script>
</html>