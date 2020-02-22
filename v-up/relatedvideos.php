<?php
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");

$id = $_GET['id'];
$obj = new site();
$result   = $obj->getVideoRecord($id,true);
$related  = $obj->getRelatedVideos($result);
if(count($related)<2)
{
	$related = $obj->getFeaturedVideo(10);
	if(empty($related)){exit();}
}

header("Content-Type: text/xml");
?>
<!--?xml version="1.0" encoding="utf-8"?-->
<videolist>
	<title>Related videos:</title>
	<?php
		$i=1;
    	foreach($related as $row)
		{ 
	?>
    <video id="<?php echo $i;?>">
		<title><?php echo $row['title'];?></title>
		<thumb><?php echo DOMAIN."videos/{$row['video']}/thumbnail1sml.jpg";?></thumb>
		<url><?php echo DOMAIN.urlFix($row['category'])."/{$row['url_title']}.html";?></url>		
	</video>
    <?php 
			$i++;
		} 
	?>
</videolist>