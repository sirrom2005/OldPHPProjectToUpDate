<?php	
	if($comObj->deleteData("odb_news","id",$_GET['id'])){header("location: index.php?action=list_news");}
?>