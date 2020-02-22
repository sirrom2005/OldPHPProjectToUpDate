<?php
header("Content-Type: text/xml");
include_once("config/config.php");
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
$obj = new site();
$rs = $obj->getRssFeed();
/*echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";*/
echo "<datalist title=\"jusbbmpins.com xml feed\" publisher=\"jusbbmpins.com\">\n";
if($rs){
	foreach($rs as $row){
?>
    <data>
		<title><?php echo $row['title'];?></title>
		<info><?php echo $row['info'];?></info>
        <url><?php echo DOMAIN.$row['url'];?></url>
    </data>
<?php 
	}
}
echo "</datalist>"; 
?>
