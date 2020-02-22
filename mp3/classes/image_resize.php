<?php
/* AUTHOR: Rohan Morris
 * DATE:18/05/2008
 *
 * NOTES: class for resizing images to the browser this one does not save the thumnail
 * to a file. it mages will be resized proportionally to it original size, it sopport JPG, GIF, and PNG images.
 *
 * TO USE: To use this file simple pass the location of the image plus the width or the 
 * height of the new size of image, if the size of both width and heigth are use then width
 * will take priority. 
 * E.G. <img src="thumbnail.class.php?image=images/pi10002.jpg&w=300" /> 
*/
class thumbNail
{
	var $imageSrc 		= NULL;
	var $srcImgWidth 	= NULL;
	var $srcImgHeight 	= NULL;
	var $dstImgWidth 	= NULL;
	var $dstImgHeight 	= NULL;
	var $ext 			= NULL;
	var $path			= NULL;
	var $quality 		= 75;
	/* When using on a live server this can be set to an empty string 
	 * e.g. $webFolder = ""; 
	*/
	
	function thumbNail($imgData, $saveIn, $path, $ww)
	{
	    $this->path	= $path;	
		$img 		= $imgData['image'];
		$w 	 		= $ww;
		$h   		= $imgData['h'];
		$imgSrc 	= $this->path.$img;
 
		$this->isImageAvailable($img);
		$this->imageType( $imgSrc );
		$this->resized( $w, $h ); 
		$this->imageResize( $imgSrc, $saveIn, $w."_".$img );
	}
	
	function isImageAvailable($img)
	{
		if( file_exists($this->path.$img) )
			$this->ext = strtolower(ereg_replace(".*\.(.*)$", "\\1", $img));
		else 
			exit("<h1>Image not found!</h1>");
	}
	
	function imageType( $src )
	{
		if( $this->ext == "jpg" ){ $this->imageSrc = imagecreatefromjpeg($src); }
		if( $this->ext == "jpeg"){ $this->imageSrc = imagecreatefromjpeg($src); }
		if( $this->ext == "gif" ){ $this->imageSrc = imagecreatefromgif($src); }
		if( $this->ext == "png" ){ $this->imageSrc = imagecreatefrompng($src); }
	
		$this->srcImgWidth	= imagesx($this->imageSrc);
		$this->srcImgHeight	= imagesy($this->imageSrc);
	}
	
	function resized( $w=NULL, $h=NULL )
	{ 
		if( !empty($h) )
		{
 			$this->dstImgHeight = $h;
			$this->dstImgWidth  = $w;
		}
		else
		{ 
			$this->dstImgWidth  = $w;
			$this->dstImgHeight = ($w/$this->srcImgWidth)*$this->srcImgHeight;
		}
		$this->dstImgWidth  = ($this->dstImgWidth  < 1)? 1 : $this->dstImgWidth;
		$this->dstImgHeight = ($this->dstImgHeight < 1)? 1 : $this->dstImgHeight;
	}
	
	function imageResize( $src, $saveIn, $imgName )
	{
		$imgdest = imagecreatetruecolor( $this->dstImgWidth, $this->dstImgHeight );
		imagecopyresampled( $imgdest, $this->imageSrc, 0,0,0,0, $this->dstImgWidth , $this->dstImgHeight, $this->srcImgWidth, $this->srcImgHeight );
		
		header("Content-type: image/jpg");
		imagejpeg($imgdest, $saveIn.$imgName, $this->quality);
		if( $this->ext == "jpg" )
		{
			imagejpeg($imgdest, $saveIn.$imgName, $this->quality); 
		}
		if( $this->ext == "gif" )
		{ 
			//NOt really sure why but when I add the NULL parameter i get an error
			@imagegif($imgdest, $saveIn.$imgName); 
		}
		if( $this->ext == "png" )
		{
			@imagepng($imgdest, $saveIn.$imgName); 
		}
		@imagedestroy($imgdest);
		@imagedestroy($imageSrc);
	}
}

?>
