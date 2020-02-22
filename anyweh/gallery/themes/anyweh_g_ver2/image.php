<?php include_once("../config/global.php"); if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light'); $firstPageImages = normalizeColumns('2', '6');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <style type="text/css"> 
	<!-- 
	@import url("<?php echo DOMAIN;?>css/layout.css");
	-->
	</style>
	<?php zenJavascript(); ?>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="Author" content="Rohan (Iceman) Morris : sirrom2005@gmail.com" />
	<meta name="sitename" content="www.anyweh.com" />
	<meta name="copyright" content="Anyweh.com <?php echo date("Y"); ?>" />
    <link rel="alternate" type="application/rss+xml" title="www.anyweh.com blog rss feed" href="http://feeds.feedburner.com/AnywehcomBlog" />
    <link rel="alternate" type="application/rss+xml" title="www.anyweh.com photo gallery rss feed" href="http://feeds.feedburner.com/AnywehcomPhotoGallery" />
    <link rel="alternate" type="application/rss+xml" title="www.anyweh.com comment rss feed" href="http://www.anyweh.com/blog/comments/feed" />
	<title><?php echo getBareGalleryTitle(); ?> | <?php echo getBareAlbumTitle();?> | <?php echo getBareImageTitle();?></title>
	<link rel="stylesheet" href="<?php echo $zenCSS ?>" type="text/css" />
	<link rel="stylesheet" href="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.css" type="text/css" />
	<script src="<?php echo FULLWEBPATH . "/" . ZENFOLDER ?>/js/thickbox.js" type="text/javascript"></script>
	<script type="text/javascript">
		function toggleComments() {
			var commentDiv = document.getElementById("comments");
			if (commentDiv.style.display == "block") {
				commentDiv.style.display = "none";
			} else {
				commentDiv.style.display = "block";
			}
		}
	</script>
	<?php printRSSHeaderLink('Gallery',gettext('Gallery RSS')); ?>
</head>
<body>
<?php 
	include_once("includes/header.php");
	$imagePage = true; 
?>
<div id="main2">
	<a name="img"></a>
	<div id="gallerytitle">
		<!--div class="imgnav">
			<?php if (hasPrevImage()) { ?>
			<div class="imgprevious"><a href="<?php echo htmlspecialchars(getPrevImageURL());?>" title="<?php echo gettext("Previous Image"); ?>">&laquo; <?php echo gettext("prev"); ?></a></div>
			<?php } if (hasNextImage()) { ?>
			<div class="imgnext"><a href="<?php echo htmlspecialchars(getNextImageURL());?>" title="<?php echo gettext("Next Image"); ?>"><?php echo gettext("next"); ?> &raquo;</a></div>
			<?php } ?>
		</div-->           
		<h2><a href="<?php echo DOMAIN;?>index.html" title="home">www.anyweh.com</a> &raquo; <span><?php printHomeLink('', ' &raquo; '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?>
			</a> &raquo; <?php printParentBreadcrumb("", " &raquo; ", " &raquo; "); printAlbumBreadcrumb("", " &raquo; "); ?>
			</span> <?php printImageTitle(true); ?>
		</h2>
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
	</div>

	<!-- The Image -->
	<?php if (!checkForPassword()) { ?>
	<div id="image">
    	<div class="imgnav">
        	<?php if (hasNextImage()) { ?>
            <div class="imgnext"     style="background-image:url('<?php echo htmlspecialchars(getNextImageThumb()); ?>')"><a href="<?php echo htmlspecialchars(getNextImageURL());?>#img" title="<?php echo gettext("Next Image"); ?>"></a></div>
            <?php }else{ echo "<div class='imgnext' style='border:solid 1px #fff;'>&nbsp;</div>"; } ?>
            <?php if(hasPrevImage()){ ?>	
            <div class="imgprevious" style="background-image:url('<?php echo htmlspecialchars(getPrevImageThumb()); ?>')"><a href="<?php echo htmlspecialchars(getPrevImageURL());?>#img" title="<?php echo gettext("Previous Image"); ?>"></a></div>
            <?php }else{ echo "<div class='imgprevious' style='border:solid 1px #fff;'>&nbsp;</div>"; } ?>
        </div>
		<strong>
		<?php
		if(isImagePhoto()) 
		{
		?>
			<a href="<?php echo (hasNextImage())? htmlspecialchars(getNextImageURL())."#img" : DOMAIN."gallery/" ?>" title="<?php echo getBareImageTitle();?>" id="fullimagelnk">
		<?php
		}
		if (function_exists('printUserSizeImage') && isImagePhoto()) {
			printUserSizeImage(getImageTitle());
		} else {
			printDefaultSizedImage(getImageTitle());
		}
		if (isImagePhoto()) {
		?>
		</a>
		<?php
		}
		?>
		</strong>
		<?php
	if (function_exists('printUserSizeImage') && isImagePhoto()) printUserSizeSelectior(); ?>
	</div>
	<div class="clear"></div>
	<div id="narrow">
		<?php printImageDesc(true); ?>
		<?php if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('Fast Image Viewing')); ?>
		<hr /><br />
		<?php
			/*if (getImageEXIFData()) {echo "<div id=\"exif_link\"><a href=\"#TB_inline?height=345&amp;width=400&amp;inlineId=imagemetadata\" title=\"".gettext("Image Info")."\" class=\"thickbox\">".gettext("Image Info")."</a></div>";
				printImageMetadata('', false);
			}*/
		?>
		<?php printTags('links', gettext('<strong>Tags:</strong>').' ', 'taglist', ''); ?>
		<br clear=all />
		<?php if (function_exists('printImageMap')) printImageMap(); ?>
    	<?php if (function_exists('printRating')) { printRating(); }?>
		<?php if (function_exists('printShutterfly')) printShutterfly(); ?>

		<?php
		if (function_exists('printCommentForm')) {
			printCommentForm();
		}
		?>
	</div>
	<?php } ?>
        
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