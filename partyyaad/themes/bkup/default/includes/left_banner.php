<div id="left-banner">
<?php if(empty($leftAds)){ ?>
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
	<a <?php echo (empty($leftAds[0]['location']))? '' : 'href="'.$leftAds[0]['location'].'" target="_blank" title="'.$leftAds[0]['location'].'"' ;?> ><img src="<?php echo albums.'/'.$leftAds[0]['folder'].'/'.$leftAds[0]['filename']; ?>" alt="<?php echo strip_tags($leftAds[0]['title']);?>" style="width:120px; height:600px;" /></a>
<?php } ?> 

<?php if(empty($leftAds2)){ ?>
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
	<a <?php echo (empty($leftAds2[0]['location']))? '' : 'href="'.$leftAds2[0]['location'].'" target="_blank" title="'.$leftAds2[0]['location'].'"' ;?> ><img src="<?php echo albums.'/'.$leftAds2[0]['folder'].'/'.$leftAds2[0]['filename']; ?>" alt="<?php echo strip_tags($leftAds2[0]['title']);?>" style="width:120px; height:600px;" /></a>
<?php } ?> 

<?php if(isset($_GET['p']) && $_GET['p'] == 'gallery' ){ ?>
	<?php if(empty($leftAds3)){ ?>
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
        <a <?php echo (empty($leftAds3[0]['location']))? '' : 'href="'.$leftAds3[0]['location'].'" target="_blank" title="'.$leftAds3[0]['location'].'"' ;?> ><img src="<?php echo albums.'/'.$leftAds3[0]['folder'].'/'.$leftAds3[0]['filename']; ?>" alt="<?php echo strip_tags($leftAds3[0]['title']);?>" style="width:120px; height:600px;" /></a>
    <?php } ?> 
<?php } ?> 
</div>