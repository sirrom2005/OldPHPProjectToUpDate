<?php
// force UTF-8
if (!defined('WEBPATH'))
	die();
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
    <?php if (class_exists('RSS')) printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
</head>
<body>
<?php include_once("includes/header.php");?>
<div id="title">
    <h1>
		<?php printHomeLink('', ' | '); ?> <a href="<?php echo html_encode(getGalleryIndexURL()); ?>" title="<?php echo ('Gallery Index'); ?>"><?php printGalleryTitle(); ?></a>
    </h1>
</div>
</div>
<div id="content">
		<?php
		$total = getNumImages() + getNumAlbums();
		if (!$total) {
			$_zp_current_search->clearSearchWords();
		}
		?>

		<?php
        if (($total = getNumImages() + getNumAlbums()) > 0) {
            if (isset($_REQUEST['date'])) {
                $searchwords = getSearchDate();
            } else {
                $searchwords = getSearchWords();
            }
            echo '<p>' . sprintf(gettext('Total matches for <em>%1$s</em>: %2$u'), html_encode($searchwords), $total) . '</p>';
        }
        $c = 0;
        ?>
        <div class="gallery">
            <?php
                while (next_album()) {
                $c++;
            ?>
                <a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php printAnnotatedAlbumTitle(); ?>">
                    <?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?>
                    <h2><?php printAlbumTitle(); ?></h2>
                    <h3><?php printAlbumDesc(); ?></h3>
                    <h4><b>dated added:</b> <?php printAlbumDate(""); ?></h4>
                    <?php //printTags('links', gettext('<strong>Tags:</strong>') . ' ', 'taglist', ''); ?>
                </a>
            <?php } ?>
        </div>
        
        <div id="gallery">
            <?php
                while (next_image()) {
                $c++;
            ?>
                <a href="<?php echo html_encode(getImageLinkURL()); ?>" title="<?php printBareImageTitle(); ?>">
                    <?php printImageThumb(getAnnotatedImageTitle()); ?>
                </a>
            <?php
            }
            ?>
        </div>
        
        <br clear="all" />
        <?php
			if ($c == 0) {
				echo "<p>" . gettext("Sorry, no image matches found. Try refining your search.") . "</p>";
			}
			printPageListWithNav("« " . gettext("prev"), gettext("next") . " »");
        ?>

		<?php include_once("includes/footer.php"); ?>
	</body>
</html>