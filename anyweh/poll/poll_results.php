<?php	
	header("Vary: Accept-Encoding");
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
	ob_start('ob_gzhandler');
	else ob_start();
	
	include_once("../config/global.php");
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php" );
	include_once("../classes/blog.class.php");
	include_once("../classes/banner.class.php");
	
	$bannerObj 	  = new banner();
	$blogObj 	  = new blog();
	
	/* FOOTER */
	$inTheNews  	= $blogObj->getFotterNewsList();
	$latestAlbums	= $bannerObj->getLatestAlbums();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Author" content="Rohan (Iceman) Morris : sirrom2005@gmail.com" />
<meta name="sitename" content="www.anyweh.com" />
<meta name="copyright" content="Anyweh.com <?php echo date("Y"); ?>" />
<meta name="language" content="en" />
<meta http-equiv="keywords" name="keywords" content="<?php echo $pageKeywords.META_KEY;?>" />
<meta http-equiv="description" name="description" content="<?php echo $pageDescription.META_DESC; ?>" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com blog rss feed" href="http://feeds.feedburner.com/AnywehcomBlog" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com photo gallery rss feed" href="http://feeds.feedburner.com/AnywehcomPhotoGallery" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com comment rss feed" href="http://www.anyweh.com/blog/comments/feed" />
<title>this week poll : www.anyweh.com </title>
<style type="text/css"> 
<!-- 
@import url("../css/layout.css");
@import url("../css/styles.css");
-->
</style>
<script>
var ads46860 = new Array("468x60_web_banner_example_6.gif", "468x60_web_banner_example_7.gif", "468x60_web_banner_example_4.gif");
</script>
</head>
<body>
	<div id="container">
		<div id="header">
			<form action="http://www.google.com.jm/cse" id="cse-search-box" target="_blank">
				<input type="hidden" name="cx" value="partner-pub-7769573252573851:w0tbpopdhgd" />
				<input type="hidden" name="ie" value="ISO-8859-1" />
				<input type="text" name="q" size="23" />
				<input type="submit" name="sa" value="Search" />
                <p><a href="<?php echo DOMAIN;?>place_your_events_on_our_calendar.html">Place Your Events On Our Calendar</a></p>
				<p><a href="<?php echo DOMAIN;?>blog/about_us.html">About Anyweh.com</a> | <a href="<?php echo DOMAIN;?>blog/category/fashionista">Fashionista</a></p>
			</form>
            <div style="width:468px; height:60px;">
            	<iframe frameborder="0" width="468" height="60" scrolling="no" src="<?php echo DOMAIN;?>includes/banners_pages.php?adsspace=1"></iframe>
            </div>
			<ul>
				<li><a href="<?php echo DOMAIN;?>index.html" title="www.anyweh.com">Home</a></li>
				<li><a href="<?php echo DOMAIN;?>party_videos.html" title="party and music video page">Videos</a></li>  
				<li><a href="<?php echo DOMAIN;?>gallery/" title="photo gallery">Gallery</a></li>
				<li><a href="<?php echo DOMAIN;?>blog/" title="Entertainment News">Entertainment News</a></li>
				<li><a href="<?php echo DOMAIN;?>events_calendar.html" title="events and party calendar">Party Calendar</a></li>
				<li><a href="<?php echo DOMAIN;?>advertise_with_us.html" title="advertise with us now!!!">Advertise With Us</a></li>
				<!--li><a href="<?php echo DOMAIN;?>advertise_with_us.html#contact" title="contact anyweh.com now!!!">Contact Us</a></li-->
			</ul>
		</div>
		<a href="<?php echo DOMAIN;?>index.html" id="logo" title="www.anyweh.com"></a>
		<div id="page_window">
			<ul>
            <li id="largebannerplayer"></li>
            <li>
                <a id="c_date" href="<?php echo DOMAIN;?>events_calendar.html" title="view events calendar"><?php echo date("d");?></a>
                <a id="fbook" href="http://www.facebook.com/pages/anywehcom/60987952780" title="anyweh.com is on Facebook" target="_blank"></a>
                <!--a id="feeds" href="http://www.anyweh.com/rss.html" title="anyweh.com rss feeds"></a-->
                <a id="buyads" href="#" title="buy advertising space using paypal"></a>
                <!--li><a href="#"><img src="images/photo-48x48.png" /></a></li> 
                <a href="#"><img src="images/blogroll-48x48.png" /></a-->
                <a id="mplayer" href="#" onclick="window.open('http://www.anyweh.com/audio_player.php', 'audio_player', 'width=470, height=335');" title="open media player" ></a>
                <a id="cmailer" href="<?php echo DOMAIN;?>advertise_with_us.html#contact" title="contact anyweh.com" ></a>      
            </li>
            </ul><div class="clear"></div>
            <noscript><center><a href="http://www.macromedia.com/go/getflashplayer" target="_blank">Get the Flash Player</a></center></noscript>
		</div>
		<div id="midads">
        	<iframe frameborder="0" width="728" height="90" scrolling="no" style="border:0px;" src="<?php echo DOMAIN;?>includes/banners_pages.php?adsspace=2"></iframe>
        </div>
		<div id="content">
        	<div id="includes">
				<h1>This Week Poll</h1>
					<?php
					include_once ("includes/miniPoll.class.php");
					include_once ("config.php");	
					$connection = mysql_connect ($host, $user, $pass) or die ("Unable to connect");
					mysql_select_db ($db) or die ("Unable to select database");
					?>
					<link href="style/poll.css" rel="stylesheet" type="text/css" />
					<?php
					$test = new miniPoll;
					
					if (isset($_GET['poll']) && is_numeric($_GET['pollid'])) 
					{
						$pollid = $_GET['pollid'];
					}
					if (isset($_GET['pollid'])) {
						$pollid = $_GET['pollid'];
						$test->pollResults($pollid);
					}
					
					if (isset($_GET['poll']) && is_numeric($_GET['pollid'])) 
					{
						$pollid = $_GET['pollid'];
					
						if (isset($_GET['voteid']) && is_numeric($_GET['voteid'])) {
							$voteid = $_GET['voteid'];
							$test->processPoll($pollid, $voteid);
						}
					
					}
					@mysql_close($connection);
					?>
			</div>
            <iframe frameborder="0" width="160" height="600" scrolling="no" style="border:0px;" src="<?php echo DOMAIN;?>includes/banners_pages.php?adsspace=3"></iframe>
            <div class="clear"></div>
        </div> 
	</div>
	<div id="footer">
    	<div> 
        	<span>All content Copyright 2009 www.anyweh.com. All Rights Reserved.<br />Text, images and all other content on this site may not be copied or republished in any way without formal permission.</span>
        </div> 
        <hr />
        <div>
            <ul id="nav1">
                <li><h3>Navigation</h3></li>
                <li><a title="home page" href="<?php echo DOMAIN;?>index.html">Anywah.com</a></li>
                <li><a title="about anyweh.com" href="<?php echo DOMAIN;?>blog/about_us">About Us</a></li>
                <li><a title="videos page" href="<?php echo DOMAIN;?>party_videos.html">Videos</a></li> 
                <li><a title="blog" href="<?php echo DOMAIN;?>blog/">Anyweh Blog</a></li>
                <li><a title="photo gallery" href="<?php echo DOMAIN;?>gallery/">Gallery</a></li>
                <li><a title="party calendar" href="<?php echo DOMAIN;?>events_calendar.html">Events Calendar</a></li>
                <li><a title="advertise with anyweh.com" href="<?php echo DOMAIN;?>advertise_with_us.html">Advertise</a></li>
                <li><a title="contact anyweh.com" href="<?php echo DOMAIN;?>advertise_with_us.html#contact">Contact Us</a></li>
                <li><a title="terms &amp; conditions" href="<?php echo DOMAIN;?>blog/terms-conditions">Terms &amp; Conditions</a></li>
                <li><a title="privacy policy" href="<?php echo DOMAIN;?>blog/privacy_policy">Privacy Policy</a></li>
                <li><a title="consumer information website" href="http://www.knowyourdiageodrink.com">DrinkIQ</a></li>
				<li><a title="rss Feeds" href="<?php echo DOMAIN;?>rss.html">Rss Feeds</a></li>
				<li><a title="sitemap" href="<?php echo DOMAIN;?>sitemap.html">Sitemap</a></li>
            </ul>
            <ul id="nav2">
                <li><h3>Latest Gallery Added</h3></li>
				<?php foreach($latestAlbums as $row){ ?>
                <li><a title="<?php echo $row['title']?>" href="gallery/<?php echo $row['folder']?>"><?php echo cleanString($row['title'], 5);?></a></li>
				<?php } ?>
            </ul>
            <ul id="nav3">
                <li><h3>In The News</h3></li>
                <?php foreach($inTheNews as $row){ ?>
                <li><a title="<?php echo $row['post_title']?>" href="<?php echo $row['guid']?>"><?php echo cleanString($row['post_title'], 5);?></a></li>
				<?php } ?>
            </ul>
        </div>
        <p>
        	<span>MISCELLANEOUS LINKS ::</span>
            <a href="<?php echo DOMAIN;?>gallery/page/archive" title="gallery Archive">Gallery Archive</a> | 
            Anyweh.com Photo Gallery Powered by <a href="http://www.zenphoto.org" title="A simpler web photo album" target="_blank">zenphoto</a> |
            <a href="<?php echo DOMAIN;?>blog/?m=2009" title="blog year 2009 archive">Blog 2009 Archive</a> | 
            Anyweh.com Blog is proudly powered by <a href="http://wordpress.org/" target="_blank" title="powered by WordPress">WordPress</a>
	     | <span><a href="http://www.rohanmorris.net/" target="_blank" title="the web developer">THE DEVELOPER</a></span>
        </p>
        <script language="javascript" type="text/javascript" src="<?php echo DOMAIN;?>js/swfobject.js"></script>
		<script type="text/javascript">
            var s4 = new SWFObject("<?php echo DOMAIN;?>flash/imagerotator/imagerotator.swf","rotator","830","295","7");
            s4.addParam("allowfullscreen","true");
            s4.addParam("wmode","transparent");
            s4.addVariable("file","<?php echo DOMAIN;?>images/ads/large_rotating_ads.xml");
            s4.addVariable("width","830");
            s4.addVariable("height","295");
 
			s4.write("largebannerplayer");
		</script>
    </div>
   
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-5576813-1");
pageTracker._trackPageview();
} catch(err) {}
</script>   
</body>
</html>