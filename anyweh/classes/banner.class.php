<?php
class banner extends mySqlDB
{	
	var $galleryDB = "";
	
	function banner(){ parent::mySqlDB(); }

	#################################--ZP GALLERY --#######################################
	function getLastWeekWinner()
	{	
		
		$sql = "SELECT i.id, i.filename, i.desc, a.folder, a.title AS albumTitle FROM {$this->galleryDB}.zp_images i INNER JOIN {$this->galleryDB}.zp_albums a ON i.albumid = a.id 
				WHERE i.custom_data = 'winner'
				LIMIT 1"; 
		return parent::executeQuery($sql, false);
	}
	
	function getHotGirlOfTheWeek()
	{		
		
		$sql = "SELECT i.id, i.filename, i.desc, a.folder, a.title AS albumTitle FROM {$this->galleryDB}.zp_images i INNER JOIN {$this->galleryDB}.zp_albums a ON i.albumid = a.id 
				WHERE i.custom_data = 'hott'
				LIMIT 2";
		return parent::executeQuery($sql, true);
	}
	
	function getPictureOfWeek()
	{	
		$sql = "SELECT i.filename, i.desc, a.folder, a.title AS albumTitle FROM {$this->galleryDB}.zp_images i INNER JOIN {$this->galleryDB}.zp_albums a ON i.albumid = a.id 
				WHERE i.custom_data = 'picture of the week'
				LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function getGoogleSlideShowPicture()
	{	
		$sql = "SELECT i.filename, i.desc, a.folder, a.title AS albumTitle FROM {$this->galleryDB}.zp_images i 
				INNER JOIN {$this->galleryDB}.zp_albums a ON i.albumid = a.id ORDER BY i.date DESC LIMIT 10";  
		return parent::executeQuery($sql, true);
	}
	
	function getLatestAlbums()
	{	
		$sql = "SELECT folder, title FROM {$this->galleryDB}.zp_albums ORDER BY id DESC LIMIT 10";  
		return parent::executeQuery($sql, true);
	}

	function zp_image_setting()
	{	
		
		$sql = "SELECT o.name, o.value FROM {$this->galleryDB}.zp_options o WHERE o.name IN ('thumb_size', 'thumb_crop_width', 'thumb_crop_height')"; 
		$dbResult = mysql_query($sql, $this->db);
	
		if($dbResult)
		{
			while( $row = mysql_fetch_assoc($dbResult) )
			{
				$data[$row['name']] = $row['value'];
			}
			return $data;
		}

		return false;
	}
	
	function getVidoeList()
	{	
		$sql = "SELECT i.id, i.filename, i.title, i.desc, i.date FROM {$this->galleryDB}.zp_images i 
				INNER JOIN {$this->galleryDB}.zp_albums a ON i.albumid = a.id 
				WHERE a.folder = 'videos' AND i.filename LIKE '%.flv' ORDER BY i.date DESC"; 
		return parent::executeQuery($sql, true);
	}
	
	function getVideoById($id)
	{	
		$sql2 = "UPDATE {$this->galleryDB}.zp_images SET hitcounter = hitcounter + 1 WHERE id = $id";
		if( parent::executeNoneQuery($sql2) )
		{
			$sql = "SELECT i.filename, i.title, i.desc, i.date, i.hitcounter FROM {$this->galleryDB}.zp_images i 
					INNER JOIN {$this->galleryDB}.zp_albums a ON i.albumid = a.id 
					WHERE i.id = $id LIMIT 1"; 
			return parent::executeQuery($sql, false);
		}
	}
	
	function getFeaturedVideo()
	{	
		$sql = "SELECT i.id, i.filename, i.title, i.desc, i.date FROM {$this->galleryDB}.zp_images i 
				INNER JOIN {$this->galleryDB}.zp_albums a ON i.albumid = a.id 
				WHERE a.folder = 'videos' AND i.custom_data='featured' ORDER BY RAND() LIMIT 1"; 
		return parent::executeQuery($sql, false);
	}
	function getAdvertisementVideo()
	{	
		$sql = "SELECT i.id, i.filename, i.title, i.desc, i.date FROM {$this->galleryDB}.zp_images i 
				INNER JOIN {$this->galleryDB}.zp_albums a ON i.albumid = a.id 
				WHERE a.folder = 'videos' AND i.custom_data='advertisement' ORDER BY RAND() LIMIT 1"; 
		return parent::executeQuery($sql, false);
	}
	#################################--HOTT GIRL--#######################################
	function voteForHottie($voteId, $fileName, $girl)
	{
		$fileName = base64_decode($fileName);
		$IP  = $_SERVER['REMOTE_ADDR'];	  		
		$sql = "INSERT INTO hott_girl_vote_count (id, image, ip, vote_date, girl) VALUES( \"$voteId\", \"$fileName\", \"$IP\" , NOW(), $girl )";		
		return parent::executeNoneQuery($sql);	
	}
	
	function getVoteResults($voteId, $ip=NULL)
	{
		/*return the total vote for the girls*/
		if( !empty($ip) )
		{
			$sql = "SELECT ip FROM hott_girl_vote_count 
					WHERE id = \"$voteId\" AND ip = '$ip'"; 
			$rs =  parent::executeQuery($sql, false);

			if(empty($rs)){ return false; }		
		}
		
		$sql = "SELECT girl, image, COUNT(image) AS amount FROM hott_girl_vote_count 
				WHERE id = \"$voteId\"
				GROUP BY image LIMIT 2"; 
		$rs =  parent::executeQuery($sql, true);
		
		if(empty($rs)){ return false; }
		
		$data = array();
		
		$num0 = (int)$rs[0]['amount'];
		$num1 = (int)$rs[1]['amount'];
		$total = $num0 + $num1;

		if( $total > 100)
		{
			$data[$rs[0]['girl']] = $num0 . " Vote(s)";
			$data[$rs[1]['girl']] = $num1 . " Vote(s)";	
		}
		else
		{
			$data[$rs[0]['girl']] = number_format($num0/$total*100, 0, ".", ",") . "%";
			$data[$rs[1]['girl']] = number_format($num1/$total*100, 0, ".", ",") . "%";
		}
		return $data;
	}
	
	
	##################################--BANNER--#######################################	
	function getBanner($bannerType)
	{	// AND enddate >= DATE_FORMAT(NOW(), '%Y-%m-%d')
		$sql = "SELECT id, banner, banner_size, banner_file_type, url FROM banner WHERE banner_type = '$bannerType' ORDER BY RAND() LIMIT 1"; 
		return parent::executeQuery($sql, false);
	}
	
	function getVideoBanner()
	{
		$sql = "SELECT id, banner, banner_size, banner_file_type, url FROM banner WHERE banner_type = '5' ORDER BY RAND() LIMIT 5"; 
		return parent::executeQuery($sql, true);
	}
	
	function getBannerList()
	{	
		$sql = "SELECT b.id, b.banner, b.url, b.banner_size, b.banner_file_type, bt.name FROM banner b  
				INNER JOIN banner_type bt ON bt.id = b.banner_type"; 
		return parent::executeQuery($sql, true);
	}
}
?>