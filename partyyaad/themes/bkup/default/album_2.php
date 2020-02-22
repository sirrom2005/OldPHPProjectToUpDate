<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php zp_apply_filter('theme_head'); ?>
    <meta name="description" content="partyaad.com the jamaican premiere site for your pictures events birthday parties, weddings, graduations, funerals" >
	<meta name="keywords" content="birthday parties, weddings, graduations, funerals, and other outdoor activities,dreamweekend,ati,yush,utech,uwi" >
    <meta name="author" content="rohan (iceman) morris" >
    <title><?php echo getBareGalleryTitle(); ?> | <?php echo getBareAlbumTitle(); ?></title>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
    <link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />
    <?php printRSSHeaderLink('Album', getAlbumTitle()); ?>
  
    <script type="text/javascript" src="themes/default/js/swfobject.js"></script>
    <!--[if lt IE 9]>
    	<script type="text/javascript" src="themes/default/js/excanvas/excanvas.js"></script>
    <![endif]-->
    <script type="text/javascript" src="themes/default/js/spinners/spinners.js"></script>
    <script type="text/javascript" src="themes/default/js/lightview/lightview.js"></script>
    <link rel="stylesheet" type="text/css" href="themes/default/styles/lightview/lightview.css" />
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php include_once('includes/header.php'); ?>
<?php zp_apply_filter('theme_body_open'); ?>
<div id="main">
    <div id="gallerytitle">
        <h2 id="gallerypage">
            <span>
                <a href="index.php?p=gallery" title="<?php echo gettext('Albums Index'); ?>"><?php echo getGalleryTitle(); ?></a> |
                <?php printParentBreadcrumb(); ?>
            </span>
            <?php printAlbumTitle(true); ?>
        </h2>
    </div>
    <div id="padbox">
        <?php printAlbumDesc(true); ?>
        <div id="albums">
            <?php while (next_album()): ?>
                <div class="album">
                    <div class="thumb">
                        <a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle(); ?>"><?php printAlbumThumbImage(getAnnotatedAlbumTitle()); ?></a>
                    </div>
                    <div class="albumdesc">
                        <h3><a href="<?php echo html_encode(getAlbumLinkURL()); ?>" title="<?php echo gettext('View album:'); ?> <?php echo getAnnotatedAlbumTitle(); ?>"><?php printAlbumTitle(); ?></a></h3>
                        <small><?php printAlbumDate(""); ?></small>
                        <div><?php printAlbumDesc(); ?></div>
                    </div>
                    <p style="clear: both; "></p>
                </div>
            <?php endwhile; ?>
        </div>
        <div id="images">
            <?php while (next_image()): ?>
                <div class="image">
                    <div class="imagethumb"><a href="<?php echo 'cache/'.$_zp_current_image->album->name.'/'.substr($_zp_current_image->filename, 0,-4).'_595.jpg'; ?>" title="<?php echo getBareImageTitle(); ?>" class="lightview" data-lightview-group="album" ><?php printImageThumb(getAnnotatedImageTitle()); ?></a></div>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="fb-like" data-href="http://partyaad.com" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
        <?php printPageListWithNav("&laquo; " . gettext("prev"), gettext("next") . " &raquo;"); ?>
        <?php printTags('links', gettext('<strong>Tags:</strong>') . ' ', 'taglist', ''); ?>

        <?php //if (function_exists('printGoogleMap')) printGoogleMap(); ?>
        <?php //if (function_exists('printSlideShowLink')) printSlideShowLink(gettext('View Slideshow')); ?>
        <?php //if (function_exists('printRating')) { printRating();} ?>
        <?php //if (function_exists('printCommentForm')) { printCommentForm(); } ?>
        
        <div id="comments">     
            <div id="disqus_thread"></div>
            <script type="text/javascript">
            /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
            var disqus_shortname = 'partyaad'; // required: replace example with your forum shortname
			var disqus_identifier = '<?php echo $_GET['album']; ?>';
			
            /* * * DON'T EDIT BELOW THIS LINE * * */
            (function() {
            var dsq = document.createElement('script'); 
			dsq.type = 'text/javascript'; 
			dsq.async = true;
            dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
            })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
            <a href="http://disqus.com" class="dsq-brlink">comments powered by <span class="logo-disqus">Disqus</span></a>
        </div>              
    </div>
</div>
<?php include_once('includes/footer.php'); ?>
</body>
</html>