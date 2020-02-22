<?php
	include_once("../config/config.php");
	include_once(URL_PATH."classes/mySqlDB__.class.php" );
	include_once(URL_PATH."classes/blog.class.php");
	include_once(URL_PATH."classes/banner.class.php");
	
	$bannerObj  = new banner();
	$blogObj 	  = new blog();
	
	/* FOOTER */
	$inTheNews  	= $blogObj->getFotterNewsList();
	$latestAlbums	= $bannerObj->getLatestAlbums();
?>
<div id="container">
    <div id="header">
		<form method="post" action="<?php echo DOMAIN;?>gallery/page/search/" id="search_form">
			<input type="text" name="words" value="" id="search_input" />
			<a href="javascript: toggle('searchextrashow');"><img src="/gallery/zp-core/images/searchfields_icon.png" alt="select search fields" id="searchfields_icon" /></a>
			<input type="submit" value="Search" id="search_submit"  />
			<input type="hidden" name="inalbums" value="" />
			<br />
			<ul style="display:none;" id="searchextrashow">
				<li><label><input id="_SEARCH_2048" name="_SEARCH_2048" type="checkbox" checked="checked"  value="2048"  /> Aperture</label></li>
				<li><label><input id="_SEARCH_256" name="_SEARCH_256" type="checkbox" checked="checked"  value="256"  /> Camera Maker</label></li>
				<li><label><input id="_SEARCH_512" name="_SEARCH_512" type="checkbox" checked="checked"  value="512"  /> Camera Model</label></li>
				<li><label><input id="_SEARCH_32" name="_SEARCH_32" type="checkbox" checked="checked"  value="32"  /> City</label></li>
				
				<li><label><input id="_SEARCH_128" name="_SEARCH_128" type="checkbox" checked="checked"  value="128"  /> Country</label></li>
				<li><label><input id="_SEARCH_2" name="_SEARCH_2" type="checkbox" checked="checked"  value="2"  /> Description</label></li>
				<li><label><input id="_SEARCH_16384" name="_SEARCH_16384" type="checkbox" checked="checked"  value="16384"  /> Exposure Compensation</label></li>
				<li><label><input id="_SEARCH_8" name="_SEARCH_8" type="checkbox" checked="checked"  value="8"  /> File/Folder name</label></li>
				<li><label><input id="_SEARCH_4096" name="_SEARCH_4096" type="checkbox" checked="checked"  value="4096"  /> Focal Length</label></li>
				<li><label><input id="_SEARCH_8192" name="_SEARCH_8192" type="checkbox" checked="checked"  value="8192"  /> ISO Sensitivity</label></li>
				
				<li><label><input id="_SEARCH_16" name="_SEARCH_16" type="checkbox" checked="checked"  value="16"  /> Location</label></li>
				<li><label><input id="_SEARCH_1024" name="_SEARCH_1024" type="checkbox" checked="checked"  value="1024"  /> Shutter Speed</label></li>
				<li><label><input id="_SEARCH_64" name="_SEARCH_64" type="checkbox" checked="checked"  value="64"  /> State</label></li>
				<li><label><input id="_SEARCH_4" name="_SEARCH_4" type="checkbox" checked="checked"  value="4"  /> Tags</label></li>
				<li><label><input id="_SEARCH_1" name="_SEARCH_1" type="checkbox" checked="checked"  value="1"  /> Title</label></li>
			</ul>
			<p><a href="<?php echo DOMAIN;?>place_your_events_on_our_calendar.html">Place Your Events On Hour Calendar</a></p>
            <p><a href="<?php echo DOMAIN;?>blog/about_us.html">About Anyweh.com</a> | <a href="<?php echo DOMAIN;?>blog/category/fashionista">Fashionista</a></p>
		</form>

        <!--form action="http://www.google.com.jm/cse" id="cse-search-box" target="_blank">
            <input type="hidden" name="cx" value="partner-pub-7769573252573851:w0tbpopdhgd" />
            <input type="hidden" name="ie" value="ISO-8859-1" />
            <input type="text" name="q" size="23" />
            <input type="submit" name="sa" value="Search" />
            <p><a href="<?php echo DOMAIN;?>place_your_events_on_our_calendar.html">Place Your Events On Hour Calendar</a></p>
            <p><a href="<?php echo DOMAIN;?>blog/about_us.html">About Anyweh.com</a> | <a href="<?php echo DOMAIN;?>blog/category/fashionista">Fashionista</a></p>
        </form-->
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
            <a id="c_date" href="<?php echo DOMAIN;?>events.html" title="view events calendar"><?php echo date("d");?></a>
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