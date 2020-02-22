<?php	
	$cacheHTML="index.html";
	if( file_exists($cacheHTML) ){ include($cacheHTML); exit();}
	header("Vary: Accept-Encoding");
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
	ob_start('ob_gzhandler');
	else ob_start();
		
	include_once("config/global.php");
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php" );
	include_once("classes/blog.class.php");
	include_once("classes/banner.class.php");
	include_once("classes/events.class.php");

	$bannerObj 	  = new banner();
	$blogObj 	  = new blog();
	$eventsObj 	  = new events();
		
	$newsAndInfo  	= $blogObj->getHeadlines(); 
	$pictureOfWeek	= $bannerObj->getPictureOfWeek(); 
	$lastWeekWinner	= $bannerObj->getLastWeekWinner(); 
	$featuredVideo  = $bannerObj->getFeaturedVideo();
	$comingEvents 	= $eventsObj->getUpComingEvent(4);
	/* FOOTER */
	$inTheNews  	= $blogObj->getFotterNewsList();
	$latestAlbums	= $bannerObj->getLatestAlbums();
	
	$pageKeywords 		= "";
	$pageDescription	= "";
	foreach($newsAndInfo as $row)
	{
		$pageKeywords 		.= pageKeywords($row['post_title']);
		$pageDescription 	.= cleanString( preg_replace("/[^a-z0-9 ]/i", " ", strip_tags($row['post_content'])) , 14).", "; 
	}
	
	$hotGirl   		= $bannerObj->getHotGirlOfTheWeek();
	$hotGirlDesc1 	= (!empty($hotGirl[0]['desc']))? $hotGirl[0]['desc'] : "Click to view this and more photos from anyweh.com photo gallery";
	$hotGirlDesc2 	= (!empty($hotGirl[1]['desc']))? $hotGirl[1]['desc'] : "Click to view this and more photos from anyweh.com photo gallery";
	
	function re_size($file, $wsize=80, $hsize=NULL)
	{
		global $tmpFolder, $imageFolder;
		
		$size = $wsize.$hsize;

		if( file_exists("tmp_image/$size"."_".$file['filename']) )
		{ 
			return "tmp_images/$size"."_".$file['filename'];
		}
		else
		{ 
			include_once("classes/image_resize_custom.php");
			$imgData['image'] 	= $file['filename'];
			$imgData['h'] 		= $hsize;	
			$thumb = new thumbNail( $imgData, $tmpFolder, $imageFolder.$file['folder']."/", $wsize );
			return "tmp_images/".$thumb->fileName;
		}
	}

	if( file_exists("tmp_images/300250"."_".str_replace(" ", "_", $pictureOfWeek['filename'])) &&  file_exists("tmp_images/135207"."_".str_replace(" ", "_", $hotGirl[0]['filename'])) )
	{
		/*under the assumtion that if the above 2 files exists every ting is OKK!!!*/
		$reSizeImg 		= "tmp_images/"."300250_".str_replace(" ", "_", $pictureOfWeek['filename']);  
		$lastWeek		= "tmp_images/"."300250_".str_replace(" ", "_", $lastWeekWinner['filename']);  
		$hotGirl_1 		= "tmp_images/"."135207_".str_replace(" ", "_", $hotGirl[0]['filename']); 
		$hotGirl_2 		= "tmp_images/"."135207_".str_replace(" ", "_", $hotGirl[1]['filename']); 
		$hotGirl_lge1 	= "tmp_images/"."300_".str_replace(" ", "_", $hotGirl[0]['filename']);
		$hotGirl_lge2 	= "tmp_images/"."300_".str_replace(" ", "_", $hotGirl[1]['filename']);
	}
	else
	{
		$reSizeImg 		= re_size($pictureOfWeek, 300 , 250); 
		$lastWeek		= re_size($lastWeekWinner, 300 , 250); 
		$hotGirl_1 		= re_size($hotGirl[0], 135, 207);
		$hotGirl_2 		= re_size($hotGirl[1], 135, 207);
		$hotGirl_lge1	= re_size($hotGirl[0], 300, NULL);
		$hotGirl_lge2	= re_size($hotGirl[1], 300, NULL);
	}
	
	$galleryThumUrl 	= $galleryDomain.urlencode($pictureOfWeek['folder'])."&amp;image=".urlencode($pictureOfWeek['filename']);
	$lastWeekWinnerUrl 	= $galleryDomain.urlencode($lastWeekWinner['folder'])."&amp;image=".urlencode($lastWeekWinner['filename']);
	$hotGirlUrl_1 		= $galleryDomain.urlencode($hotGirl[0]['folder'])."&amp;image=".urlencode($hotGirl[0]['filename']);
	$hotGirlUrl_2 		= $galleryDomain.urlencode($hotGirl[1]['folder'])."&amp;image=".urlencode($hotGirl[1]['filename']);	
	$picOfWeekTitle		= (!empty($pictureOfWeek['desc']))? $pictureOfWeek['desc'] : "snapshop/picture of the week";
	$lastWinnerTitle	= (!empty($lastWeekWinner['desc']))? $lastWeekWinner['desc'] : "last week fashionista winner";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="Author" content="Rohan (Iceman) Morris : sirrom2005@gmail.com" />
