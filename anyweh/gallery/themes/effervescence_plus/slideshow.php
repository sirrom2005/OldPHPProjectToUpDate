<?php
$themeResult = getTheme($zenCSS, $themeColor, 'effervescence');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<?php zenJavascript(); ?>
	<link rel="stylesheet" href="<?php echo $zenCSS ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/slideshow.css" type="text/css" />
	<?php printSlideShowJS(); ?>
</head>
<body>
	<!-- Wrap Everything -->
	<div id="main4">
		<div id="main2">

			<!-- Wrap Header -->
			<div id="galleryheader">
				<div id="gallerytitle">
					<div id="logo2">
					<?php printLogo(); ?>
					</div>
				</div> <!-- gallery title -->

				<div id="wrapnav">
					<div id="navbar">
						<span><?php printHomeLink('', ' | '); ?>
						<?php
						if (getOption('custom_index_page') === 'gallery') {
						?>
						<a href="<?php echo htmlspecialchars(getGalleryIndexURL(false));?>" title="<?php echo gettext('Main Index'); ?>"><?php echo gettext('Home');?></a> |
						<?php
						}
						?>
						<a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php echo gettext('Albums Index'); ?>">
						<?php echo getGalleryTitle();?></a> |
						<?php
						if (is_null($_zp_current_album)) {
							$search = new SearchEngine();
							$params = trim(zp_getCookie('zenphoto_search_params'));
							$search->setSearchParams($params);
							$images = $search->getImages(0);
							$searchwords = $search->words;
							$searchdate = $search->dates;
							$searchfields = $search->getSearchFields(true);
							$page = $search->page;
							$returnpath = getSearchURL($searchwords, $searchdate, $searchfields, $page);
							echo '<a href='.htmlspecialchars($returnpath,ENT_QUOTES).'><em>'.gettext('Search').'</em></a> | ';
						} else {
							printParentBreadcrumb();
							printAlbumBreadcrumb("", " | ");
						}
						?> </span>
						Slideshow
					</div> <!-- navbar -->
				</div> <!-- wrapnav -->
			</div> <!-- galleryheader -->
		</div> <!-- main2 -->
		<div id="content">
			<div id="main">
				<div id="slideshowpage">
					<?php printSlideShow(false,true); ?>
				</div>
			</div> <!-- main -->
		</div> <!-- content -->
	</div> <!-- main4 -->
	<br style="clear:all" />
	<!-- Footer -->
	<div class="footlinks">
		<?php
		printThemeInfo();
		?>
		<?php printZenphotoLink(); ?>
	</div> <!-- footlinks -->
	<?php printAdminToolbox(); ?>
</body>
</html>