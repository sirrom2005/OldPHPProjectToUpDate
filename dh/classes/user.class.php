<?php
class user extends mySqlDB
{
	var $thisDB =  "odb_account";
	
	function user(){ parent::mySqlDB(); }
	
	function userLogin( $username, $password )
	{		
		$data = NULL;	
		$sql = "SELECT us.id, us.account_type, us.user_name, us.email, us.no_time_limit FROM {$this->thisDB} us 
				WHERE us.user_name = '$username' AND us.password = md5('$password') AND us.enable = '1' LIMIT 1";
		$data = parent::executeQuery($sql, false);
		
		if(!empty($data))
		{
			$sql  = "SELECT login_date FROM odb_account_login_dates WHERE account_id = \"{$data['id']}\" ORDER BY login_date DESC LIMIT 1";
			$rs   = parent::executeQuery($sql, false);
			$data['last_login_date'] = $rs['login_date'];
		}
		
		if( !empty($data) )
		{ 
			if( $this->updateLoginDate($data['id']) )
				return $data;
		}
		return false;
	}
	
	function updateLoginDate($id)
	{
		$sql = "INSERT INTO odb_account_login_dates (account_id, login_date) VALUES('$id', NOW())";
		return parent::executeNoneQuery($sql); 
	}
	
	function userTimePeriod( $username, $password )
	{			
		$sql = "SELECT us.id FROM {$this->thisDB} us 
				WHERE us.user_name = '$username' AND us.password = md5('$password') AND end_date > NOW() AND us.enable = '1' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function getUserTypes()
	{			
		$sql = "SELECT id, title FROM odb_account_type WHERE info != 'Administrator'";
		return parent::executeQuery($sql, true);
	}
	
	function updateUserPassword( $password, $email )
	{		
		$sql = "UPDATE {$this->thisDB} SET password = md5('$password') WHERE 0=0 AND email = '$email'";
		return  parent::executeNoneQuery($sql);
	}
	
	function getUserByEmail( $email )
	{			
		$sql = "SELECT user_name FROM {$this->thisDB} WHERE email = '$email' LIMIT 1";
		return parent::executeQuery($sql, false);
	}
	
	function changePassword( $password, $id )
	{		
		$sql = "UPDATE {$this->thisDB} SET password = md5('$password') WHERE 0=0 AND id = '$id'";
		if( parent::executeNoneQuery($sql) )
		{
			$sql = "SELECT count(user_name) AS usCount FROM {$this->thisDB} WHERE 0=0 AND id = '$id' AND password = md5('$password')";
			return parent::executeQuery($sql, false);
		}
		return false;
	}

	function getUsers($data=NULL)
	{			
		$query1 = (empty($data['category']))? "" : "AND a.id = '{$data['category']}'";
		$order 	= (empty($data['ord']     ))? "" : "ORDER BY u.user_name {$data['ord']}";
		
		$sql = "SELECT u.id, u.user_name, a.title AS category FROM odb_account u 
				INNER JOIN odb_account_type a ON a.id = u.account_type WHERE 0=0 $query1 $order";
		return parent::executeQuery($sql, true);
	}
	
	function getUserCategories()
	{			
		$sql = "SELECT id, title AS category FROM odb_account_type WHERE 0=0 ORDER BY id";
		return parent::executeQuery($sql, true);
	}
}
?>