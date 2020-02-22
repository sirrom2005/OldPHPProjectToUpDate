<?php	
	$id = base64_decode($_GET['id']);
	$rs = $comObj->getDataById("odb_mp3",$id);	
	
	if( $comObj->deleteData("odb_mp3","id",$id) ) 
	{
		if(file_exists(UPLOADDIR."sample_{$id}.mp3")){ @unlink(UPLOADDIR."sample_{$id}.mp3"); }
		if(file_exists(UPLOADDIR.$rs['filename'])   ){ @unlink(UPLOADDIR.$rs['filename']);    }
		header("location: index.php?action=list_music");
	}
?>