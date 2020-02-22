<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php zp_apply_filter('theme_head'); ?>
    <meta name="description" content="partyaad.com the jamaican premiere site for your pictures events birthday parties, weddings, graduations, funerals music videos" >
	<meta name="keywords" content="video, videos, media, mp3, 3gp" >
    <meta name="author" content="rohan (iceman) morris" >
    <title><?php echo getBareGalleryTitle(); ?> :: Videos</title>
    <meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
    <link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />

    <!--script type="text/javascript" src="themes/default/js/swfobject.js"></script-->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="themes/default/js/excanvas/excanvas.js"></script>
    <![endif]-->
    <!--script type="text/javascript" src="themes/default/js/spinners/spinners.js"></script>
    <script type="text/javascript" src="themes/default/js/lightview/lightview.js"></script>
    <link rel="stylesheet" type="text/css" href="themes/default/styles/lightview/lightview.css" /-->
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
<div id="gallerytitle"><h2 id="eventspage"><?php echo gettext('Partyaad Videos'); ?></h2></div>
<div id="padbox">
		<?php
			$media = getMedia();
			if(!empty($media)){
		?>
		<div style="text-align:center;">
			<?php

				foreach($media as $key => $value){
			?>
                    <div class="latest_video">
                        <object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="260" height="250" codebase="http://www.apple.com/qtactivex/qtplugin.cab">
                            <param name="src" value="<?php echo 'albums/'.$value['folder'].'/'.$value['filename'];?>"/>
                            <param name="autoplay" value="false" />
                            <param name="type" value="video/quicktime" />
                            <param name="controller" value="true" />
                            <embed src="<?php echo 'albums/'.$value['folder'].'/'.$value['filename'];?>" width="260" height="250" scale="aspect" autoplay="false" controller"true" type="video/quicktime"
                            pluginspage="http://www.apple.com/quicktime/download/" cache="true"></embed>
                        </object>
                        <span><?php echo $value['title'];?></span>
                    </div>
			<?php
				}
			?>
		</div>
		<hr class="clear" />
        <div class="fb-like" data-href="http://partyaad.com/index.php?p=videos" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
		<?php } ?>
	</div>
</div>
<?php include_once('includes/footer.php'); ?>
</body>
</html>