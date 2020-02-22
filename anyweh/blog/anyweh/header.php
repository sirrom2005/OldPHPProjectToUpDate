<?php
	/*header("Vary: Accept-Encoding");
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
	ob_start('ob_gzhandler');
	else ob_start();*/
	
	include_once("../config/global.php");
	include_once("../config/config.php");
	include_once(URL_PATH."classes/mySqlDB__.class.php" );
	include_once(URL_PATH."classes/blog.class.php");
	include_once(URL_PATH."classes/banner.class.php");
 	
	$bannerObj 	  = new banner();
	$blogObj 	  = new blog();
	
	/* FOOTER */
	$inTheNews  	= $blogObj->getFotterNewsList();
	$latestAlbums	= $bannerObj->getLatestAlbums(); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<meta name="Author" content="Rohan (Iceman) Morris : sirrom2005@gmail.com" />
<meta name="sitename" content="www.anyweh.com" />
<meta name="copyright" content="Anyweh.com <?php echo date("Y"); ?>" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com blog rss feed" href="http://feeds.feedburner.com/AnywehcomBlog" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com photo gallery rss feed" href="http://feeds.feedburner.com/AnywehcomPhotoGallery" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com comment rss feed" href="http://www.anyweh.com/blog/comments/feed" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>
<style type="text/css"> 
<!-- 
@import url("<?php bloginfo('stylesheet_url'); ?>");
@import url("<?php echo DOMAIN;?>/css/layout.css");

-->
</style>
<?php wp_head(); ?>
</head>
<body>
	<div id="container">
		<div id="header">
        	<form method="get" id="searchform" action="<?php echo DOMAIN;?>blog/">
                <input value="" name="s" id="s" type="text" size="23">
            	<input id="searchsubmit" value="Search" type="submit">
                <label class="hidden" for="s">Search for:</label>
			<!--form action="http://www.google.com.jm/cse" id="cse-search-box" target="_blank">
				<input type="hidden" name="cx" value="partner-pub-7769573252573851:w0tbpopdhgd" />
				<input type="hidden" name="ie" value="ISO-8859-1" />
				<input type="text" name="q" size="23" />
				<input type="submit" name="sa" value="Search" /-->
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
				<li><a href="<?php echo DOMAIN;?>events_calendar.html" title="events and party calendar">Calendar</a></li>
				<li class="nostyle"><a href="<?php echo DOMAIN;?>advertise_with_us.html" title="advertise with us now!!!">Advertise With Us</a></li>
			</ul>
		</div>
		<a href="<?php echo DOMAIN;?>index.html" id="logo" title="www.anyweh.com"></a>
		<div id="page_window">
			<ul>
            <li id="largebannerplayer"></li>
            <li>
                <a id="c_date" href="<?php echo DOMAIN;?>events_calendar.html" title="view events calendar"><?php echo date("d");?></a>
                <a id="fbook" href="http://www.facebook.com/pages/ANYWEH-Entertainment/121680584528878" title="anyweh.com is on Facebook" target="_blank"></a>
				<a id="twitter" href="http://twitter.com/#!/anywehent" title="anyweh.com is on twitter" target="_blank"></a>
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
        <!--BEGIN OF ID CONTENT-->