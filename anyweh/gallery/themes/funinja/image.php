<?php if (!defined('WEBPATH')) die(); $firstPageImages = normalizeColumns('2', '6');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s').' GMT');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php zenJavascript(); ?>
	<title><?php echo getBareImageTitle();?> | <?php echo getBareAlbumTitle();?> | <?php echo getBareGalleryTitle(); ?></title>
	<meta http-equiv="content-type" content="text/html; charset=<?php echo getOption('charset'); ?>" />
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
	<?php require_once(SERVERPATH.'/'.ZENFOLDER.'/js/colorbox/colorbox_ie.css.php');?>
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/colorbox/jquery.colorbox-min.js" type="text/javascript"></script>
	<script type="text/javascript">
		// <!-- <![CDATA[
		$(document).ready(function(){
			$(".colorbox").colorbox({inline:true, href:"#imagemetadata"});
			$("a.thickbox").colorbox({maxWidth:"98%", maxHeight:"98%"});
		});
		// ]]> -->
	</script>
	<?php printZDRoundedCornerJS(); ?>
		<?php printRSSHeaderLink('Album',getAlbumTitle()); ?>
</head>
<body>

<div style="margin-top:0px;"><!-- somehow the thickbox.css kills the top margin here that all other pages have... -->
</div>
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
	<h2><a href="<?php echo getGalleryIndexURL(false);?>" title="<?php gettext('Index'); ?>"><?php echo gettext("Index"); ?></a> &raquo; <?php echo gettext("Gallery"); ?><?php printParentBreadcrumb(" &raquo; "," &raquo; "," &raquo; "); printAlbumBreadcrumb(" ", " &raquo; "); ?>
			 <strong><?php printImageTitle(true); ?></strong> (<?php echo imageNumber()."/".getNumImages(); ?>)
			</h2>
            
        <div class="imgnav">
			<?php if (hasPrevImage()) { ?>
			<div class="imgprevious"><a href="<?php echo htmlspecialchars(getPrevImageURL());?>" title="<?php echo gettext("Previous Image"); ?>">&nbsp;</a></div>
			<?php } if (hasNextImage()) { ?>
			<div class="imgnext"><a href="<?php echo htmlspecialchars(getNextImageURL());?>" title="<?php echo gettext("Next Image"); ?>">&nbsp;</a></div>
			<?php } ?>
		</div>
	</div>
	<div id="content-left">

	<!-- The Image -->
 <?php
 //
 if (function_exists('printjCarouselThumbNav')) {
 	printjCarouselThumbNav(6,50,50,50,50,FALSE);
 }
 else {
 	if (function_exists("printPagedThumbsNav")) {
 		printPagedThumbsNav(6, FALSE, gettext('&laquo; prev thumbs'), gettext('next thumbs &raquo;'), 40, 40);
 	}
 }

 ?>

	<div id="image">
    	<?php $imgURL = (hasNextImage()) ? htmlspecialchars(getNextImageURL()) : "index.php"; ?>
		<a href="<?php echo $imgURL;?>" title="<?php echo getBareImageTitle();?>">
			<?php printCustomSizedImageMaxSpace(getBareImageTitle(),580,580); ?>
        </a>
	</div>
	<div id="narrow">
		<p><?php printImageDesc(true); ?></p>
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ', '); ?>
		<br style="clear:both;" /><br />
		<?php if (function_exists('printSlideShowLink')) {
			echo '<span id="slideshowlink">';
			printSlideShowLink(gettext('View Slideshow')); 
			echo '</span>';
		}
		?>
			
		<br style="clear:both" />
		<?php if (function_exists('printRating')) { printRating(); }?>
		<?php if (function_exists('printImageMap')) printImageMap(); ?>
		<?php if (function_exists('printShutterfly')) printShutterfly(); ?>

</div>
		<?php if (function_exists('printCommentForm')) { 
				printCommentForm();
		 } ?>

</div><!-- content-left -->

<div id="sidebar">
<?php include("sidebar.php"); ?>
</div>

	<div id="footer">
	<?php include("footer.php"); ?>
	</div>


	</div><!-- content -->

</div><!-- main -->
<?php printAdminToolbox(); ?>
</body>
</html>