<meta name="sitename" content="www.anyweh.com" />
<meta name="copyright" content="Anyweh.com <?php echo date("Y"); ?>" />
<meta name="language" content="en" />
<meta http-equiv="keywords" name="keywords" content="<?php echo $pageKeywords.META_KEY;?> anyweh.com, entertainment, party photo, gallery, picture, cookout party picture, red strip x-mas, Red Stripe X-Mas Kick-Off Party pictures, appleton, maydayz, fashionista" />
<meta http-equiv="description" name="description" content="<?php echo $pageDescription.META_DESC; ?>, anyweh.com entertainment new party photo gallery picture, ultimate party photo gallery, every party picture in jamaica, jamaican party pictures, parties in jamaica cookout party picture, appleton, red strip x-mas, Red Stripe X-Mas Kick-Off Party pictures, appleton maydayz pictures, sexy models" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com blog rss feed" href="http://feeds.feedburner.com/AnywehcomBlog" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com photo gallery rss feed" href="http://feeds.feedburner.com/AnywehcomPhotoGallery" />
<link rel="alternate" type="application/rss+xml" title="www.anyweh.com comment rss feed" href="http://www.anyweh.com/blog/comments/feed" />
<title>anyweh di party deh : www.anyweh.com </title>
<style type="text/css"> 
<!-- 
@import url("css/layout.css");
-->
</style>
<?php
echo "<style>\n
	.hottGilr_1{background-image:url({$hotGirl_1}); background-repeat:no-repeat;}\n
	.hottGilr_2{background-image:url({$hotGirl_2}); background-repeat:no-repeat;}\n
	</style>\n";
