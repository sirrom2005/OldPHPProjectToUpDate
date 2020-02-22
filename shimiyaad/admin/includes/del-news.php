<?php
$id = $_GET['id'];

$comObj->deleteData('news_articles','id',$id);

$mydir = "../images/content/news/$id/"; 
if(is_dir($mydir)){
	$d = dir($mydir); 
	while($entry = $d->read()) { 
	 if ($entry!= "." && $entry!= "..") { 
		unlink($mydir.$entry); 
	 } 
	} 
	$d->close(); 
	rmdir($mydir); 
}

echo "<script> location = 'index.php?action=news';</script>";
?>