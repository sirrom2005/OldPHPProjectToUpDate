<?php if (!defined('WEBPATH')) die(); 
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php if(!isset($ishomepage)) { echo getBarePageTitle(); } ?> | <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php printZenpageRSSHeaderLink("News","", "Zenpage news", ""); ?>
	<?php zenJavascript(); ?>
	<?php printZDRoundedCornerJS(); ?>
</head>

<body>

<div id="main">

	<div id="header">
    <a href="http://www.funinjamaica.net/" id="logo" title="home"></a>
    	<ul>
        <li><a href="http://www.funinjamaica.net/">Home</a></li>
        <li><a href="http://www.funinjamaica.net/gallery/">Picture Palace (HD)</a></li>
        <li><a href="http://www.funinjamaica.net/category/videos">Video Channel (HD)</a></li>
        <li><a href="http://www.funinjamaica.net/talent_exposure">Talent Exposure</a></li> 
        <li><a href="http://www.funinjamaica.net/category/entertainment-news">Entertainment News</a></li>
        <li><a href="http://www.funinjamaica.net/events-calendar">Events Calendar</a></li>
        <li><a href="http://www.funinjamaica.net/category/review">Review</a></li>
        <li><a href="http://www.funinjamaica.net/contact">Contact/Advertise</a></li>
        <li style="border-right:solid 3px #000000;"><a href="http://www.funinjamaica.net/category/where-to-be-in-ja">Where to be in Ja?</a></li>
        </ul>
		</div>
				
<div id="content">

	<div id="breadcrumb">
	<h2><a href="<?php echo getGalleryIndexURL(false); ?>"><?php echo gettext("Index"); ?></a><?php if(!isset($ishomepage)) { printParentPagesBreadcrumb(" &raquo; ",""); } ?><strong><?php if(!isset($ishomepage)) { printPageTitle(" &raquo; "); } ?></strong>
	</h2>
	</div>
<div id="content-left">
<h2><?php printPageTitle(); ?></h2>
<?php 
printPageContent(); 
printCodeblock(1); 
printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); 
?>
<br style="clear:both;" /><br />
<?php
if (function_exists('printRating')) { printRating(); }
?>

<?php 
if (function_exists('printCommentForm')) { 
	printCommentForm(); 
} ?>
	</div><!-- content left-->
		
		
	<div id="sidebar">
		<?php include("sidebar.php"); ?>
	</div><!-- sidebar -->


	<div id="footer">
	<?php include("footer.php"); ?>
	</div>

</div><!-- content -->

</div><!-- main -->
<?php printAdminToolbox(); ?>
</body>
</html>