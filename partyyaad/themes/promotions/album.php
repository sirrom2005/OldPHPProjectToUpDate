<?php
/*
* Author: Rohan Morris
* Desc: Redone to be used as the promotion page only
*/
// force UTF-8 Ø
if (!defined('WEBPATH')) die();
$exp = explode('/',$_SERVER['QUERY_STRING']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php zp_apply_filter('theme_head'); ?>
<meta name="description" content="promote yourself on www.partyadd.com you are your own product, upcoming artise." >
<meta name="keywords" content="promot, promotion, upcoming star, models, girls, singers" >
<meta name="author" content="rohan (iceman) morris" >
<title><?php echo getBareGalleryTitle(); ?> :: <?php echo getBareAlbumTitle(); ?></title>
<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
<link rel="stylesheet" href="themes/default/styles/light.css" type="text/css" />
<link rel="stylesheet" href="themes/promotions/styles/light.css" type="text/css" />
<?php printRSSHeaderLink('Album', getAlbumTitle()); ?>
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
<?php include_once('themes/default/includes/header.php'); ?>
<?php zp_apply_filter('theme_body_open'); ?>
<div id="main">
	<div id="gallerytitle">
		<h2 id="promotionpage">
			<?php
					printParentBreadcrumb("", " | ", " | ");
					printAlbumBreadcrumb("", "");
			?>
		</h2>
	</div>
	<div id="padbox">
		 <?php if(count($exp)==1){ ?>
		<div id="promo_desc_album">
			<?php printAlbumDesc(true); ?>
            <hr />
            <div class="fb-like" data-href="http://partyaad.com/index.php?album=<?php echo $_GET['album']; ?>" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
		</div>
		<?php } ?>
		<div id="promo_albums">
			<?php while (next_album()): ?>
				<div class="promo_album">
					<a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php echo gettext('View promotional page for'); ?> <?php echo getAnnotatedAlbumTitle(); ?>">
						<span><?php printAlbumTitle(); ?></span>
						<?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?>
					</a>
				</div>
			<?php endwhile; ?>
		</div>
		
		<div id="images">
			<?php if(count($exp)>1){ ?>
			<div id="promo_desc">
				<h1 title="<?php printAlbumTitle(true);?>"><?php printAlbumTitle(true);?></h1>
				<?php printAlbumDesc(true); ?>
				<hr />
				<div class="fb-like" data-href="http://partyaad.com/index.php?album=<?php echo $_GET['album']; ?>" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
			</div>
			<?php } ?>
			<?php while (next_image()): ?>
				<div class="image">
					<div class="imagethumb"><a href="<?php echo html_encode(getImageLinkURL()); ?>" title="<?php echo getBareImageTitle(); ?>"><?php printImageThumb(getAnnotatedImageTitle()); ?></a></div>
				</div>
			<?php endwhile; ?>
		</div>
		<?php printPageListWithNav("&laquo; " . gettext("prev"), gettext("next") . " &raquo;"); ?>
		<?php printTags('links', gettext('<strong>Tags:</strong>') . ' ', 'taglist', ''); ?>

		<?php //if (function_exists('printGoogleMap')) printGoogleMap(); ?>
		<?php //if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('View Slideshow')); ?>
		<?php //if (function_exists('printRating')) { printRating();} ?>
		<?php //if (function_exists('printCommentForm')) { printCommentForm();}?>
	</div>
</div>
<?php include_once('themes/default/includes/footer.php'); ?>
</body>
</html>