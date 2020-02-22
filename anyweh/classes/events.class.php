<?php
class events extends mySqlDB
{	
	function events(){ parent::mySqlDB(); }
		
	function getEventsByDate($date)
	{
		$sql = "SELECT id, title, banner FROM events WHERE 0=0 AND date = '$date' AND enable = '1'";
		return parent::executeQuery($sql, true);
	}
		
	function getEventsListing()
	{
		$sql = "SELECT id, title, date, description, banner FROM events ORDER BY date DESC";
		return parent::executeQuery($sql, true);
	}
	
	function deleteEvents($id, $file)
	{
		$this->deleteImg($file);
		$sql = "DELETE FROM events WHERE id = '$id'";	
		return parent::executeNoneQuery($sql);
	}
	
	function deleteEventImage( $file, $id )
	{
		$this->deleteImg($file);
		$sql = "UPDATE events SET banner='' WHERE id = '$id'";	
		return parent::executeNoneQuery($sql);
	}
	
	function deleteImg($file)
	{
		if( fileExists(EVENTS_IMG_PATH.$file) )
		{
			unlink(EVENTS_IMG_PATH.$file);
		}
		if( fileExists(EVENTS_IMG_PATH."200_$file") )
		{
			unlink(EVENTS_IMG_PATH."200_$file");
		}
		if( fileExists(EVENTS_IMG_PATH."104_$file") )
		{
			unlink(EVENTS_IMG_PATH."104_$file");
		}
	}
	
	function getPastEvent($date)
	{
		$sql = "SELECT * FROM events WHERE 0=0 
		AND date < '$date'
		AND DATE_FORMAT(date, '%m') =  DATE_FORMAT('$date', '%m') AND enable = '1'";
		return parent::executeQuery($sql, true);
	}
	
	function getUpComingEvent($limit)
	{
		$limit = (!empty($limit))? "LIMIT $limit" : "";
		$sql = "SELECT * FROM events WHERE 0=0 AND date >= DATE_FORMAT(NOW(), '%Y-%m-%d') AND enable = '1' AND free_post = '0' ORDER BY date ASC $limit";
		return parent::executeQuery($sql, true);
	}
	/*function getLatestEvent($limit=NULL)
	{
		$limit = (!empty($limit))? "LIMIT $limit" : "";
		$sql = "SELECT id, title,intro_text, date, banner FROM events WHERE 0=0 ORDER BY date DESC $limit";
		return parent::executeQuery($sql, true);
	}
	function getEventsById($id)
	{
		$sql = "SELECT title, date, intro_text, banner FROM events WHERE 0=0 AND id = '$id' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	*/
	
	function getComingEvent($date)
	{
		$sql = "SELECT * FROM events WHERE 0=0 
		AND date >= '$date'
		AND DATE_FORMAT(date, '%m') = DATE_FORMAT('$date', '%m') AND enable = '1'";
		return parent::executeQuery($sql, true);
	}
	
	function getEventForThisMonth($month)
	{
		$sql = "SELECT * FROM events WHERE DATE_FORMAT(date, '%m') = $month AND enable = '1'";
		return parent::executeQuery($sql, true);
	}
}
?>