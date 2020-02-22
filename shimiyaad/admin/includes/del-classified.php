<?php
$id = $_GET['id'];
$comObj->deleteData('classified','id',$id);

$mydir = "../images/content/classified/$id/"; 
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
echo "<script> location='index.php?action=classifieds'; </script>";
?>