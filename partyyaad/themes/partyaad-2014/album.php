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
    <?php if (class_exists('RSS')) printRSSHeaderLink('Album', getAlbumTitle()); ?>
</head>
<body id="gallery-page">
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
    
    <div class="gallery">
        <?php while (next_album()): ?>
        	<a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>">
				<h2><?php printAlbumTitle(); ?></h2>
				<?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?>
                <h3><?php printAlbumDesc(); ?></h3>
                <h4><b>dated added:</b> <?php printAlbumDate(""); ?></h4>
           	</a>
        <?php endwhile; ?>
    </div>

   	<div id="gallery">
        <?php while (next_image()): ?>
            <a href="<?php echo html_encode(getImageLinkURL()); ?>" title="<?php printBareImageTitle(); ?>">
                <?php printImageThumb(getAnnotatedImageTitle()); ?>
            </a>
        <?php endwhile; ?>
    </div>
    <br clear="all">
    <?php printAllTagsAs('cloud', 'content', 'results', false, true, 1, 10, 2,NULL,1); ?>
    <?php printPageListWithNav("« " . gettext("prev"), gettext("next") . " »"); ?>
    <?php printAlbumDesc(); ?>
    <span class="tagsss"><?php printTags('links', gettext('<lable>Image Tags:</lable>') . ' ', 'taglist', ''); ?></span>  
       
<?php include_once("includes/footer.php"); ?>
</body>
</html>