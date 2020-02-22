<?php
// The header line informs the server of what to send the output
  // as. In this case, the server will see the output as a .png
  // image and send it as such
  header("Content-type: image/png"); 
  // Defining the background image. Optionally, a .jpg image could 
  // could be used using imagecreatefromjpeg, but I personally 
  // prefer working with png
  $background = imagecreatefromjpeg("dd.jpg");
  // Defining the overlay image to be added or combined.
  $insert = imagecreatefrompng("frame.png"); 
  // Select the first pixel of the overlay image (at 0,0) and use
  // it's color to define the transparent color
  imagecolortransparent($insert,imagecolorat($insert,15,15));
  // Get overlay image width and hight for later use
  $insert_x = imagesx($insert); 
  $insert_y = imagesy($insert); 
  // Combine the images into a single output image. Some people
  // prefer to use the imagecopy() function, but more often than 
  // not, it sometimes does not work. (could be a bug)
 
  $bg = imagecreatetruecolor(49, 50); 
  $x = imagesx($bg); 
  $y = imagesy($bg);
  imagecopyresampled($bg, $background, 3, 5, 0, 0, 43, 42, $x, $y);
  //imagecopy($bg,$insert,0,0,0,0,$insert_x,$insert_y); 
   
  imagecopymerge($bg,$insert,0,0,0,0,$insert_x,$insert_y,100); 
  imagecolortransparent($bg,imagecolorat($bg,0,0));
  // Output the results as a png image, to be sent to viewer's
  // browser. The results can be displayed within an HTML document
  // as an image tag or background image for the document, tables,
  // or anywhere an image URL may be acceptable.
  imagepng($bg,""); 
?>
