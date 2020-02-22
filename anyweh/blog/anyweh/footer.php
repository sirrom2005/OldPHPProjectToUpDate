	<!--END OF ID CONTENT-->
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
                <li><a title="<?php echo $row['title']?>" href="<?php echo DOMAIN;?>gallery/<?php echo $row['folder']?>"><?php echo cleanString($row['title'], 5);?></a></li>
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