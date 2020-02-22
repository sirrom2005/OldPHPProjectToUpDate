<?php
header("Content-type: image/png"); 
$f = $_GET['f'];
$background = imagecreatefromjpeg("49_$f");
$insert = imagecreatefrompng("frame.png"); 
imagecolortransparent($insert,imagecolorat($insert,15,15));
$insert_x = imagesx($insert); 
$insert_y = imagesy($insert); 		
$bg = imagecreatetruecolor(49, 50); 
$x = imagesx($bg); 
$y = imagesy($bg);
imagecopyresampled($bg, $background, 3, 5, 0, 0, 43, 42, $x, $y);			
imagecopymerge($bg,$insert,0,0,0,0,$insert_x,$insert_y,100); 
imagecolortransparent($bg,imagecolorat($bg,0,0));

$f = explode(".",$f);
$f = $f[0];
imagepng($bg,"tn_{$f}.png");
imagedestroy($bg);
header("location: ../../control/index.php?action=list_artiste"); 
?>