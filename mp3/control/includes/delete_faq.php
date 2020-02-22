<?php	
	if($comObj->deleteData("odb_faqs","id",$_GET['id'])){header("location: index.php?action=list_faqs");}
?>