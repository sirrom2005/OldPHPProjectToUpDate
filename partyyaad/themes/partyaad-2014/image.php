<?php
// force UTF-8 Ø
if (!defined('WEBPATH'))die();
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 ie"> <![endif]-->
<!--[if IE 7]> <html class="ie7 ie"> <![endif]-->
<!--[if IE 8]> <html class="ie8 ie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<html>
<head>
    <?php zp_apply_filter('theme_head'); ?>
    <?php printHeadTitle(); ?>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
    <link rel="stylesheet" href="<?php echo WEBPATH . '/' . THEMEFOLDER; ?>/partyaad-2014/styles/layout.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo WEBPATH . '/' . THEMEFOLDER; ?>/partyaad-2014/common.css" type="text/css" />
    <?php if (zp_has_filter('theme_head', 'colorbox::css')) { ?>
        <script type="text/javascript">
            // <!-- <![CDATA[
            $(document).ready(function() {
                $(".colorbox").colorbox({
                    inline: true,
                    href: "#imagemetadata",
                    close: '<?php echo gettext("close"); ?>'
                });
            });
            // ]]> -->
        </script>
    <?php } ?>
    <?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
</head>
<body id="image-page">
<?php include_once("includes/header.php");?>
<div id="title">
    <h1>
        <?php printHomeLink('', ''); ?>
        <a href="<?php echo WEBPATH;?>/index.php" title="<?php echo gettext('Albums Index'); ?>"><?php printGalleryTitle(); ?></a> |
        <?php printParentBreadcrumb(); ?>
        <?php printAlbumTitle(); ?>
    </h1>
</div>
</div>
<div id="content">
    <div class="nav">
        <?php if (hasPrevImage()) {?>
        <a class="imgprevious" href="<?php echo html_encode(getPrevImageURL()); ?>" title="<?php echo gettext("Previous Image"); ?>"></a>
        <?php } if (hasNextImage()) { ?>
        <a class="imgnext" href="<?php echo html_encode(getNextImageURL()); ?>" title="<?php echo gettext("Next Image"); ?>"></a>
        <?php } ?>
    </div>
    <div id="image">
		<?php $fullimage = (isImagePhoto())? getFullImageURL() : NULL ; ?>
        <a href="<?php echo (hasNextImage())? html_encode(getNextImageURL()) : "../?album={$_GET['album']}";?>" title="<?php printBareImageTitle(); ?>">
        <?php
        	if (function_exists('printUserSizeImage') && isImagePhoto()) {
        		printUserSizeImage(getImageTitle());
        	}else{
        		printDefaultSizedImage(getImageTitle());
        	}
        ?>
        </a>
        <div class="footer_banner">
            <script type="text/javascript"><!--
            google_ad_client = "ca-pub-9222115009045453";
            /* 468x60banner */
            google_ad_slot = "8060140279";
            google_ad_width = 468;
            google_ad_height = 60;
            //-->
            </script>
            <script type="text/javascript"
            src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
            </script>
        </div>

        <div class="info">
            <lable>Gallery Name</lable> <?php printAlbumBreadcrumb("", "");?>
            <lable>Image Name</lable> <?php printImageTitle();?>
            <lable>Descritpion</lable> <?php printImageDesc();?>
            <span class="tags"><?php printTags('links', gettext('<lable>Image Tags:</lable>') . ' ', 'taglist', ''); ?></span>
            <a href="<?php echo WEBPATH;?>/getimage.php?img=<?php echo 'albums/'.$_zp_current_image->album->name.'/'.$_zp_current_image->filename;?>" class="download">Download this image</a>
        </div>
    </div>
  
<?php include_once("includes/footer.php"); ?>
</body>
</html>
