<script language="javascript" type="text/javascript" src="<?php echo DOMAIN;?>player/swfobject.js"></script>
<div id="header">
    <div id="siteMenu2">
    	<a href="<?php echo DOMAIN;?>index.html" title="www.anyweh.com :: anyweh di party deh..." id="homeLink"></a>
    	<div>
         	<li><a href="#"><img src="<?php echo DOMAIN;?>images/ads/small_ads1.jpg" align="right" height="80" width="150" /></a></li>
    		<li><a href="#"><img src="<?php echo DOMAIN;?>images/ads/small_ads2.jpg" align="right" height="80" width="150" /></a></li>
        </div>
       <ul>
        <li><a class="png" href="<?php echo DOMAIN;?>index.html" title="www.anyweh.com">Home</a></li>
        <li><a class="png" href="<?php echo DOMAIN;?>party_videos.html" title="party and music video page">Videos</a></li>  
        <li><a class="png" href="<?php echo DOMAIN;?>gallery/" title="photo gallery">Photo Gallery</a></li>
        <li><a class="png" href="<?php echo DOMAIN;?>blog/" title="Entertainment News">Entertainment News</a></li>
        <li><a class="png" href="<?php echo DOMAIN;?>events.html" title="events and party calendar">Events Calendar</a></li>
        <li><a class="png" href="<?php echo DOMAIN;?>advertise_with_us.html" title="advertise with us now!!!">Advertise With Us</a></li>
        <li class="liNone"><a class="png" href="<?php echo DOMAIN;?>advertise_with_us.html#contact" id="contact_link" title="contact anyweh.com now!!!">&nbsp;</a></li>
      </ul>
    </div>
</div>
<?php if($showFlashBanner){?>
<div id="show" class="slideshow">
	<div id="largeimageplayer"><center><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this rotator.</center></div>
	<script type="text/javascript">
		var s4 = new SWFObject("<?php echo DOMAIN;?>image_player/imagerotator.swf","rotator","836","295","7");
		s4.addParam("allowfullscreen","true");
		s4.addParam("wmode","transparent");
		s4.addVariable("file","<?php echo DOMAIN;?>images/ads/large_rotating_ads.xml");
		s4.addVariable("width","836");
		s4.addVariable("height","295");
		s4.write("largeimageplayer");
	</script>
</div>
<?php }else{ ?>
<div id="flashads">
    <div id="homeAds">
        <div id="show" class="slideshow">
			<div id="largeimageplayer"><center><a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this rotator.</center></div>
			<script type="text/javascript">
				var s4 = new SWFObject("<?php echo DOMAIN;?>image_player/imagerotator.swf","rotator","330","375","7");
				s4.addParam("allowfullscreen","true");
				s4.addParam("wmode","transparent");
				s4.addVariable("file","<?php echo DOMAIN;?>images/ads/home_top_rotating_ads.xml");
				s4.addVariable("width","330");
				s4.addVariable("height","375");
				s4.write("largeimageplayer");
			</script>
		</div>    
    </div>
    <div name="mediaspace" id="mediaspace"><a href="http://www.adobe.com/go/getflashplayer">get flash player</a></div>
    <script language="javascript" type="text/javascript">
    /* <![CDATA[ */
    var s0 = new SWFObject("player/player.swf","tv","500","374","8");   	
    s0.addParam("allowfullscreen","true");		
    s0.addParam("wmode","transparent");
    s0.addParam("allowscriptaccess","always");			
    s0.addParam('flashvars', 'file=<?php echo DOMAIN;?>gallery/albums/videos/play_list.xml&autostart=true&skin=<?php echo DOMAIN;?>player/modieus/modieus.swf&repeat=list');
    s0.write("mediaspace");
    /* ]]> */
    </script>
</div>
<?php } ?>
<div id="topBar">
    <ul>
	 <li><a class="mplayer"  href="#" onclick="window.open('http://www.anyweh.com/audio_player.php', 'audio_player', 'width=470, height=335'); ">M-Player</a></li>
        <li><a class="feed" href="<?php echo DOMAIN;?>rss.html" title="subscribe to www.anyweh.com feed">RSS</a></li>
        <li><a class="contact" title="contact us now" href="<?php echo DOMAIN;?>advertise_with_us.html#contact">Contact Us</a></li>
        <li><a class="a2a_dd shear" href="http://www.addtoany.com/share_save?linkname=anyweh.com&amp;linkurl=<?php echo "http://www.anyweh.com".$_SERVER['REQUEST_URI']; ?>"><img src="<?php echo DOMAIN;?>images/share_save.png" width="171" height="16" border="0" alt="Share/Save/Bookmark"/></a></li>
    </ul>
    <form action="http://www.google.com.jm/cse" id="cse-search-box" target="_blank">
      <div>
        <input type="hidden" name="cx" value="partner-pub-7769573252573851:w0tbpopdhgd" />
        <input type="hidden" name="ie" value="ISO-8859-1" />
        <input type="text" name="q" size="40" />
        <input type="submit" name="sa" value="Google Search" />
      </div>
    </form>
    <script type="text/javascript" src="http://www.google.com.jm/coop/cse/brand?form=cse-search-box&amp;lang=en"></script>
</div>