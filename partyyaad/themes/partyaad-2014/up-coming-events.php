<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <?php zp_apply_filter('theme_head'); ?>
    <meta name="description" content="partyaad.com the jamaican premiere site for your pictures events birthday parties, weddings, graduations, funerals" >
	<meta name="keywords" content="birthday parties, weddings, graduations, funerals, and other outdoor activities,dreamweekend,ati,yush,utech,uwi" >
    <meta name="author" content="rohan (iceman) morris" >
    <title><?php echo getBareGalleryTitle(); ?> :: Noticeboard :: Up Cominig Events</title>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-511ed55444f86c77"></script>
    <script type="text/javascript" src="themes/default/js/swfobject.js"></script>
    <!--[if lt IE 9]>
      <script type="text/javascript" src="themes/default/js/excanvas/excanvas.js"></script>
    <![endif]-->
    <script type="text/javascript" src="themes/default/js/spinners/spinners.js"></script>
    <script type="text/javascript" src="themes/default/js/lightview/lightview.js"></script>
    <link rel="stylesheet" type="text/css" href="themes/default/styles/lightview/lightview.css" />
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47847435-1', 'partyaad.com');
  ga('send', 'pageview');

</script>
<style>
body,ul,li{margin:0; padding:0;}
body{background:url(themes/default/images/home_bg.jpg) center 0;}
#container{ width:900px; margin:5px auto;}
h1{ margin:0 auto; width:500px; height:80px; background:url(themes/default/images/upcoming-events.png) no-repeat; }
.list{text-align:center;}
.list a{ display:inline-block; text-decoration:none; border:solid 1px #333333;}
.list span{ display:block; background-color:#333333; color:#FFFFFF; font-weight:bold;}
.events_ads{ margin-bottom:10px;}
a.enter{ background:url(themes/default/images/enter.png) 0 -62px; display:block; width:353px; height:61px; margin:0 auto; }
a.enter:hover{background-position:0 0;}
</style>
</head>
<body>
<div id="container">
<h1 title="Partyaad.com Noticeboard"></h1>
<div id="padbox">
		<?php
			$upEvts = getUpcomingEventForNoticeBoard();
			if(!empty($upEvts)){
		?>
		<div class="list">
			<?php

				foreach($upEvts as $key => $value){
			?>
				<div class="events_ads">
					<a href="<?php echo 'albums/'.$value['folder'].'/'.$value['filename']; ?>" class="lightview" data-lightview-group='events' data-lightview-title="Upcoming Events" data-lightview-caption="<?php echo strip_tags($value['desc']); ?>" title="<?php echo strip_tags($value['desc']); ?>">
					<!--span><?php echo strip_tags($value['title']); ?></span-->
                    <?php $xt = explode('.',$value['filename']); ?>
					<img src="<?php echo 'cache/'.$value['folder'].'/'.substr($value['filename'], 0,-4).'_595.'.strtolower($xt[count($xt)-1]); ?>" title="<?php echo strip_tags($value['title']); ?>" alt="<?php echo strip_tags($value['title']); ?>" />
					</a>
				</div>
			<?php
				}
			?>
		</div>
		<br class="clear" />
        <div style="padding:10px 0 0 280px;margin:5px auto;">
        <span>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style ">
            <a class="addthis_button_facebook_like" fb:like:layout="button_count" fb:like:href="http://partyaad.com/index.php?p=up-coming-events" ></a>
            <a class="addthis_button_tweet" tw:url="http://partyaad.com/index.php?p=up-coming-events" ></a>
            <a class="addthis_button_pinterest_pinit"></a>
            <a class="addthis_counter addthis_pill_style"></a>
            </div>
            <!-- AddThis Button END -->
        </span>
        </div>
	<?php } ?>
	</div>
    <br class="clear" />
    <!--ul id="menu">
    	<li class="home"><a href="index.php"></a></li>
        <li class="gallery"><a href="index.php?p=gallery"></a></li>
        <li class="events"><a href="index.php?p=events"></a></li>
        <li class="promotion"><a href="index.php?album=promotions"></a></li>
        <li class="contact"><a href="index.php?p=contact"></a></li>
    </ul-->
    <a href="index.php" class="enter" title="enter partyaad.com"></a>
</div>
</body>
</html>