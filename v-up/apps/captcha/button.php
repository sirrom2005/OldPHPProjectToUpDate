<?php
/* Author:Rohan morris
 * Date:30/5/2008
 */
class captcha
{
	var $bgFileName 	= "bg2.jpg";
	var $code			= NULL; 
	var $font			= "font/automatic.gdf";
	var $canvasWidth  	= 90;
	var $canvasHeight 	= 25;
	var $bgFile		 	= NULL;
	
	function captcha()
	{
		$this->paintImage();
	}
	
	
    function generateCode() 
	{
        $string = strtolower("abcdefghijkmnpqrstvwxyz1234567890");
        $i = 0;
        while($i < 3) 
		{ 
            $this->code .= substr($string, rand(0, strlen($string)-1), 1);
            $i++;
        }
        return $this->code;
    }
	
	function getCanvas(){ return imagecreate($this->canvasWidth, $this->canvasHeight); }
	
	function getFont()
	{	
		if( is_int($this->font) )
			return $this->font;

		$fnt = imageloadfont($this->font);
	
		if( $fnt )
			return $fnt;
		return (is_int($this->font))? $this->font : 5;	
	}
	
	function draw()
	{
		$this->bgFile	= $this->getCanvas(); 
		$bgColor 		= imagecolorallocate($this->bgFile, 0x00, 0x00, 0x00);
		$strColor 		= imagecolorallocate($this->bgFile, 0xD0, 0x9B, 0x9D);
		
		$this->getBackGroundImage();
		imagestring($this->bgFile, $this->getFont(), 0, 2, $this->generateCode(), $strColor);
	}
	
	function getBackGroundImage()
	{
		if(file_exists($this->bgFileName) && strlen($this->bgFileName)>4 )
		{
			$im = imagecreatefromjpeg($this->bgFileName);
			$x = imagesx($im);
			$y = imagesy($im);
			imagecopyresampled($this->bgFile, $im, 0, 0, 0, 0, $this->canvasWidth, $this->canvasHeight, $x, $y);
		}
	}
	
	function paintImage()
	{
		header("Expires: Mon, 23 Jul 1993 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Content-type: image/png");
		session_start();
		
		$this->draw();
		
		$_SESSION['CAP_CODE'] = $this->code;
		
		imagepng($this->bgFile);
		imagedestroy($this->bgFile);
	}
}

$obj = new captcha();
?>