<?php
include_once("config/config.php");
$img = ARTISTE_IMG_URL.ARTISTE_MED_TMB."_".base64_decode($_GET['p']);
$stagename = base64_decode($_GET['a']);
$id = base64_decode($_GET['k']);
?>
<h4 align="center"><b><?php echo $stagename;?></b></h4>
<p align="center"><img src="<?php echo $img;?>" /></p>
<p align="center"><a href="artiste_info_<?php echo $id;?>.htm">View info</a></p>