<?php 
class report extends mySqlDB
{	
	function report(){parent::mySqlDB();}

	function getReport($id)
	{
		$sql = "SELECT t.date, a.id AS accId, a.fname AS fullname, mp3.title, t.credit_amount FROM odb_transaction t
				INNER JOIN odb_account a ON t.user_id = a.id
				INNER JOIN odb_mp3 mp3 ON t.mp3_id = mp3.id
				WHERE mp3.producer_id = $id";
		return parent::executeQuery($sql, true);
	}
		
	function salesReportForThisMonth()
	{
		$date = date("m", strtotime("-1 month"));
		$sql = "SELECT t.user_id, SUM(t.credit_amount) AS creditTotal FROM odb_transaction t WHERE 0=0 AND DATE_FORMAT(t.date, '%m') = $date GROUP BY t.user_id";
	echo $sql;	
		return parent::executeQuery($sql, true);
	}
	
	function addPaymentInfo($data)
	{
		if(empty($data)){return false;}

		foreach($data as $row)
		{
			$sql = "INSERT INTO odb_payment_history (user_id, credit_total, payment_date_period) 
					VALUES ({$row['user_id']}, {$row['creditTotal']}, now())";
			if(!parent::executeNoneQuery($sql))
			{
				echo $sql." :: ". mysql_error();
			}
		}
		return true;
	}
	
	function getUserPaymentHistory($id)
	{
		$sql = "SELECT p.* FROM odb_payment_history p WHERE p.user_id = '$id' ORDER BY p.payment_date_period DESC";
		return parent::executeQuery($sql, true);
	}
	
	/*function getReportByDate()
	{
		$sql = "SELECT t.transaction_date, t.items, a.fname, a.lname FROM odb_transaction t 
				INNER JOIN odb_account a ON t.user_id = a.id
				ORDER BY t.transaction_date DESC";
		return parent::executeQuery($sql, true);
	}
	
	function getReportByUser()
	{
		$sql = "SELECT t.transaction_date, t.items, a.fname, a.lname FROM odb_transaction t 
				INNER JOIN odb_account a ON t.user_id = a.id
				GROUP BY t.user_id ORDER BY a.lname ASC";
		return parent::executeQuery($sql, true);
	}
	
	function getMP3ByItems($items)
	{
		$sql = "SELECT title, credit_amount FROM odb_mp3 mp3 WHERE id IN ($items)";  
		return parent::executeQuery($sql, true);
	}
	
	function getMP3ByUserId($id)
	{
		$sql = "SELECT transaction_date, items FROM odb_transaction WHERE user_id = '$id'";  
		return parent::executeQuery($sql, true);
	}*/
}
?>