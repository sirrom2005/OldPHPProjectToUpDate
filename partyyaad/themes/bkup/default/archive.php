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
		<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Archive View"); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />
		<?php printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
	</head>
	<body>
    	<?php include_once('includes/header.php'); ?>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<div id="gallerytitle">
				<h2 id="gallerypage">
					<span>
						<a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo gettext('Gallery Index'); ?>"><?php echo getGalleryTitle(); ?></a>
					</span> | 
					<?php echo gettext("Archive View"); ?>
				</h2>
			</div>
			<div id="padbox">
				<div id="archive"><?php printAllDates(); ?></div>
				<div id="tag_cloud">
					<p><?php echo gettext('Popular Tags'); ?></p>
					<?php printAllTagsAs('cloud', 'tags'); ?>
				</div>
			</div>
		</div>
		<?php include_once('includes/footer.php'); ?>
	</body>
</html>
