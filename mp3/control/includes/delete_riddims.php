<?php	
	if($comObj->deleteData("odb_riddims","id",$_GET['id'])){header("location: index.php?action=list_riddims");}
?>