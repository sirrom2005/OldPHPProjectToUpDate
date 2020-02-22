<?php
	$id 	= base64_decode($_GET['id']);
	if( $comObj->deleteData( "odb_credit_cost", "id", $id )){ header("location: index.php?action=payment_credit");}
?>