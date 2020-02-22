<?php
$id = $_GET['id'];
$f = base64_decode($_GET['v']);

$data['audio'] = '';
$comObj->updateRecord($data,'news_articles',$id);

if(file_exists("../images/content/news/$id/".$f))
{
	unlink("../images/content/news/$id/".$f);
}
echo "<script> location = 'index.php?action=add-news&id=".$id."';</script>";
?>