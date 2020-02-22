<?php
$id = $_GET['id'];
$rt = $_GET['rt'];
$f = base64_decode($_GET['f']);

$comObj->deleteData('news_articles_images','id',$id);

if(file_exists("../images/content/news/$rt/".$f))
{
	unlink("../images/content/news/$rt/".$f);
	unlink("../images/content/news/$rt/100_".$f);
}
echo "<script> location = 'index.php?action=add-news&id=".$rt."';</script>";
?>