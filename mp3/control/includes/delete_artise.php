<?php
	if( $comObj->deleteData( "odb_artistes", "id",$_GET['id'])){ header("location: index.php?action=list_artiste");}
?>