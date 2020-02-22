<?php

class news extends mySqlDB
{	
	function news()
	{
		parent::mySqlDB();
	}
	
	function addNews($data)
	{
		$title 			= preFixString($data['title']);
		$intro_text		= preFixString($data['intro_text']);
		$detail 		= addslashes(trim($data['detail']));
		$news_image 	= $data['news_image'];
		$date 			= $data['date'];
		$date_added		= date("Y-m-d G:i:s");
		$article_type	= $data['article_type']; 
		$enable			= $data['enable'];
		
			
		$sql = "INSERT INTO news (title, intro_text, detail, news_image, date, date_added, article_type, enable) VALUES(\"$title\", \"$intro_text\", \"$detail\", \"$news_image\", \"$date\", \"$date_added\", \"$article_type\", \"$enable\" )";	
		return parent::executeNoneQuery($sql);
	}
	
	function updateNews( $data, $id )
	{
		$title 			= preFixString($data['title']);
		$intro_text		= preFixString($data['intro_text']);
		$detail 		= addslashes(trim($data['detail']));
		$news_image 	= $data['news_image'];
		$date 			= $data['date'];
		$article_type	= $data['article_type'];
		$enable			= $data['enable'];
		
		$sql = "UPDATE news SET title=\"$title\", intro_text=\"$intro_text\", detail=\"$detail\", news_image=\"$news_image\", date=\"$date\", article_type=\"$article_type\", enable=\"$enable\"  WHERE news_id = '$id'";	
		return parent::executeNoneQuery($sql);
	}
		
	function deleteNews( $id )
	{				
		$sql = "DELETE FROM news WHERE news_id = '$id'";	
		return parent::executeNoneQuery($sql);
	}
	
	function deleteNewsImage( $file, $id )
	{		
		$this-> deleteImg($file);
		$sql = "UPDATE news SET news_image='' WHERE news_id = '$id'";	
		return parent::executeNoneQuery($sql);
	}
	
	function deleteImg($file)
	{
		if( fileExists(NEWS_IMG_PATH."104_".$file) )
		{
			unlink(NEWS_IMG_PATH."104_".$file);
		}
		if( fileExists(NEWS_IMG_PATH."200_".$file) )
		{
			unlink(NEWS_IMG_PATH."200_".$file);
		}
	}
	
	function getNewsById($id)
	{
		$sql = "SELECT * FROM news WHERE news_id = '$id'";
		return parent::executeQuery($sql, false);
	}
	
	function getNewsListingForSite($limit=NULL)
	{
		$limit = ( !empty($limit) )? "LIMIT $limit" : "";
		
		$sql = "SELECT * FROM news WHERE 0=0 ORDER BY date DESC, news_id DESC $limit";
		return parent::executeQuery($sql, true);
	}
	
	function getNewsAndInfo($limit=NULL)
	{
		$limit = ( !empty($limit) )? "LIMIT $limit" : "";
		$sql = "SELECT news_id, title, intro_text FROM news WHERE 0=0 ORDER BY date DESC, news_id DESC $limit";
		return parent::executeQuery($sql, true);
	}
	
	function getNewsListing($country=NULL, $limit=NULL, $text=NULL)
	{
		$query      = ( !empty($limit) )? "LIMIT $limit" : "";
		$countrySql = (!empty($country))? "AND country_id = '$country'" : "";
		$query1       = ( !empty($text) )? "AND title LIKE \"%$text%\"" : "";
		
		$sql = "SELECT * FROM news WHERE 0=0 $countrySql $query1 ORDER BY date DESC, news_id DESC $query";
		return parent::executeQuery($sql, true);
	}
	
	###############################   POLL    #######################################
	function getPollQuestion()
	{
		$sql = "SELECT pollname FROM pollv2 ORDER BY id DESC LIMIT 1 ";
		$rs = parent::executeQuery($sql, false);
		
		if(!empty($rs))
		{		
			$sql = "SELECT question FROM {$rs[pollname]} LIMIT 1"; 
			$data = parent::executeQuery($sql, false);
			$data['id'] = $rs['pollname'];
			return $data;
		}
		return false;
	}
	
	function getEventReview($limit=NULL)
	{
		$limit = ( !empty($limit) )? "LIMIT $limit" : "";
		$sql = "SELECT * FROM news WHERE 0=0 AND article_type = '2' AND enable = '1' ORDER BY date DESC, news_id DESC $limit";
		return parent::executeQuery($sql, true);
	}
}
?> 