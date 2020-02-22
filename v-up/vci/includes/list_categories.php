<?php	
	$results = $obj->getCategory();
?>
<div class="leftside">
<h3>Manage videos categories.</h3>
<?php 
	$alt = true;
	foreach($results as $row){
	$alt 	= ($alt)? false : true;
	$style 	= ($alt)? "rowStyle1" : "rowStyle2";
?>
<div class="video_list <?php echo $style;?> ">
	<b>Title:</b> <?php echo cleanString($row['category']);?>
    <br class="clearleft" />
	<ul class="edit_list">
		<li><a href="index.php?action=edit_category&id=<?php echo base64_encode($row['category']);?>">Update</a></li>
	</ul>
	<br class="clearleft" />
</div>
<?php }?>
</div>
<div class="rightside">
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
</div>