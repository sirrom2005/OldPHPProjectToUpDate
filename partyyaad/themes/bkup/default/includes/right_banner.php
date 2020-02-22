<div id="right-banner">
<?php if(empty($rightAds)){ ?>
	<script type="text/javascript"><!--
    google_ad_client = "ca-pub-0149830935764893";
    /* skyscraper-text */
    google_ad_slot = "9747601849";
    google_ad_width = 120;
    google_ad_height = 600;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
<?php }else{ ?> 
	<a <?php echo (empty($rightAds[0]['location']))? '' : 'href="'.$rightAds[0]['location'].'" target="_blank" title="'.$leftAds[0]['location'].'"' ;?> ><img src="<?php echo albums.'/'.$rightAds[0]['folder'].'/'.$rightAds[0]['filename']; ?>" alt="<?php echo strip_tags($rightAds[0]['title']);?>" style="width:120px; height:600px;" /></a>
<?php } ?> 


<?php if(empty($rightAds2)){ ?>
	<script type="text/javascript"><!--
    google_ad_client = "ca-pub-0149830935764893";
    /* skyscraper-image */
    google_ad_slot = "8797724801";
    google_ad_width = 120;
    google_ad_height = 600;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
<?php }else{ ?> 
	<a <?php echo (empty($rightAds2[0]['location']))? '' : 'href="'.$rightAds2[0]['location'].'" target="_blank" title="'.$rightAds2[0]['location'].'"' ;?> ><img src="<?php echo albums.'/'.$rightAds2[0]['folder'].'/'.$rightAds2[0]['filename']; ?>" alt="<?php echo strip_tags($rightAds2[0]['title']);?>" style="width:120px; height:600px;" /></a>
<?php } ?> 


<?php if(isset($_GET['p']) && $_GET['p'] == 'gallery' ){ ?>
	<?php if(empty($rightAds3)){ ?>
        <script type="text/javascript"><!--
        google_ad_client = "ca-pub-0149830935764893";
        /* skyscraper-image */
        google_ad_slot = "8797724801";
        google_ad_width = 120;
        google_ad_height = 600;
        //-->
        </script>
        <script type="text/javascript"
        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
    <?php }else{ ?> 
        <a <?php echo (empty($rightAds3[0]['location']))? '' : 'href="'.$rightAds3[0]['location'].'" target="_blank" title="'.$rightAds3[0]['location'].'"' ;?> ><img src="<?php echo albums.'/'.$rightAds3[0]['folder'].'/'.$rightAds3[0]['filename']; ?>" alt="<?php echo strip_tags($rightAds3[0]['title']);?>" style="width:120px; height:600px;" /></a>
    <?php } ?> 
<?php } ?> 
</div>