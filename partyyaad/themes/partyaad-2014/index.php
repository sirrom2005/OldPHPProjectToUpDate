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
<head>
    <?php zp_apply_filter('theme_head'); ?>
    <?php printHeadTitle(); ?>
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
    <link rel="stylesheet" href="<?php echo WEBPATH . '/' . THEMEFOLDER; ?>/partyaad-2014/styles/layout.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo WEBPATH . '/' . THEMEFOLDER; ?>/partyaad-2014/common.css" type="text/css" />
    <?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
</head>
<body>
<?php include_once("includes/header.php");?>
<div id="title">
    <div class="links">
        <a href="2013/">2013 Gallery</a>
        <a href="2014/">2014 Gallery</a>
        <a href="gallery.html">Events</a>
    </div>
</div>
</div>
<div id="content">
    <div class="gallery">
        <?php while (next_album()): ?>
            <a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>">
                <?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?>
                <h2><?php printAlbumTitle(); ?></h2>
                <h3><?php printAlbumDesc(); ?></h3>
                <h4><b>dated added:</b> <?php printAlbumDate(""); ?></h4>
                <?php //printTags('links', gettext('<strong>Tags:</strong>') . ' ', 'taglist', ''); ?>
            </a>
        <?php endwhile; ?>
    </div>
    <?php printPageListWithNav("« " . gettext("prev"), gettext("next") . " »"); ?>
<?php include_once("includes/footer.php"); ?>
</body>
</html>