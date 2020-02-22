<?php
$id = $_GET['id'];
$f = base64_decode($_GET['f']);
$comObj->deleteData('event','id',$id);

if(file_exists("../images/content/events/$f"))
{
	unlink("../images/content/events/{$f}");
	unlink("../images/content/events/305_{$f}");
}
echo "<script> location = 'index.php?action=events';</script>";
?>