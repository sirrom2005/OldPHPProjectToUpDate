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
</head>
<body>
<?php include_once("includes/header.php");?>
<div id="title">
    <h1 class="links"><a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo gettext('Gallery Index'); ?>"><?php printGalleryTitle(); ?></a></h1>
</div>
</div>
<div id="content">

	<?php
    echo gettext("The Zenphoto object you are requesting cannot be found.");
    if (isset($album)) {
        echo '<br />' . sprintf(gettext('Album: %s'), html_encode($album));
    }
    if (isset($image)) {
        echo '<br />' . sprintf(gettext('Image: %s'), html_encode($image));
    }
    if (isset($obj)) {
        echo '<br />' . sprintf(gettext('Page: %s'), html_encode(substr(basename($obj), 0, -4)));
    }
    ?>

<?php include_once("includes/footer.php"); ?>
</body>
</html>
