<?php	
$rs = $siteObj->getArtisteInfo($_GET['id']);

$current = "home";
$title	= $rs['stagename'];

$img = ARTISTE_IMG_URL.ARTISTE_MED_TMB."_".$rs['photo'];
echo "<img align='left' src='$img'/>";
echo cleanString($rs['bio']);
?>