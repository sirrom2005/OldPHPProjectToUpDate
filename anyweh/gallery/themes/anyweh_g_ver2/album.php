<?php include_once("../config/global.php"); if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light'); $firstPageImages = normalizeColumns('2', '6');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Author" content="Rohan (Iceman) Morris : sirrom2005@gmail.com" />
	<meta name="sitename" content="www.anyweh.com" />
	<meta name="copyright" content="Anyweh.com <?php echo date("Y"); ?>" />
    <meta name="language" content="en" />
    <link rel="alternate" type="application/rss+xml" title="www.anyweh.com blog rss feed" href="http://feeds.feedburner.com/AnywehcomBlog" />
    <link rel="alternate" type="application/rss+xml" title="www.anyweh.com photo gallery rss feed" href="http://feeds.feedburner.com/AnywehcomPhotoGallery" />
    <link rel="alternate" type="application/rss+xml" title="www.anyweh.com comment rss feed" href="http://www.anyweh.com/blog/comments/feed" />
    <style type="text/css"> 
	<!-- 
	@import url("<?php echo DOMAIN;?>css/layout.css");
	-->
	</style>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo getBareAlbumTitle();?></title>
	<link rel="stylesheet" href="<?php echo $zenCSS ?>" type="text/css" />
	<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>

<body>
<?php include_once("includes/header.php"); ?>
<div id="main">

	<div id="gallerytitle">
		<h2><a href="<?php echo DOMAIN;?>index.html" title="home">www.anyweh.com</a> &raquo;  <span><?php printHomeLink('', ' &raquo; '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?></a> &raquo; <?php printParentBreadcrumb(); ?></span> <?php printAlbumTitle(true);?></h2>
        <script type="text/javascript"><!--
		google_ad_client = "pub-7769573252573851";
		/* 728x15_ads_unit */
		google_ad_slot = "5757812116";
		google_ad_width = 728;
		google_ad_height = 15;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
        <?php printAlbumDesc(true); ?>
	</div>

		<div id="padbox">
			<div id="albums">
			<?php while (next_album()): ?>
			<div class="album">

						<div class="thumb">
					<a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
						</div>
				<div class="albumdesc">
					<h3><a href="<?php echo htmlspecialchars(getAlbumLinkURL());?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle();?>"><?php printAlbumTitle(); ?></a></h3>
								<small><?php printAlbumDate(""); ?></small>
					<p><?php printAlbumDesc(); ?></p>
				</div>
				<p style="clear: both; "></p>
			</div>
			<?php endwhile; ?>
		</div>

			<div id="images">
			<?php while (next_image(false, $firstPageImages)): ?>
			<div class="image">
				<div class="imagethumb"><a href="<?php echo htmlspecialchars(getImageLinkURL());?>" title="<?php echo getBareImageTitle();?>"><?php printImageThumb(getAnnotatedImageTitle()); ?></a></div>
			</div>
			<?php endwhile; ?>

		</div>

		<?php printPageListWithNav("&laquo; ".gettext("prev"), gettext("next")." &raquo;"); ?>
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
		<?php if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('View Slideshow')); ?>
		<?php if (function_exists('printRating')) { printRating(); }?>
	</div>
    
    <div id="credit">
    <?php
    if (function_exists('printUserLogout')) {
        printUserLogout(" | ");
    }
    ?>
    </div>
    <?php printAdminToolbox(); ?>
</div>
<?php include_once("includes/footer.php"); ?>