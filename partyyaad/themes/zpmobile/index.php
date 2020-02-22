<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<title><?php printBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" />
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>
<div data-role="page" id="mainpage">

		<?php jqm_printMainHeaderNav(); ?>

	<div data-role="content">

	<div class="content-primary">
		<?php printGalleryDesc(); ?>
		<?php
		if(function_exists('printLatestImages')) {
			?>
			<h2><?php echo gettext('Latest images'); ?></h2>
			<?php
			printLatestImages(10,'',false,false,false,40,'',79,79,true,false,false);
		}
		?>
		<br clear="all" />
	</div>
</div><!-- /content -->
<?php jqm_printFooterNav(); ?>

</div><!-- /page -->
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>
