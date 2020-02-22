<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php zp_apply_filter('theme_head'); ?>
    <meta name="description" content="partyaad.com the jamaican premiere site for your pictures events birthday parties, weddings, graduations, funerals" >
	<meta name="keywords" content="birthday parties, weddings, graduations, funerals, and other outdoor activities,dreamweekend,ati,yush,utech,uwi" >
    <title><?php echo getBareGalleryTitle(); ?> | <?php echo getBareAlbumTitle(); ?> | <?php echo getBareImageTitle(); ?></title>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
    <link rel="stylesheet" href="themes/default/styles/light.css" type="text/css" />
    <?php if (zp_has_filter('theme_head', 'colorbox_css')) { ?>
        <script type="text/javascript">
            // <!-- <![CDATA[
            $(document).ready(function(){
                $(".colorbox").colorbox({
                    inline:true,
                    href:"#imagemetadata",
                    close: '<?php echo gettext("close"); ?>'
                });
            });
            // ]]> -->
        </script>
    <?php } ?>
    <?php printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
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
<?php zp_apply_filter('theme_body_open'); ?>
<?php include_once('themes/default/includes/header.php'); ?>
<div id="main">
	<div id="gallerytitle">
		<div class="imgnav">
			<?php if (hasPrevImage()) { ?>
				<div class="imgprevious"><a href="<?php echo html_encode(getPrevImageURL()); ?>" title="<?php echo gettext("Previous Image"); ?>">&laquo; <?php echo gettext("prev"); ?></a></div>
			<?php } if (hasNextImage()) { ?>
				<div class="imgnext"><a href="<?php echo html_encode(getNextImageURL()); ?>" title="<?php echo gettext("Next Image"); ?>"><?php echo gettext("next"); ?> &raquo;</a></div>
			<?php } ?>
		</div>
		<h2 id="promotionpage">
			<span>
				<?php
				printParentBreadcrumb("", " | ", " | ");
				printAlbumBreadcrumb("", " | ");
				?>
			</span>
			<?php printImageTitle(true); ?>
		</h2>
	</div>
	<!-- The Image -->
	<div id="image">
		<strong>
			<?php
			$fullimage = getFullImageURL();
			if (!empty($fullimage)) {
				?>
				<!--a href="<?php echo html_encode($fullimage); ?>" title="<?php echo getBareImageTitle(); ?>" class="lightview__" -->
					<?php
				}
				if (function_exists('printUserSizeImage') && isImagePhoto()) {
					printUserSizeImage(getImageTitle());
				} else {
					printDefaultSizedImage(getImageTitle());
				}
				if (!empty($fullimage)) {
					?>
				<!--/a-->
				<?php
			}
			?>
		</strong>
		<?php
		if (function_exists('printUserSizeImage') && isImagePhoto())
			printUserSizeSelector();
		?>
	</div>
	<div id="narrow">
    	<div class="fb-like" data-href="http://partyaad.com/index.php?album=<?php echo $_GET['album']; ?>&image=<?php echo $_GET['image']; ?>" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
		<?php printImageDesc(true); ?>
		<?php if (function_exists('printSlideShowLink'))
			printSlideShowLink(gettext('View Slideshow')); ?>
		<hr /><br />
		<?php
		printTags('links', gettext('<strong>Tags:</strong>') . ' ', 'taglist', '');
		?>
		<br clear="all" />
	</div>
    
   <div id="comments">     
        <div id="disqus_thread"></div>
        <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'partyaad'; // required: replace example with your forum shortname
        var disqus_identifier = '<?php echo $_GET['album'].'-'.$_GET['image']; ?>';
        
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
<?php include_once('themes/default/includes/footer.php'); ?>
</body>
</html>
