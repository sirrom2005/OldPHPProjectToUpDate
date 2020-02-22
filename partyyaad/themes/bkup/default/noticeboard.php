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
    <title><?php echo getBareGalleryTitle(); ?> : Noticeboard : Up Cominig Events</title>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />

    <script type="text/javascript" src="themes/default/js/swfobject.js"></script>
    <!--[if lt IE 9]>
      <script type="text/javascript" src="themes/default/js/excanvas/excanvas.js"></script>
    <![endif]-->
    <script type="text/javascript" src="themes/default/js/spinners/spinners.js"></script>
    <script type="text/javascript" src="themes/default/js/lightview/lightview.js"></script>
    <link rel="stylesheet" type="text/css" href="themes/default/styles/lightview/lightview.css" />
<style>
body,ul,li{margin:0; padding:0;}
body{background:url(themes/default/images/home_bg.jpg) center 0;}
#container{ width:900px; margin:5px auto;}
h1{ margin:0 auto; width:500px; height:80px; background:url(themes/default/images/upcoming-events.png) no-repeat; }
.list{text-align:center;}
.list a{ display:inline-block; text-decoration:none; border:solid 1px #333333;}
.list span{ display:block; background-color:#333333; color:#FFFFFF; font-weight:bold;}
.events_ads{ margin-bottom:10px;}
#menu{ margin:0 auto; width:790px;}
#menu li{ display:inline-block; width:152px; height:130px; background:no-repeat;}
#menu li a{display:block; height:130px;}
#menu li.home a{ background:url(themes/default/images/btn/btn-state.png) 0 -134px;}
#menu li.home a:hover{ background:url(themes/default/images/btn/btn-state.png);}
li.gallery a{ background:url(themes/default/images/btn/btn-state.png) -160px -134px;}
li.gallery a:hover{ background:url(themes/default/images/btn/btn-state.png) -160px 0;}
li.events a{background:url(themes/default/images/btn/btn-state.png) -323px -134px;}
li.events a:hover{background:url(themes/default/images/btn/btn-state.png) -323px 0;}
li.promotion a{ background:url(themes/default/images/btn/btn-state.png) -487px -134px;}
li.promotion a:hover{ background:url(themes/default/images/btn/btn-state.png) -487px 0;}
li.contact a{ background:url(themes/default/images/btn/btn-state.png) -648px -134px;}
li.contact a:hover{ background:url(themes/default/images/btn/btn-state.png) -648px 0;}
</style>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

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
					<img src="<?php echo 'cache/'.$value['folder'].'/'.substr($value['filename'], 0,-4).'_595.jpg'; ?>" title="<?php echo strip_tags($value['title']); ?>" alt="<?php echo strip_tags($value['title']); ?>" />
					</a>
				</div>
			<?php
				}
			?>
		</div>
		<br class="clear" />
        <div class="fb-like" style="padding-top:5px; margin-left:400px;" data-href="http://partyaad.com/index.php?p=noticeboard" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
		<?php } ?>
	</div>
    <br class="clear" />
    <ul id="menu">
    	<li class="home"><a href="index.php"></a></li>
        <li class="gallery"><a href="index.php?p=gallery"></a></li>
        <li class="events"><a href="index.php?p=events"></a></li>
        <li class="promotion"><a href="index.php?album=promotions"></a></li>
        <li class="contact"><a href="index.php?p=contact"></a></li>
    </ul>
</div>
</body>
</html>