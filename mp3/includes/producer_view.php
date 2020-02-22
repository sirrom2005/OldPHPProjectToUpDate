<?php
	$rs = $comObj->getDataById("odb_account", $_GET['id'] );
	echo "<h2>{$rs['fname']} {$rs['lname']}</h2>";
	echo "{$rs['bio']}";
?>