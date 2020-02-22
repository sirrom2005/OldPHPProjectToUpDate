	<?php if(!$imagePage){ ?>
    <div id="wid_ads">
		<iframe frameborder="0" width="160" height="600" scrolling="no" style="border:0px;" src="<?php echo DOMAIN;?>includes/banners_pages.php?adsspace=3"></iframe>
    </div>
    <?php }else{ ?>
    <div id="nor_ads">
		<script type="text/javascript"><!--
        google_ad_client = "pub-7769573252573851";
        /* 160_600_image_ads */
        google_ad_slot = "4420278418";
        google_ad_width = 160;
        google_ad_height = 600;
        //-->
        </script>
        <script type="text/javascript"
        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
    </div>
    <?php } ?>
	<!--END OF ID CONTENT-->
    <div class="clear">&nbsp;</div>
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
				<?php 
				if(!empty($inTheNews))
				{
					foreach($latestAlbums as $row)
					{ 
				?>
                <li><a title="<?php echo $row['title']?>" href="<?php echo DOMAIN;?>gallery/<?php echo $row['folder']?>"><?php echo cleanString($row['title'], 5);?></a></li>
				<?php 
					}
				} 
				?>
            </ul>
            <ul id="nav3">
                <li><h3>In The News</h3></li>
                <?php 
				if(!empty($inTheNews))
				{
					foreach($inTheNews as $row){ 
				?>
                <li><a title="<?php echo $row['post_title']?>" href="<?php echo $row['guid']?>"><?php echo cleanString($row['post_title'], 5);?></a></li>
				<?php 
					} 
				}
				?>
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
    <div id="google_friend_connect">
        <!-- Include the Google Friend Connect javascript library. -->
        <script type="text/javascript" src="http://www.google.com/friendconnect/script/friendconnect.js"></script>
        <!-- Define the div tag where the gadget will be inserted. -->
        <div id="div-8097365465331276142"></div>
        <!-- Render the gadget into a div. -->
        <script type="text/javascript">
        var skin = {};
        skin['BORDER_COLOR'] = '#cccccc';
        skin['ENDCAP_BG_COLOR'] = '#e0ecff';
        skin['ENDCAP_TEXT_COLOR'] = '#333333';
        skin['ENDCAP_LINK_COLOR'] = '#0000cc';
        skin['ALTERNATE_BG_COLOR'] = '#ffffff';
        skin['CONTENT_BG_COLOR'] = '#ffffff';
        skin['CONTENT_LINK_COLOR'] = '#0000cc';
        skin['CONTENT_TEXT_COLOR'] = '#333333';
        skin['CONTENT_SECONDARY_LINK_COLOR'] = '#7777cc';
        skin['CONTENT_SECONDARY_TEXT_COLOR'] = '#666666';
        skin['CONTENT_HEADLINE_COLOR'] = '#333333';
        skin['POSITION'] = 'bottom';
        skin['DEFAULT_COMMENT_TEXT'] = '- add your comment here -';
        skin['HEADER_TEXT'] = 'Comments';
        google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
        google.friendconnect.container.renderSocialBar(
         { id: 'div-8097365465331276142',
           site: '07788010716203665169',
           'view-params':{"scope":"SITE","allowAnonymousPost":"true","features":"video,comment","showWall":"true"}
         },
          skin);
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