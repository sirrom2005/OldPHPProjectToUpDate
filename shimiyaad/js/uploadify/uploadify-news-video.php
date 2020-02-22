<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
// Define a destination
include_once("../../config/config.php"); //session_destroy();
include_once("../../classes/mySqlDB__.class.php");
include_once("../../classes/commonDB.class.php");

$commObj = new commonDB();
$targetFolder = $id = $_POST['folder']; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] .'/'. NEWSFOLDER . $targetFolder;
	
	if(!is_dir($targetPath)){mkdir($targetPath,0755);}
	
	// Validate the file type
	$fileTypes = array('mpeg','mpg','flv','avi'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	$img = time().'.'.strtolower($fileParts['extension']);
	$targetFile = rtrim($targetPath,'/') . '/' . $img;
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);	
		$data['video'] = $img;
		$commObj->updateRecord($data,'news_articles',$id);
		chmod($targetFile,0755);
		echo 1;
	} else {
		echo 'Invalid file type.';
	}
}
?>