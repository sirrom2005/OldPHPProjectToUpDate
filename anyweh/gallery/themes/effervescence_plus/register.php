<?php
define('ALBUMCOLUMNS', 3);
define('IMAGECOLUMNS', 5);
if (!defined('WEBPATH')) die();
$_noFlash = true;  /* don't know how to deal with the variable folder depth file names
if ((getOption('Use_Simpleviewer')==0) || !getOption('mod_rewrite')) { $_noFlash = true; }

if (isset($_GET['noflash'])) {
	$_noFlash = true;
	zp_setcookie("noFlash", "noFlash");
	} elseif (zp_getCookie("noFlash") != '') {
	$_noFlash = true;
	}
	*/

// Change the configuration here

$themeResult = getTheme($zenCSS, $themeColor, 'effervescence');
$firstPageImages = normalizeColumns(ALBUMCOLUMNS, IMAGECOLUMNS);
if ($_noFlash) {
	$backgroundColor = "#0";  /* who cares, we won't use it */
} else {
	$backgroundColor = parseCSSDef($zenCSS);
}

$maxImageWidth="600";
$maxImageHeight="600";

$preloaderColor="0xFFFFFF";
$textColor="0xFFFFFF";
$frameColor="0xFFFFFF";

$frameWidth="10";
$stagePadding="20";

$thumbnailColumns="3";
$thumbnailRows="6";
$navPosition="left";

$enableRightClickOpen="true";

$backgroundImagePath="";
// End of config
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo gettext("Register"); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $zenCSS ?>" type="text/css" />
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/scripts/bluranchors.js"></script>
	<script type="text/javascript" src="<?php echo  $_zp_themeroot ?>/scripts/swfobject.js"></script>
</head>

<body onload="blurAnchors()">

<!-- Wrap Header -->
<div id="header">
	<div id="gallerytitle">

<!-- Logo -->
	<div id="logo">
	<?php
		echo printLogo();
	?>
	</div> <!-- logo -->
</div> <!-- gallerytitle -->

<!-- Crumb Trail Navigation -->

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
		<?php echo getGalleryTitle();	?></a></span> |
		<?php
		  echo "<em>".gettext('Register')."</em>";
		?>
	</div>
</div> <!-- wrapnav -->

</div> <!-- header -->

<!-- Wrap Subalbums -->
<div id="subcontent">
	<div id="submain">
	
		<h2><?php echo gettext('User Registration') ?></h2>
		<?php  printRegistrationForm();  ?>
	</div>
</div>


<!-- Footer -->
<div class="footlinks">

<?php printThemeInfo(); ?>
<?php printZenphotoLink(); ?>

</div> <!-- footerlinks -->


<?php printAdminToolbox(); ?>

</body>
</html>