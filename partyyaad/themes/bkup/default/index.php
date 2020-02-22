<?php
// force UTF-8 Ø
if (!defined('WEBPATH')) die(); $themeResult = getTheme($zenCSS, $themeColor, 'light');
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php zp_apply_filter('theme_head'); ?>
        <meta name="description" content="partyaad.com the jamaican premiere site for your pictures events birthday parties, weddings, graduations, funerals" >
		<meta name="keywords" content="photo gallery,birthday parties, weddings, graduations, funerals, and other outdoor activities,dreamweekend,ati,yush,utech,uwi" > 
        <meta name="author" content="rohan (iceman) morris" >
        <meta name="sitename" content="partyaad.com" />
        <meta name="copyright" content="<?php echo date('Y'); ?>" />
		<title><?php echo getBareGalleryTitle(); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo pathurlencode($zenCSS); ?>" type="text/css" />
		<?php printRSSHeaderLink('Gallery', gettext('Gallery RSS')); ?>
        
        <script language="javascript" type="text/javascript" src="themes/default/mediaplayer/jwplayer.js"></script>
        <script language="javascript" type="text/javascript" src="themes/default/js/swfobject.js"></script>
        <!--[if lt IE 9]>
          <script type="text/javascript" src="themes/default/js/excanvas/excanvas.js"></script>
        <![endif]-->
        <script type="text/javascript" src="themes/default/js/spinners/spinners.js"></script>
        <script type="text/javascript" src="themes/default/js/lightview/lightview.js"></script>
        <link rel="stylesheet" type="text/css" href="themes/default/styles/lightview/lightview.css" />
        <script src="themes/default/js/galleria-1.2.6.min.js"></script>
	</head>
	<body>
    	<?php include_once('includes/header.php'); ?>
		<?php zp_apply_filter('theme_body_open'); ?>
		<div id="main">
			<div id="padbox">
			<div id="ads_banner"></div>            
			<script type="text/javascript">
                var s4 = new SWFObject("themes/default/mediaplayer/imagerotator.swf","rotator","845","295","7");
                s4.addParam("allowfullscreen","true");
                s4.addParam("wmode","transparent");
                s4.addVariable("file","index.php?p=rotating_ads");
                s4.addVariable("width","845");
                s4.addVariable("height","295");
                s4.write("ads_banner");
            </script>

			<?php
            $media = getLatestMedia();
            if(!empty($media)){
            ?>
            <div class="latest_promo">
            <?php
                $v=1;
                foreach($media as $key => $value){
            ?>
                <div class="latest_video">
                    <span><?php echo $value['title'];?></span>
                    <div id="video_container<?php echo $v;?>">Loading player <?php echo $v;?></div>
                    <script type="text/javascript">
                    jwplayer("video_container<?php echo $v;?>").setup({
                    flashplayer: "themes/default/mediaplayer/player.swf",
                    file: "<?php echo 'albums/'.$value['folder'].'/'.$value['filename'];?>",
                    height: 250,
                    width:845
                    });
                    </script>
                </div>
            <?php 
                    $v++;
                }
            ?>
            </div>
             <?php } ?>
            <!--div class="latest_promo" style="padding-top:5px;">
                <iframe width="845px" height="300" src="http://www.youtube.com/embed/videoseries?list=PL99A1DF70B0CCB149&amp;hl=en_GB" frameborder="0" allowfullscreen></iframe>
            </div-->
            
           	<?php
           		$photoSlideShowL = getPhotoSlideShowLeft();
            	if(!empty($photoSlideShowL)){
            ?>
                <div id="galleriaL" style="height:320px;width:420px;float:left;">
                    <?php
                        foreach($photoSlideShowL as $key => $value){
                        $xt = explode('.',$value['filename']);
                        $fullImageURL = 'index.php?album='.urlencode($value['folder']).'&image='.substr(str_replace('_595', '', urlencode($value['filename'])), 0,-4).'.'.$xt[count($xt)-1];
                    ?>
                    <a href="<?php echo 'albums/'.$value['folder'].'/'.$value['filename'];?>">
                        <img src="<?php echo 'cache/'.$value['folder'].'/'.  substr($value['filename'], 0,-4).'_150_cw150_ch150_thumb.'.strtolower($xt[count($xt)-1]);?>" 
                        title="View <a href='<?php echo $fullImageURL;?>'><?php echo substr(strip_tags($value['title']),0,100);?></a>" 
                        alt="" 
                        rel="<?php echo 'cache/'.$value['folder'].'/'.substr($value['filename'], 0,-4).'_150_cw150_ch150_thumb.'.strtolower($xt[count($xt)-1]); ?>" />
                    </a>
                    <?php
                        }
                    ?>
                </div>
            <?php
           		}
            ?>
            <?php
           		$photoSlideShowR = getPhotoSlideShowRight();
            	if(!empty($photoSlideShowR)){
            ?>
                <div id="galleriaR" style="height:320px;width:420px;margin:0 0 2px 5px;float:left;">
                    <?php
                        foreach($photoSlideShowR as $key => $value){
                        $xt = explode('.',$value['filename']);
                        $fullImageURL = 'index.php?album='.urlencode($value['folder']).'&image='.substr(str_replace('_595', '', urlencode($value['filename'])), 0,-4).'.'.$xt[count($xt)-1];
                    ?>
                    <a href="<?php echo 'albums/'.$value['folder'].'/'.$value['filename'];?>">
                        <img src="<?php echo 'cache/'.$value['folder'].'/'.  substr($value['filename'], 0,-4).'_150_cw150_ch150_thumb.'.strtolower($xt[count($xt)-1]);?>" 
                        title="View <a href='<?php echo $fullImageURL;?>'><?php echo substr(strip_tags($value['title']),0,100);?></a>" 
                        alt="" 
                        rel="<?php echo 'cache/'.$value['folder'].'/'.substr($value['filename'], 0,-4).'_150_cw150_ch150_thumb.'.strtolower($xt[count($xt)-1]); ?>" />
                    </a>
                    <?php
                        }
                    ?>
                </div>
            <?php
           		}
            ?>
             <hr/>   
                <?php
                    $upEvts = getUpcomingEvent();
                    if(!empty($upEvts)){
                ?>
                <div class="boxSytle1">
                	<h2><a href="index.php?p=events" title="view partyaad.com events page">Upcoming Events</a></h2>
                    <div class="upcoming_events">
                    <?php

                        foreach($upEvts as $key => $value){
                    ?>
                        <div class="upcomingevents">
                            <a href="<?php echo 'albums/'.$value['folder'].'/'.$value['filename']; ?>" class="lightview"  data-lightview-group='events' >
                            	<?php $xt = explode('.',$value['filename']); ?>
                            	<img src="<?php echo 'cache/'.$value['folder'].'/'.  substr($value['filename'], 0,-4).'_150_cw150_ch150_thumb.'.strtolower($xt[count($xt)-1]); ?>" title="<?php echo strip_tags($value['desc']); ?>" alt="<?php echo strip_tags($value['desc']); ?>" />
                            </a>
                        </div>
                    <?php
                        }
                    ?>
                	</div>
                </div>
                <?php } ?>

				<div class="boxSytle1">
                <h2><a href="index.php?p=gallery" title="view partyaad.com photo gallery">Latest Albums</a></h2>
                <?php
                    // force UTF-8 Ø
                    global $_firstPageImages;
                    $np = getOption('images_per_page');
                    if ($_firstPageImages > 0)  {
                        $_firstPageImages = $_firstPageImages - 1;
                        $myimagepagestart = 1;
                    } else {
                        $_firstPageImages = $np - 1;
                        $myimagepagestart = 0;
                    }
                    $myimagepage = $myimagepagestart + getCurrentPage() - getTotalPages(true);
                    if ($myimagepage > 1 ) {
                        $link_slides = 2;
                    } else {
                        $link_slides = 1;
                    }
                    setOption('images_per_page', $np - $link_slides, false);
                    $_firstPageImages = NULL;
                    setOption('custom_index_page', 'gallery', false);
                    define('ALBUM_THUMB_WIDTH',250);
                    define('ALBUM_THUMB_HEIGHT',120);
                    define('ALBUM_THUMB_EVENT_WIDTH',250);
                    define('ALBUM_THUMB_EVENT_HEIGHT',150);
                    $counter = 0;
                    $_zp_gallery->setSortDirection(true);
                    $_zp_gallery->setSortType('ID');
                    while (next_album() and $counter < 6){
                ?>
                <div class="latestalbum">
                    <a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php printf(gettext("View album: %s"), getAnnotatedAlbumTitle());?>" class="img"><?php printCustomAlbumThumbImage(getAnnotatedAlbumTitle(), null, ALBUM_THUMB_WIDTH,ALBUM_THUMB_HEIGHT,ALBUM_THUMB_WIDTH,ALBUM_THUMB_HEIGHT); ?></a>
                    <h3><a href="<?php echo html_encode(getAlbumLinkURL());?>" title="<?php printf(gettext("View album: %s"),getAnnotatedAlbumTitle()); ?>"><?php printAlbumTitle(); ?></a></h3>
                    <!--p><?php //echo shortenContent(strip_tags(getAlbumDesc()), 50, '...'); ?></p-->
                    <small>Added: <?php printAlbumDate(); ?></small>
                </div>
                <?php
                    $counter++;
                    }
                ?>
                <hr class="clear" />
				</div>
                
                <?php
                $promotional = getPromotionalImages();
                if(!empty($promotional)){
                ?>
                <div class="boxSytle1">
                    <h2><a href="index.php?album=promotions" title="view partyaad.com promotional page" >Latest Promotions</a></h2>
                    <div class="latest_promo">
                    <?php
    
                        foreach($promotional as $key => $value){
                    ?>
                        <div class="latestpromo">
                            <a href="index.php?album=<?php echo $value['folder'];?>&image=<?php echo $value['filename'];?>" title="<?php echo strip_tags($value['title']); ?>" >
                                <?php $xt = explode('.',$value['filename']); ?>
                                <img src="<?php echo 'cache/'.$value['folder'].'/'.  substr($value['filename'], 0,-4).'_300_cw300_ch300_thumb.'.strtolower($xt[count($xt)-1]); ?>" title="<?php echo strip_tags($value['title']); ?>" alt="<?php echo strip_tags($value['title']); ?>" />
                            </a>
                        </div>
                    <?php
                        }
                    ?>
                    </div>
                    
                </div>
                <?php } ?>
               
			</div>
		</div>
        <?php include_once('includes/footer.php'); ?>
		<script>
			// Load the classic theme
			Galleria.loadTheme('themes/default/js/classic/galleria.classic.min.js');
			// Initialize Galleria
			$('#galleriaL').galleria({
				autoplay:true,
				transition: "fade",
    			transitionSpeed: 500,
				easing: "galleriaOut",
				imageCrop: true,
				thumbCrop: true,
				carousel: false,
			 	_toggleInfo: false
			});
			$('#galleriaR').galleria({
				autoplay:true,
				transition: "fade",
    			transitionSpeed: 500,
				easing: "galleriaOut",
				imageCrop: true,
				thumbCrop: true,
				carousel: false,
			 	_toggleInfo: false
			});
        </script>
	</body>
</html>
