<?php include_once("../config/global.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo getBareGalleryTitle(); ?></title>    
	<style type="text/css"> 
	<!-- 
	@import url("<?php echo DOMAIN;?>css/layout.css");
	-->
	</style>
	<?php zenJavascript(); ?>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/slideshow.css" type="text/css" />
	<?php printSlideShowJS(); ?>
</head>

<body>
<?php include_once("includes/header.php"); ?>
	<div id="slideshowpage">
			<div id="gallerytitle" style="text-align:left;">
            <h2><a href="<?php echo DOMAIN;?>index.html" title="home">www.anyweh.com</a> &raquo; <span><?php printHomeLink('', ' &raquo; '); ?><a href="<?php echo htmlspecialchars(getGalleryIndexURL());?>" title="<?php gettext('Albums Index'); ?>"><?php echo getGalleryTitle();?>
                </a> &raquo; <?php printParentBreadcrumb("", " &raquo; ", " &raquo; "); printAlbumBreadcrumb("", ""); ?>
                </span>
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
        <?php printSlideShow(true,true); ?>
    </div>
<?php include_once("includes/footer.php"); ?>