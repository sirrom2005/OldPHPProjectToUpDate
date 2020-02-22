<?php
$pageKeywords	 	= "sitemaps, site maps, listing";
$pageDescription	= "videouploader.net sitemaps show page listing of the the entire site layout";

//$category 	= $obj->getCategory();
//$videoTagList = $obj->getVideoTags(2000);

$pTaglist 	= "";
$pTag 		= "";
if(!empty($videoTagList))
{
	foreach($videoTagList as $row)
	{
		$pTaglist .= $row['tags'].",";
	
	}
	$pTaglist = explode(",", $pTaglist);  
	$pTaglist = array_unique($pTaglist); 
}
?>
<ul class="sitemape">
	<li><a href="<?php echo DOMAIN;?>">Home</a></li>
    <li><a href="<?php echo DOMAIN;?>vci/">Upload video</a></li>
    <li><a href="<?php echo DOMAIN;?>about_video_uploader.html">About us</a></li>
    <li><a href="<?php echo DOMAIN;?>privacy_policy.html">Privacy Policy</a></li>
    <li><a href="<?php echo DOMAIN;?>terms_conditions.html">Terms and Conditions</a></li>
    <li><a href="<?php echo DOMAIN;?>register.html">Register</a></li>
    <li><a href="<?php echo DOMAIN;?>contact_us.html">Contact us</a></li>
    <li><a href="<?php echo DOMAIN;?>feedback.html">Feedback</a></li>
    <li><a href="<?php echo DOMAIN;?>sitemap.html">Sitemap</a></li>
    <li><a href="<?php echo DOMAIN;?>faqs.html">FAQs</a></li>
</ul>
<!--ul class="sitemape">
	<?php foreach($category as $cat){ ?>
	<li>
    	<a href="<?php echo DOMAIN;?><?php echo urlFix($cat['category']);?>/" title="<?php echo cleanString($cat['category']);?>" ><?php echo cleanString($cat['category']);?></a>
        <ol>
        	<?php 
				$categoryList = $obj->getVideoByCategory(str_replace("_", " ", $cat['category']),30);
				if(!empty($categoryList))
				{
					foreach($categoryList as $row)
					{ 
			?>
            		<li><a href="<?php echo DOMAIN.urlFix($cat['category'])."/".$row['url_title'].".html";?>"><?php echo cleanString(ucfirst(strtolower($row['title'])));?></a></li>
            <?php 
					}
				} 
			?>
        </ol>
    </li>
    <?php } ?>
</ul>
<ul class="sitemape">
	<li>
    	<a href="<?php echo DOMAIN;?>video_tags/">Video tags</a>
        <ol>
        	<?php foreach($pTaglist as $key => $value){ ?>
        	<li><a href="<?php echo DOMAIN;?>video_tags/<?php echo urlFix($value);?>.html" ><?php echo cleanString($value);?></a></li>
            <?php } ?>
        </ol>
    </li>
</ul-->
<br class="clearleft">