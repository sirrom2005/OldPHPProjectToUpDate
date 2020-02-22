<?php
	$id = $_GET['id'];
	$rs = $comObj->getDataById("odb_artistes",$id);
	
	$data['photo'] = '';
	$comObj->updateRecord($data,"odb_artistes",$id);	
	
	if(file_exists(ARTISTE_IMG_PATH.$rs['photo']))
	{ 
		@unlink(ARTISTE_IMG_PATH.$rs['photo']);
		@unlink(ARTISTE_IMG_PATH.ARTISTE_SML_TMB."_".$rs['photo']);
		@unlink(ARTISTE_IMG_PATH.ARTISTE_MED_TMB."_".$rs['photo']);
		@unlink(ARTISTE_IMG_PATH.ARTISTE_LRG_TMB."_".$rs['photo']);
		$f = explode(".",$rs['photo']);
		$f = $f[0];
		@unlink(ARTISTE_IMG_PATH."tn_".$f.".png");
		@header("location: index.php?action=add_artiste&id=$id");
	}
?>