?>
<script type="text/javascript">
	var messages = new Array();
	messages[0] = new Array('<?php echo $hotGirl_lge1;?>','Click to view this and more from anyweh.com photo gallery','');
	messages[1] = new Array('<?php echo $hotGirl_lge2;?>','Click to view this and more from anyweh.com photo gallery','');
	messages[2] = new Array('<?php echo $reSizeImgLrg;?>','Click to view this and more from anyweh.com photo gallery','');
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
				<li><a href="<?php echo DOMAIN;?>events_calendar.html" title="events and party calendar">Calendar</a></li>
				<li class="nostyle"><a href="<?php echo DOMAIN;?>advertise_with_us.html" title="advertise with us now!!!">Advertise With Us</a></li>
			</ul>
		</div>
		<a href="<?php echo DOMAIN;?>index.html" id="logo" title="www.anyweh.com"></a>
		<div id="window">
			<ul>
            <li id="largeimageplayer"></li>
            <li name="mediaspace" id="mediaspace"></li>
            <li>
                <a id="c_date" href="<?php echo DOMAIN;?>events_calendar.html" title="view events calendar"><?php echo date("d");?></a>
                <a id="fbook" href="http://www.facebook.com/pages/ANYWEH-Entertainment/121680584528878" title="anyweh.com is on facebook" target="_blank"></a>
                <a id="twitter" href="http://twitter.com/#!/anywehent" title="anyweh.com is on twitter" target="_blank"></a>
                <a id="feeds" href="<?php echo DOMAIN;?>rss.html" title="anyweh.com rss feeds"></a>
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
			<blockquote id="fashionista" >
                <h1>Anyweh.com Featured Video</h1>
				<?php  
				    $filename 	= explode(".", $featuredVideo['filename']);
                    $filename	= $filename[0];
					$image		= (fileExists("gallery/albums/videos/images/$filename.jpg"))? "$filename.jpg" : "video_default.jpg";				
				?>
				<div id="minitv"></div>
			</blockquote>
            <blockquote class="articles gap">
				<h1>Entertainment News</h1>
				<?php 
					if(!empty($newsAndInfo)){
						foreach($newsAndInfo as $row)
						{ 
							$blogImg  = img_attr($row['post_content']); 
							$blogImg = ( !empty($blogImg) )? $blogImg : "images/default_news.jpg" ;
				?>
						<div>
							
							<a href="<?php echo $row['guid']?>" title="<?php echo cleanString($row['post_title'], 13) ?>"><img src="<?php echo $blogImg?>" align="left" alt="<?php echo cleanString($row['post_title'])?>" title="<?=cleanString($row['post_title'])?>" height="58" /></a>
							<h5><a href="<?php echo $row['guid']?>" title="<?php echo cleanString($row['post_title']) ?>"><?php echo cleanString($row['post_title'], 8) ?></a></h5>
							<?php echo cleanString($row['post_content'], 14) ?>...
							<br>
						</div>
				<?php 
						}
					} 
				?>
			</blockquote>
            <blockquote class="scrollable">
            	<h1>Latest Gallery Updates</h1>
				<div class="items" id="galleryList">
                </div>
                <p class="navi"></p>
            </blockquote>
			<blockquote class="advertisements">
				<h4>Advertisements</h4>
				<iframe frameborder="0" width="300" height="250" scrolling="no" style="border:0px;" src="<?php echo DOMAIN;?>includes/banners_pages.php?adsspace=4"></iframe>
			</blockquote>
			<blockquote class="gap">
				<h1>Picture of the Week</h1>
				<a href="<?php echo $galleryThumUrl;?>"><img src="<?php echo $reSizeImg;?>" alt="<?php echo $picOfWeekTitle;?>" title="<?php echo $picOfWeekTitle;?>"/></a>
			</blockquote>
            <blockquote>
            <h1>Upcoming Events</h1>
            <?php
                if(!empty($comingEvents))
                {
                    foreach($comingEvents as $row)
                    {
            ?>
                    <div>
                        <a class="cal_date" href="event.php?id=<?php echo base64_encode($row['id']);?>"><?php echo date("d", strtotime($row['date']));?></a>
                        <h5><a href="event.php?id=<?php echo base64_encode($row['id']);?>" class="thickbox" title="<?php echo strtolower($row['title']);?>"><?php echo cleanString($row['title'],6);?>...</a></h5>
                        <?php echo date("l, F. d Y", strtotime($row['date']));?>
                        <br>
                    </div>
            <?php
                    }
                }else{ include_once("calender/mini.php"); }
                echo "<a id='postevent' href='place_your_events_on_our_calendar.html'></a>";
            ?>
            </blockquote>
			<blockquote id="fashionista" >
				<!--h1>This Week Poll</h1-->
				<?php
                    /*include_once ("poll/config.php");
                    include_once ("poll/includes/miniPoll.class.php");
                    $test = new miniPoll;
                    $test->pollForm();*/
                ?>            
                <h1>Fashionista of the week</h1>
                <div class="frame hottGilr_2" style="float:right;">
					<a href="<?php echo $hotGirlUrl_2?>#img" onmouseover="doTooltip(event,1)" onmouseout="hideTip()" title=""><div class="spacer b">&nbsp;</div></a><div class="hotti_info"><a href="<?php echo $hotGirlUrl_2?>" title="<?php echo cleanString($hotGirlDesc2);?>"><?php echo cleanString($hotGirlDesc2, 17); ?></a></div>
				</div>
				<div class="frame hottGilr_1">
					<a href="<?php echo $hotGirlUrl_1?>#img" onmouseover="doTooltip(event,0)" onmouseout="hideTip()" title=""><div class="spacer a">&nbsp;</div></a><div class="hotti_info"><a href="<?php echo $hotGirlUrl_1?>" title="<?php echo cleanString($hotGirlDesc1);?>"><?php echo cleanString($hotGirlDesc1, 17); ?></a></div>
				</div>
				<div class="clear"></div>
				<div id="pic_week"></div>
				<p><a href="blog/fashionista_of_the_week_<?php echo $hotGirl[0]['id'].$hotGirl[1]['id']; ?>.html" title="post comment on your favorite girl!!!">Post Comments/View Comments.</a></p>
		  </blockquote>
			<blockquote id="fashionista" class="gap">
				<h1>Last Week Fashionista Winner</h1>
				<a href="<?php echo $lastWeekWinnerUrl;?>"><img src="<?php echo $lastWeek;?>" alt="<?php echo $lastWinnerTitle;?>" title="<?php echo $lastWinnerTitle;?>" /></a>
			</blockquote>
            <blockquote class="advertisements">
				<h4>Advertisements</h4>
				<iframe frameborder="0" width="300" height="250" scrolling="no" style="border:0px;" src="<?php echo DOMAIN;?>includes/banners_pages.php?adsspace=4"></iframe>
			</blockquote>
            <script type="text/javascript" src="js/image_tooltip.js"></script>
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
        <script language="javascript" type="text/javascript" src="js/jquery.custom.home.js"></script>
        <script language="javascript" type="text/javascript" src="js/gallery_cron.js"></script>
		<script language="javascript" type="text/javascript" src="js/swfobject.js"></script>
		<script type="text/javascript" src="js/page_loader.js"></script>
        <script type="text/javascript"> getPage( "includes/girl_vote.php?i=d", "pic_week" ); </script>
        <script type="text/javascript" src="js/scripts.js"></script>
		<script type="text/javascript">
            var s4 = new SWFObject("flash/imagerotator/imagerotator.swf","rotator","330","375","7");
            s4.addParam("allowfullscreen","true");
            s4.addParam("wmode","transparent");
            s4.addVariable("file","<?php echo DOMAIN;?>images/ads/home_top_rotating_ads.xml");
            s4.addVariable("width","330");
            s4.addVariable("height","375");
        
            var s0 = new SWFObject("flash/videoplayer/player.swf","tv","500","375","8");   	
            s0.addParam("allowfullscreen","true");		
            s0.addParam("wmode","transparent");
            s0.addParam("allowscriptaccess","always");			
            s0.addParam('flashvars', 'file=<?php echo DOMAIN;?>gallery/albums/videos/play_list.xml&autostart=true&skin=<?php echo DOMAIN;?>player/modieus/modieus.swf&repeat=list');
            s0.addVariable("width","500");
            s0.addVariable("height","375");
										
			var s1 = new SWFObject("flash/videoplayer/player.swf","minitv","300","250","7");
			s1.addParam("allowfullscreen","true");
			s1.addParam("allowScriptAccess","always");
			s1.addParam("wmode","transparent");
			s1.addParam("flashvars","file=<?php echo DOMAIN;?>gallery/albums/videos/<?php echo $featuredVideo['filename']; ?>&autostart=false&image=gallery/albums/videos/images/<?php echo $image;?>&skin=<?php echo DOMAIN;?>flash/videoplayer/modieus/modieus.swf");
           
			s4.write("largeimageplayer");
			s0.write("mediaspace");
			s1.write("minitv");
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
<script type="text/javascript">
$("#galleryList").html(galleryList);
// execute your scripts when the DOM is ready. this is mostly a good habit
$(function(){
	// initialize scrollable
	$(".scrollable").scrollable({circular:true,mousewheel:false}).autoscroll({autoplay:true,interval:4000,autopause:true}).navigator();
});
</script>
<style>
.scrollable 
{
	/* required settings */
	position:relative;
	overflow:hidden;
	width:300px;
	height:300px;
}
/*
	root element for scrollable items. Must be absolutely positioned
	and it should have a extremely large width to accommodate scrollable items.
	it's enough that you set width and height for the root element and
	not for this element.
*/
.scrollable .items {
	/* this cannot be too large */
	width:20000em;
	position:absolute;
}
/*
	a single item. must be floated in horizontal scrolling.
	typically, this element is the one that *you* will style
	the most.
*/
.items div
{
	float:left;
	width:290px;
	border:solid 1px #fff;
	margin:0 10px; 
	height:250px;
	overflow:hidden;
}
.items div span
{
	height:45px;
	width:290px;
	display:block;
	font-size:1em;
	text-align:center;
	padding:10px 0 0 0;
	background-image:url(images/macFFBgHack.png);
	background-repeat:repeat;
	position:absolute;
	top:196px;
	z-index:10;
	color:#FFFFFF;
}
/* position and dimensions of the navigator */
.navi{margin:0 0 0 80px;width:150px;height:6px; position:absolute; bottom:0;}
/* items inside navigator */
.navi a {
	width:8px;
	height:8px;
	float:left;
	margin:3px;
	background:url(images/navigator.png) 0 0 no-repeat;
	display:block;
	font-size:1px;
}
/* mouseover state */
.navi a:hover{background-position:0 -8px;}
/* active state (current page state) */
.navi a.active {background-position:0 -16px;}
</style>  
</body>
</html>
<?php
	$fp=fopen($cacheHTML,'w'); 
	$cachecontents=ob_get_contents();
	fwrite($fp,$cachecontents);
	fclose($fp);
	ob_end_flush();
?>