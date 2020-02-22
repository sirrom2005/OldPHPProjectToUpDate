<?php
	header("Vary: Accept-Encoding");
	if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip'))
	ob_start('ob_gzhandler');
	else ob_start();
	
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php" );
	include_once("../classes/banner.class.php");
	
	$bannerObj 	  = new banner();
?>
<html>
<head>
<style>
body{ margin:0; padding:0;}
</style>
</head>
<body>
<?php 
if($_GET['adsspace'] == 1)
{
	$ads	= $bannerObj->getBanner(1);
	if(empty($ads))
	{	
?>
		<script type="text/javascript"><!--
		google_ad_client = "pub-7769573252573851";
		/* wide_image_banner */
		google_ad_slot = "7284682713";
		google_ad_width = 468;
		google_ad_height = 60;
		//-->
		</script>
		<script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>
<?php
	}
	else
	{
		$img 		= base64_decode($ads['banner']);
		$logo_type	= $ads['banner_file_type'];
		
		$img = imagecreatefromstring($img);
		
		header("Expires: Mon, 23 Jul 1993 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Content-type: $logo_type");
		
		if( $logo_type == "image/jpeg" ){ imagejpeg($img, NULL, 100); }
		if( $logo_type == "image/gif"  ){ imagegif($img); }
		if( $logo_type == "image/png"  ){ imagepng($img); }
		imagedestroy($img);
	}
}

if($_GET['adsspace'] == 2)
{
?>
    <!-- Include the Google Friend Connect javascript library. -->
    <script type="text/javascript" src="http://www.google.com/friendconnect/script/friendconnect.js"></script>
    <!-- Define the div tag where the gadget will be inserted. -->
    <div id="div-735729120975585692" style="width:728px;"></div>
    <!-- Render the gadget into a div. -->
    <script type="text/javascript">
    google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
    google.friendconnect.container.renderAdsGadget(
     { id: 'div-735729120975585692',
       height: 90,
       site: '07788010716203665169',
       'prefs':{"google_ad_client":"ca-pub-7769573252573851","google_ad_host":"pub-6518359383560662","google_ad_slot":"1146152090","google_ad_format":"728x90"}
     });
    </script>
<?php
}

if($_GET['adsspace'] == 3)
{
?>
    <!-- Include the Google Friend Connect javascript library. -->
    <script type="text/javascript" src="http://www.google.com/friendconnect/script/friendconnect.js"></script>
    <!-- Define the div tag where the gadget will be inserted. -->
    <div id="div-5563679128382146782" style="width:160px;"></div>
    <!-- Render the gadget into a div. -->
    <script type="text/javascript">
    google.friendconnect.container.setParentUrl('/' /* location of rpc_relay.html and canvas.html */);
    google.friendconnect.container.renderAdsGadget(
     { id: 'div-5563679128382146782',
       height: 600,
       site: '07788010716203665169',
       'prefs':{"google_ad_client":"ca-pub-7769573252573851","google_ad_host":"pub-6518359383560662","google_ad_slot":"4420278418","google_ad_format":"160x600"}
     });
    </script>
<?php
}
?>
</body>
</html>	
<?php 
	ob_get_contents();
	ob_end_flush();
?>