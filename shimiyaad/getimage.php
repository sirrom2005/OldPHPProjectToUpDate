<?php
$file = $_GET['img'];
$suffix = explode('.',$file);
$suffix = $suffix[count($suffix)-1];
switch ($suffix) {
	case 'bmp':
		$suffix = 'wbmp';
	break;
	case 'jpg':
		$suffix = 'jpg';
	break;
	case 'png':
	case 'gif':
	case 'jpeg':
	break;
	default:
		//header('location: erro404.html');
	exit();
}
$xp = explode('/',$file);
$filename = $xp[count($xp)-1];
$loc = $_SERVER['DOCUMENT_ROOT'].'/images/content/events/'.$filename;
header('Expires: 0'); 
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$filename");
header("Content-Type: image/$suffix");
header('Content-Length: '.filesize($loc));
header("Content-Transfer-Encoding: binary");
header('Connection: close');
readfile($loc)
?>