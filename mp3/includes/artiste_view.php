<?php
	$rs = $comObj->getDataById("odb_artistes", $_GET['id'] );
	echo "<h2>{$rs['stagename']}</h2>";
	echo "{$rs['bio']}";
?>