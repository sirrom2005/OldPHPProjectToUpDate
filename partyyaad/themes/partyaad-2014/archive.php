<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie6 ie"> <![endif]-->
<!--[if IE 7]> <html class="ie7 ie"> <![endif]-->
<!--[if IE 8]> <html class="ie8 ie"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="">
<!--<![endif]-->
<head>
    <?php zp_apply_filter('theme_head'); ?>
    <?php printHeadTitle(); ?>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
    <link rel="stylesheet" href="<?php echo WEBPATH . '/' . THEMEFOLDER; ?>/partyaad-2014/styles/layout.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo WEBPATH.'/'.THEMEFOLDER; ?>/partyaad-2014/common.css" type="text/css" />
    <?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
</head>
<body>
<?php include_once("includes/header.php");?>
<div id="title">
    <h1 class="links">
		<?php printHomeLink('', ' | '); ?>
        <a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo gettext('Gallery Index'); ?>"><?php printGalleryTitle(); ?></a>
        <?php echo gettext("Archive View"); ?>
    </h1>
</div>
</div>
<div id="content">
        <div id="archive"><?php printAllDates(); ?></div>
        <div id="tag_cloud">
            <p><?php echo gettext('Popular Tags'); ?></p>
            <?php printAllTagsAs('cloud', 'tags'); ?>
        </div>
		<?php include_once("includes/footer.php"); ?>
	</body>
</html>
