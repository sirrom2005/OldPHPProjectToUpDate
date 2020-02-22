<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta name="description" content="partyaad.com the jamaican premiere site for your pictures events birthday parties, weddings, graduations, funerals" >
        <meta name="keywords" content="birthday parties, weddings, graduations, funerals, and other outdoor activities,dreamweekend,ati,yush,utech,uwi" >
        <meta name="author" content="rohan (iceman) morris" >
		<title><?php echo getBareGalleryTitle(); ?> :: Welcome to partyaad.com photo gallery for birthday parties, weddings, graduations, funerals, and other outdoor activities</title>
        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-511ed55444f86c77"></script>
        <style>
        	body,p{margin:0; padding:0;}
			body{background:url(themes/default/images/home_bg.jpg) center 0;}
			#container{ width:900px; margin:5px auto;}
			#welcome{background:url(themes/default/images/partyaad_welcome.png) 0 40px no-repeat;width:750px;height:620px;}
			#house{
					text-align:center; 					 
					font-size:2em; 
					font-weight:bold; 
					width:750px; 
					margin:0 auto; 
					margin-bottom:10px; 
					position:relative; 
					top:-30px;
					z-index:0;
				 }
			p{text-align:center; font-size:13px; font-family:"Times New Roman", Times, serif; color:#FFFFFF;padding:5px; background-color:#333333; width:500px; margin:0 auto; border:1px solid #999999;}
			a.enter{background:url(themes/default/images/enter.png) 0 -62px; display:inline-block; width:353px; height:61px; margin-top:10px; }
			a.enter:hover{background-position:0 0;}
			a.bbpin{background:url(themes/default/images/partyyaad_bb_pin.png);      display:inline-block; width:140px; height:36px; z-index:99; position:relative; float:left; }
			a.phone{background:url(themes/default/images/partyaad_phone_number.png); display:inline-block; width:188px; height:44px; z-index:99; position:relative; float:right;}
			a{ color:#fff;}
			a:hover{ color:#2f4f04;}
        </style>
	</head>
	<body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-47847435-1', 'partyaad.com');
  ga('send', 'pageview');

</script>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    <div id="container">
    <a href="index.php?p=contact#bbpin" title="partyaad.com bb-pin" class="bbpin"></a>
    <a href="index.php?p=contact#telephone" title="partyaad.com phone number" class="phone"></a>
    <div id="house">
        <div id="welcome"></div>
        <div style="padding:10px 0 0 200px;margin:5px auto;">
            <span>
                <!-- AddThis Button BEGIN -->
                <div class="addthis_toolbox addthis_default_style ">
                <a class="addthis_button_facebook_like" fb:like:layout="button_count" fb:like:href="http://partyaad.com" ></a>
                <a class="addthis_button_tweet" tw:url="http://partyaad.com" ></a>
                <a class="addthis_button_pinterest_pinit"></a>
                <a class="addthis_counter addthis_pill_style"></a>
                </div>
                <!-- AddThis Button END -->
            </span>
        </div>
    	<br clear="all" /><a href="index.php?p=bill-board" class="enter" title="enter partyaad.com"></a>
    </div>
	</div>
    <p>
    All content Copyright <?php echo date('Y');?> <a href="http://www.partyaad.com/index.php">partyaad.com</a>. All Rights Reserved.<br />
    Text, images and all other content on this site may not be copied or republished in any way without formal permission. 
    </p>
	</body>
</html>
