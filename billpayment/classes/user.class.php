<?php
class user extends mySqlDB
{
	var $thisDB =  "admin_users";
	
	function user(){ parent::mySqlDB(); }
	
	function userLogin( $username, $password )
	{		
		$data = NULL;	
		$sql = "SELECT us.id, us.user_name FROM {$this->thisDB} us 
				WHERE us.user_name = '$username' AND us.password = md5('$password') AND us.enable = '1' LIMIT 1"; 
		$data = parent::executeQuery($sql, false);
				
		if( !empty($data) )
		{ 
			if( $this->updateLoginDate($data['id']) )
				return $data;
		}
		return false;
	}
	
	function updateLoginDate($id)
	{
		$sql = "UPDATE {$this->thisDB} SET last_login_date = NOW() WHERE id = '$id'";
		return parent::executeNoneQuery($sql); 
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
}
?>