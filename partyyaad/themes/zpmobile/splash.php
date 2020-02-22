<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die(); ?>
<!DOCTYPE html>
<html>
<head>
	<?php zp_apply_filter('theme_head'); ?>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" />
</head>

<body>
<?php zp_apply_filter('theme_body_open'); ?>
<div data-role="page" id="mainpage">
    <div class="header">
    	<h1></h1>
	</div>
	<div data-role="content">
		<div class="content-primary" align="center">
		<a href="index.php?p=up-coming-events" class="enter"></a>
		<br clear="all" />
	</div>
	</div><!-- /content -->
<?php jqm_printFooterNav(); ?>
</div><!-- /page -->
<?php zp_apply_filter('theme_body_close'); ?>
</body>
</html>