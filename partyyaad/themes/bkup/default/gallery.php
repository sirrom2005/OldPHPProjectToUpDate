<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php zp_apply_filter('theme_head'); ?>
        <meta name="description" content="partyaad.com the jamaican premiere site for your pictures events birthday parties, weddings, graduations, funerals" >
		<meta name="keywords" content="birthday parties, weddings, graduations, funerals, and other outdoor activities,dreamweekend,ati,yush,utech,uwi" > 
        <meta name="author" content="rohan (iceman) morris" >
		<title><?php echo getBareGalleryTitle(); ?> :: Photo Gallery</title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />
		<?php printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
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
			<div id="gallerytitle">
				<h2 id="gallerypage"><?php echo getGalleryTitle(); ?></h2>
			</div>
			<div id="padbox">
                <div id="desc_album">
                	<?php printGalleryDesc(); ?>
                	<hr />
                	<div class="fb-like" data-href="http://partyaad.com/index.php?p=gallery" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
                </div>
				<div id="albums">
					<?php while (next_album()): ?>
						<div class="album">
							<div class="thumb">
								<a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle(); ?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
							</div>
                            <div class="albumdesc">
								<h3><a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle(); ?>"><?php printAlbumTitle(); ?></a></h3>
                                <small><b>Added:</b> <?php printAlbumDate(""); ?></small>
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<br clear="all" />
				<?php printPageListWithNav("&laquo; " . gettext("prev"), gettext("next") . " &raquo;"); ?>
			</div>
		</div>
        <?php include_once('includes/footer.php'); ?>
	</body>
</html>
