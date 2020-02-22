<?php
	// Define the path to file
	$file = $_GET['f'];

	if(!file_exists($file))
	{
	 	// File doesn't exist, output error
	 	die('file not found');
	}
	else
	{
		$ext = explode(".", $file);
		$ext = $ext[1];
		$ext = ($ext == "txt")? "plain" : "csv" ;
	
		// Set headers
		header("Cache-Control: public");
		header("Content-Description: File Transfer");
		header("Content-Disposition: attachment; filename=$file");
		header("Content-Type: text/$ext");
		header("Content-Transfer-Encoding: binary");
		
		// Read the file from disk
		readfile($file);
	}
?>
