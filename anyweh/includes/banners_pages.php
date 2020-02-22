<?php
	include_once("../config/global.php");
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php" );
	include_once("../classes/banner.class.php");
	
	$bannerObj = new banner();
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
		if(is_object($bannerObj)){$ads = $bannerObj->getBanner(1);}
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
			print_img($ads);
		}
	}
	
	if($_GET['adsspace'] == 2)
	{
		if(is_object($bannerObj)){$ads = $bannerObj->getBanner(2);}
		if(empty($ads))
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
		else
		{
			print_img($ads);
		}
	}
	
	if($_GET['adsspace'] == 3)
	{
		if(is_object($bannerObj)){$ads = $bannerObj->getBanner(3);}
		if(empty($ads))
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
		else
		{
			print_img($ads);
		}
	}

	
	if($_GET['adsspace'] == 4)
	{
		if(is_object($bannerObj)){$ads = $bannerObj->getBanner(4);}
		if(empty($ads))
		{
?>	
	
	<script type="text/javascript"><!--
					google_ad_client = "pub-7769573252573851";
					/* 300x250_txt_img */
					google_ad_slot = "6699070243";
					google_ad_width = 300;
					google_ad_height = 250;
					//-->
					</script>
					<script type="text/javascript"
					src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>
<?php
		}
		else
		{
			print_img($ads);
		}
	}	
	
	function print_img($ads)
	{
		$logo_type	= $ads['banner_file_type'];
		$ext 		= str_replace("image/", "", $logo_type);
		$imgname 	= "../images/tmp_ads/{$ads['id']}_{$ads['banner_size']}.$ext";
	
		/*if(!file_exists($imgname))
		{
			$img 		= base64_decode($ads['banner']);
			$fp 		= fopen($imgname, "wb");
			fwrite($fp, $img, $ads['banner_size']);
			fclose($fp);
		}*/
		
		$url = str_replace("http://", "", $ads['url']);
		echo (empty($url))? "<img src='$imgname' border='0' />" : "<a href='http://$url' target='_blank'><img src='$imgname' border='0' /></a>";
	}
?>	
</body>
</html>