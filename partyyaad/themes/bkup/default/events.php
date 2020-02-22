<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php zp_apply_filter('theme_head'); ?>
    <meta name="description" content="partyaad.com the jamaican premiere site for your pictures events birthday parties, weddings, graduations, funerals" >
	<meta name="keywords" content="birthday parties, weddings, graduations, funerals, and other outdoor activities,dreamweekend,ati,yush,utech,uwi" >
    <meta name="author" content="rohan (iceman) morris" >
    <title><?php echo getBareGalleryTitle(); ?> :: Notice Broad</title>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
    <link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />

    <script type="text/javascript" src="themes/default/js/swfobject.js"></script>
    <!--[if lt IE 9]>
      <script type="text/javascript" src="themes/default/js/excanvas/excanvas.js"></script>
    <![endif]-->
    <script type="text/javascript" src="themes/default/js/spinners/spinners.js"></script>
    <script type="text/javascript" src="themes/default/js/lightview/lightview.js"></script>
    <link rel="stylesheet" type="text/css" href="themes/default/styles/lightview/lightview.css" />
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
<?php include_once('includes/header.php'); ?>
<?php zp_apply_filter('theme_body_open'); ?>
<div id="main">
<div id="gallerytitle"><h2 id="eventspage"><?php echo gettext('Partyaad Notice Broad'); ?></h2></div>
<div id="padbox">
		<?php
			$upEvts = getUpcomingEventForEventsPage();
			if(!empty($upEvts)){
		?>
		<div style="text-align:center;">
			<?php

				foreach($upEvts as $key => $value){
			?>
				<div class="events_ads">
					<a href="<?php echo 'albums/'.$value['folder'].'/'.$value['filename']; ?>" class="lightview" data-lightview-group='events' data-lightview-title="Upcoming Events" data-lightview-caption="<?php echo strip_tags($value['desc']); ?>" title="<?php echo strip_tags($value['desc']); ?>">
					<span><?php echo strip_tags($value['title']); ?></span>
					<img src="<?php echo 'albums/'.$value['folder'].'/'.$value['filename']; ?>" title="<?php echo strip_tags($value['title']); ?>" alt="<?php echo strip_tags($value['desc']); ?>" />
					</a>
				</div>
			<?php
				}
			?>
		</div>
		<hr class="clear" />
        <div class="fb-like" data-href="http://partyaad.com/index.php?p=events" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
		<?php } ?>
	</div>
</div>
<?php include_once('includes/footer.php'); ?>
</body>
</html>