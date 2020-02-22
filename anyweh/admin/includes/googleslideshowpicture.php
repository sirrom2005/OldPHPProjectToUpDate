<?php		
	include_once("../classes/banner.class.php");
	
	$bannerObj 	= new banner();
	
	$slideShow	= $bannerObj->getGoogleSlideShowPicture();
	

	function re_size($file, $wsize=80, $hsize=NULL)
	{
		global $tmpFolder, $imageFolder;
	
		$size = $wsize.$hsize;

		include_once("../classes/image_resize_custom.php");
		$imgData['image'] 	= $file['filename'];
		$imgData['h'] 	= $hsize;	
		$thumb = new thumbNail( $imgData, $tmpFolder, $imageFolder.$file['folder']."/", $wsize );
		return $thumb->fileName;
	}
	
	$image = array();
	
	$i=0;
	foreach($slideShow as $row)
	{
		$image[$i]['img'] = re_size($row, 300, NULL); 
		$image[$i]['title'] = $row['albumTitle'];
		$i++;
	}
		
	$xml = "";
	if(!empty($image))
	{
		foreach( $image as $list )
		{
			$xml .= "<track>\n";
			$xml .= "\t<title></title>\n";
			$xml .= "\t<creator>http://www.anyweh.com/gallery</creator>\n";
			$xml .= "\t<location>http://www.anyweh.com/tmp_images/{$list['img']}</location>\n";
			$xml .= "\t<info>{$list['title']}</info>\n";
			$xml .= "</track>\n";
		}
	}
	
	function rssBase($xml, $file)
	{
		global $url;
		
		$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$content .= "<playlist version=\"1\" xmlns=\"http://xspf.org/ns/0/\">\n";
		$content .= "<trackList>\n";
		$content .= "$xml";
		$content .= "</trackList>\n";
		$content .= "</playlist>\n";
		
		$handle = fopen("../image_player/$file", 'w');
		if(fwrite($handle, $content) === FALSE)
		{
			exit("XML Write failed");
		}
		else{ echo "List created...";}
		fclose($handle); 
	}
	
   	rssBase($xml, "madrid.xml");
?>