<?php
class admin extends mySqlDB
{	
	function admin(){ parent::mySqlDB(); }
		
	function softwareToEnableCount()
	{
		$sql = "SELECT count(id) AS cnt FROM odb_product_item WHERE enable = '0'";
		return parent::executeQuery($sql, false);
	}
	
	function featuredSoftwareCount()
	{
		$sql = "SELECT count(id) AS cnt FROM odb_product_item WHERE featured = '1'";
		return parent::executeQuery($sql, false);
	}
	
	function getMemberCount()
	{
		$sql = "SELECT count(id) AS cnt FROM odb_account WHERE account_type = '3'";
		return parent::executeQuery($sql, false);
	}
	
	function getPublisherCount()
	{
		$sql = "SELECT count(id) AS cnt FROM odb_account WHERE account_type = '4'";
		return parent::executeQuery($sql, false);
	}
	
	function getReviewCount()
	{
		$sql = "SELECT count(id) AS cnt FROM odb_product_review WHERE section = '1' AND enable = '0'";
		return parent::executeQuery($sql, false);
	}
	
	function getNewsReviewCount()
	{
		$sql = "SELECT count(id) AS cnt FROM odb_product_review WHERE section = '2' AND enable = '0'";
		return parent::executeQuery($sql, false);
	}
}
?>