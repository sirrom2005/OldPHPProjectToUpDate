<?php
// force UTF-8 Ø

if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php zp_apply_filter('theme_head'); ?>
        <meta name="description" content="partyaad.com the jamaican premiere site for your pictures events birthday parties, weddings, graduations, funerals" >
		<meta name="keywords" content="birthday parties, weddings, graduations, funerals, and other outdoor activities,dreamweekend,ati,yush,utech,uwi" >
		<title><?php echo getBareGalleryTitle(); ?> :: Contact Us</title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />
        <style>
        	#scanme{display:block; width:137px; text-align:center; color:#FF0000; font-size:15px; line-height:1em; font-weight:bold; margin-top:10px;}
			td strong{ color:#FF0000;}
			#main{ background-color:#FFFFFF;}
        </style>
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
        	<div id="gallerytitle"><h2 id="contactpage"><?php echo gettext('Partyaad Contact Information'); ?></h2></div>
            
            <div class="info">
                <h3><a href="http://www.partyaad.com">Partyaad.com</a></h3>
                <p>
                    The premiere site for all your pictures.<br />We cover all types of events such as birthday parties, weddings,
                    graduations, funerals, and other outdoor activities.<br />
                    For Bookings Contact us using any of the following methods below:<br />
                    <div class="fb-like" data-href="http://partyaad.com/index.php?p=contact" data-send="true" data-layout="button_count" data-width="450" data-show-faces="true" data-font="arial"></div>
                </p>
                <a name="skype"></a>
            </div>
            
            <div class="skype">
                <h3>Skype</h3>
                <p>
                    Connect to us on <a href="http://www.skype.com" target="_blank">skype</a> username: <u>drlucius2</u>
                </p>
                <a name="telephone"></a>
            </div>
            
            <div class="phone">
                <h3>Phone</h3>
                <p>
                    Contact us by phone:<br />
                    <acronym title="jamaica area code">1-(876)</acronym>-853-3345<br />
                    <acronym title="jamaica area code">1-(876)</acronym>-770-6966
                </p>
                <a name="bbpin"></a>
            </div>
            
            <div class="bbpin">
                <h3>Blackberry messenger</h3>
                <p>
                    Connect to us on Blackberry messenger: BBPin: <u>324CF926</u><br />
                    <span id="scanme">
                        BBPIN BARCODE SCAN NOW.
                        <img src="themes/default/images/bar-code.png" alt="BlackBerry Bar-Code scan now." title="BlackBerry Bar-Code scan now." />                    
                    </span>
                </p>
                <a name="email"></a>
            </div>           
            
            <div class="email">           	
                <h3><?php echo gettext('Contact us.') ?></h3>
                <?php printContactForm(); ?>
            </div>
		</div>
		<?php include_once('includes/footer.php'); ?>
	</body>
</html>
